<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class ServerPlugin extends ActiveRecord
{
    // Configurable parameters

    static $_apiUrl = 'http://plugins.multicraft.org/api/v1';
    static $_refresh = array(
        'sources'       =>43200, // 12h
        'categories'    =>86400, // 24h
        'plugins'       =>3600,  //  1h
        'plugins_full'  =>172800,// 48h
    );

    // End Configurable parameters


    static $con = null;
    private $_info = null;
    private $_cached = false;
    private $_versions = false;
    private $_gameVersions = false;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function apiGet($cmd, $params = array())
    {
        $url = ServerPlugin::$_apiUrl.'/'.$this->source_id.'/'.urlencode($cmd);
        if (count($params))
            $url .= '?'.http_build_query($params);
        $page = @file_get_contents($url);
        if (!$page)
            return null;
        $parsed = CJSON::decode($page, true);
        if (!is_array($parsed))
            return null;
        return $parsed;
    }

    public function checkRefresh($type, $param = false)
    {
        if (!@ServerPlugin::$_refresh[$type])
            return false;
        $time = $this->getDbConnection()->createCommand('select `time` from `updated` where `name`=?');
        return ($time->queryScalar(array($type.($param ? '_'.$param : ''))) + ServerPlugin::$_refresh[$type]) < time();
    }

    public function refreshed($type, $param = false)
    {
        $cmd = $this->getDbConnection()->createCommand('replace into `updated` (`name`,`time`) values(?,?)');
        $cmd->execute(array($type.($param ? '_'.$param : ''), time()));
    }

    public function getDbConnection()
    {
        if (!ServerPlugin::$con)
        {
            try
            {
                ServerPlugin::$con = new CDbConnection('sqlite:'.dirname(__FILE__).'/../runtime/server_plugins.sqlite');
                ServerPlugin::$con->setActive(true);
            }
            catch (Exception $e)
            {
                throw new CHttpException(500, Yii::t('admin', 'The plugin browser requires the PHP PDO SQLite extension to be installed and enabled (pdo_sqlite).'));
            }
            try
            {
                ServerPlugin::$con->createCommand('select `id` from `source`')->queryScalar();
            }
            catch (Exception $e)
            {
                $sql = array(
                    'create table if not exists `source`(
                        `id` text primary key,
                        `name` text not null
                    )',
                    'create table if not exists `updated`(
                        `name` text primary key, `time` integer not null
                    )',
                    'create table if not exists `category_plugin`(
                        `source_id` text not null,
                        `category` text not null,
                        `plugin_id` text not null,
                        unique(`source_id`,`category`,`plugin_id`)
                    )',
                    'create table if not exists `category`(
                        `source_id` text not null,
                        `name` text not null,
                        unique(`source_id`, `name`)
                    )',
                    'create table if not exists `plugin`(
                        `source_id` text not null,
                        `id` text not null,
                        `name` text,
                        `stage` text,
                        `link` text,
                        `description` text,
                        `categories` text,
                        `updated` int,
                        `authors` text,
                        primary key(`source_id`, `id`)
                    )',
                );
                foreach ($sql as $s)
                    ServerPlugin::$con->createCommand($s)->execute();
            }
        }
        return ServerPlugin::$con;
    }

    public function tableName()
    {
        return 'plugin';
    }

    public function rules()
    {
        return array(
            array('id, name, categories, authors, stage, link, description, updated', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('mc', 'ID'),
            'name' => Yii::t('mc', 'Name'),
            'categories' => Yii::t('mc', 'Categories'),
            'authors' => Yii::t('mc', 'Authors'),
            'stage' => Yii::t('mc', 'Stage'),
            'link' => Yii::t('mc', 'Plugin Page'),
            'description' => Yii::t('mc', 'Description'),
            'updated' => Yii::t('mc', 'Updated'),
            'authors' => Yii::t('mc', 'Authors'),
        );
    }

    public function search($server_id = 0)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('`source_id`',$this->source_id);
        $criteria->compare('`id`',$this->id);
        $criteria->compare('`name`',$this->name,true);
        $criteria->compare('`stage`',$this->stage,true);
        $criteria->compare('`link`',$this->link,true);
        $criteria->compare('`description`',$this->description,true);
        $criteria->compare('`updated`',$this->updated);
        $criteria->compare('`authors`',$this->authors);

        if ($this->categories)
        {
            $this->checkCategory($this->categories);
            $criteria->addCondition('`id` in (select `plugin_id` from `category_plugin` where `source_id`=:src and `category`=:cat)');
            $criteria->params[':src'] = $this->source_id;
            $criteria->params[':cat'] = $this->categories;
        }

        if ($server_id)
        {
            $c = Yii::app()->bridgeDb->createCommand('select `name` from `bgplugin` where `server_id`=? and `name` like ? and `version`!=\'\'');
            function rn($n) { return preg_replace('/^[^\/]+\//', '', $n); }
            $names = array_map('rn', $c->queryColumn(array($server_id, $this->source_id.'/%')));
            if ($this->source_id == 'bukkit') //compatibility
            {
                $c = Yii::app()->bridgeDb->createCommand('select `name` from `bgplugin` where `server_id`=? and `name` not like ? and `version`!=\'\'');
                $names += $c->queryColumn(array($server_id, '%/%'));
            }
            $criteria->addInCondition('`id`', $names);
        }

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>20),
            'sort'=>array('defaultOrder'=>'updated desc'),
        ));
    }

    public function complete()
    {
        if ($this->authors || $this->categories || $this->link)
            return;
        if (!($info = ServerPlugin::apiGet('plugin', array('id'=>$this->id))))
            return;
        $this->authors = implode(', ', @$info['authors']);
        $this->categories = implode(' ', @$info['categories']);
        $this->link = @$info['link'];
        $this->description = @$info['description'];
        $this->save();
        return;
    }

    private function getCache()
    {
        if ($this->_cached)
            return $this->_cached;
        return ($this->_cached = ServerPlugin::apiGet('plugin_versions', array('id'=>$this->id)));
    }

    public function getSources()
    {
        $cmd = $this->getDbConnection()->createCommand('select `id`,`name` from `source`');
        $srcs = $cmd->queryAll();
        if (!count($srcs) || $this->checkRefresh('sources'))
        {
            if (!($srcList = ServerPlugin::apiGet('sources')))
                return $srcs;

            Yii::log('Pluginlist: Building source information');
            $trans = $this->getDbConnection()->beginTransaction();
            $this->getDbConnection()->createCommand('delete from `source`')->execute();
            $cmd = $this->getDbConnection()->createCommand('insert into `source` (`id`,`name`) values(?,?)');

            $srcs = array();
            foreach ($srcList as $k=>$v)
            {
                $cmd->execute(array($k, $v));
                $srcs[] = array('id'=>$k, 'name'=>$v);
            }

            Yii::log('Pluginlist: Added '.count($srcs).' sources');
            $this->refreshed('sources');
            $trans->commit();
            Yii::log('Pluginlist: Done building source information');
        }
        return $srcs;
    }

    public function checkCategory($cat)
    {
        $cmd = $this->getDbConnection()->createCommand('select `name` from `category` where `source_id`=? and `name` like ?');
        $cat = $cmd->queryScalar(array($this->source_id, $cat));
        if (!$cat)
            return false;
        $cmd = $this->getDbConnection()->createCommand('select count(*) from `category_plugin` where `source_id`=? and `category`=? limit 1');
        if (!$cmd->queryScalar(array($this->source_id, $cat)))
        {
            Yii::log('Pluginlist: Updating category '.$cat);
            if (!($ps = ServerPlugin::apiGet('category_plugins', array('category'=>$cat))))
                return false;

            $trans = $this->getDbConnection()->beginTransaction();
            $cmd = $this->getDbConnection()->createCommand('insert into `category_plugin` (`source_id`,`category`,`plugin_id`) values(?,?,?)');
            foreach ($ps as $p)
                $cmd->execute(array($this->source_id, $cat, $p));

            $trans->commit();
            Yii::log('Pluginlist: Done updating category');
        }
        return true;
    }

    public function checkPlugins()
    {
        if ($this->checkRefresh('plugins', $this->source_id))
            $upd = $this->getDbConnection()->createCommand('select max(`updated`) from `plugin` where `source_id`=?')
                ->queryScalar(array($this->source_id));
        else if ($this->checkRefresh('plugins_full', $this->source_id))
            $upd = 0;
        else
            return;

        if (($list = ServerPlugin::apiGet('plugins', $upd ? array('since'=>$upd) : array())) === false)
            return;

        $trans = $this->getDbConnection()->beginTransaction();
        if (count($list))
        {
            Yii::log('Pluginlist: Inserting '.count($list).' plugins since '.$upd);
            if (!$upd)
                $this->getDbConnection()->createCommand('delete from `plugin` where `source_id`=?')->execute(array($this->source_id));
            $cmd = $this->getDbConnection()->createCommand('replace into `plugin` (`source_id`,`id`,`name`,`stage`,`updated`,`description`) values(?,?,?,?,?,?)');
            foreach ($list as $p)
            {
                if (!@$p['id'])
                    continue;
                $cmd->execute(array($this->source_id, $p['id'], @$p['name'] ? $p['name'] : $p['id'], @$p['stage'], @$p['updated'], @$p['description']));
            }
        }
        $this->refreshed('plugins'.($upd ? '' : '_full'), $this->source_id);
        $trans->commit();
        Yii::log('Pluginlist: Done inserting plugins');
    }

    public function getAllCategories()
    {
        $cmd = $this->getDbConnection()->createCommand('select `name` from `category` where `source_id`=?');
        $cats = $cmd->queryColumn(array($this->source_id));
        if (!count($cats) || $this->checkRefresh('categories'))
        {
            if (!($catList = ServerPlugin::apiGet('categories')))
                return $cats;

            Yii::log('Pluginlist: Building category information');
            $trans = $this->getDbConnection()->beginTransaction();
            $this->getDbConnection()->createCommand('delete from `category` where `source_id`=?')->execute(array($this->source_id));
            $this->getDbConnection()->createCommand('delete from `category_plugin` where `source_id`=?')->execute(array($this->source_id));
            $cmd = $this->getDbConnection()->createCommand('insert into `category` (`source_id`,`name`) values(?,?)');

            $cats = array();
            foreach ($catList as $c)
            {
                $cmd->execute(array($this->source_id, $c));
                $cats[] = $c;
            }

            Yii::log('Pluginlist: Added '.count($cats).' categories');
            $this->refreshed('categories');
            $trans->commit();
            Yii::log('Pluginlist: Done building category information');
        }
        return $cats;
    }

    public function getVersion()
    {
        if ($v = $this->getCache())
            return @$v[0]['version'];
        return '';
    }

    private function buildVersions()
    {
        if (!$this->_versions || !$this->_gameVersions)
        {
            $versions = array();
            $gameVersions = array();
            if (!($vList = $this->getCache()))
                return;
            foreach ($vList as $v)
            {
                $versions[substr($v['id'], 0, 32)] = $v;
                foreach ((is_array($v['game_versions']) ? $v['game_versions'] : array()) as $gv)
                {
                    $gv = preg_replace('/^\s*cb\s*/i', '', $gv);
                    if (!isset($gameVersions[$gv]))
                        $gameVersions[$gv] = array();
                    $gameVersions[$gv][] = $v['version'];
                }
            }
            $this->_versions = $versions;
            uksort($gameVersions, 'version_compare');
            $this->_gameVersions = array_reverse($gameVersions, true);
        }
    }

    public function getVersions()
    {
        $this->buildVersions();
        return is_array($this->_versions) ? $this->_versions : array();
    }

    public function getGameVersions()
    {
        $this->buildVersions();
        return is_array($this->_gameVersions) ? $this->_gameVersions : array();
    }

    public function getInfoName()
    {
        return $this->source_id.'/'.$this->id;
    }
}
