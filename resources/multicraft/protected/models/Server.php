<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class Server extends ActiveRecord
{
/*
    int $id
    string $name
    string $ip
    int $port
    string $dir
    string $world
    int $players
    int $memory
    int $start_memory
    string $jarfile
    string $autostart
    string $default_level
    int $daemon_id
    int $announce_save
    int $kick_delay
    int $suspended
    int $autosave
    string $jardir
    string $template
    string $setup
    string $prev_jarfile
    string $params
    string $crash_check
    int $disk_quota
    string $domain
    int $cpus
 */

    private $playersCached = false;
    private $prevDaemon = 0;
    private $prevDomain = '';
    private $prevIp = '';
    private $prevPort = '';
    private $_mysqlInfo = false;
    public $searchOwner = '';
    public $sendData = false;

    public $deleteDir = false; ///Set to 'yes' to delete base directory when the model is deleted

    static function getJardirs($idx = false)
    {
        static $v = false;
        if (!$v)
        {
            $v = array(
                'daemon'=>Yii::t('mc', 'Daemon JAR directory'),
                'server'=>Yii::t('mc', 'Server JAR directory*'),
                'server_base'=>Yii::t('mc', 'Server base directory*'),
            );
        }
        if ($idx !== false)
            return @$v[$idx];
        return $v;
    }

    static function getCrashCheckModes($idx = false)
    {
        static $v = false;
        if (!$v)
        {
            $v = array(
                ''=>Yii::t('mc', 'Use default settings'),
                'strict'=>Yii::t('mc', 'Strict crash detection'),
                'basic'=>Yii::t('mc', 'Basic crash detection'),
                'disable'=>Yii::t('mc', 'Disable crash detection'),
            );
        }
        if ($idx !== false)
            return @$v[$idx];
        return $v;
    }

    static function getSetupOptions($idx = false)
    {
        static $v = false;
        if (!$v)
        {
            $v = array(
                ''=>Yii::t('mc', 'No template setup'),
                'install'=>Yii::t('mc', 'Setup template on next restart'),
                'install,delete'=>Yii::t('mc', 'DELETE all files and setup template on next restart'),
                'delete'=>Yii::t('mc', 'DELETE all files on next restart'),
                'install,always'=>Yii::t('mc', 'Setup template on EVERY restart'),
                'install,delete,always'=>Yii::t('mc', 'DELETE all files and setup template on EVERY restart'),
                'delete,always'=>Yii::t('mc', 'DELETE all files on EVERY restart'),
            );
        }
        if ($idx !== false)
            return @$v[$idx];
        return $v;
    }

    public function init()
    {
        $this->memory = '';
        $this->start_memory = '';
        $this->port = '';
        if (isset($this->domain))
            $this->domain = '';

        $defaults = @include(dirname(__FILE__).'/../config/server_defaults.php');
        if (!is_array(@$defaults['server']))
            return;
        foreach ($defaults['server'] as $attr=>$value)
        {
            if ($value === null)
                continue;
            $this->{$attr} = $value;
        }
    }

    public function afterFind()
    {
        $this->prevDaemon = $this->daemon_id;
        if (isset($this->domain))
            $this->prevDomain = $this->domain;
        $this->prevIp = $this->ip;
        $this->prevPort = $this->port;
        return parent::afterFind();
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->bridgeDb;
    }

    public function tableName()
    {
        return 'server';
    }

    public function rules()
    {
        $rules = array(
            /* User */
            array('kick_delay, announce_save, kick_delay', 'numerical', 'integerOnly'=>true),
            array('name', 'length'),
            array('world', 'length', 'max'=>128),
            array('world', 'match', 'pattern'=>'/^[^\/\\\?%\*:"\'<>\0\n]+$/',
                'message'=>Yii::t('mc', 'The world name contains invalid characters.')),
            array('name', 'filter', 'filter' => 'trim'),
            array('domain', 'match', 'pattern'=>'/^([a-z0-9]+\\.('.implode('|', array_map('preg_quote', $this->domains())).')|$)/i',
                'message'=>Yii::t('mc', 'Invalid subdomain name, only numbers and letters are allowed')),
            array('domain', 'length', 'min'=>3, 'max'=>60),
            /* Superuser */
            array('ip, dir, jarfile, autostart', 'length', 'max'=>128, 'on'=>'superuser'),
            array('jardir', 'length', 'max'=>16, 'on'=>'superuser'),
            array('crash_check', 'length', 'max'=>32, 'on'=>'superuser'),
            array('ip', 'filter', 'filter' => 'trim', 'on'=>'superuser'),
            array('port, players, memory, start_memory, default_level, daemon_id, autosave, disk_quota, cpus', 'numerical',
                'integerOnly'=>true, 'on'=>'superuser'),
            array('port', 'numerical', 'min'=>1024, 'max'=>65535, 'on'=>'superuser'),
            array('players', 'numerical', 'min'=>1, 'on'=>'superuser'),
            array('dir', 'match', 'pattern'=>'/^[-_\w\d .!()]+$/',
                'message'=>Yii::t('mc', 'The base directory contains invalid characters.'), 'on'=>'superuser'),
            array('setup, template', 'safe',  'on'=>'superuser'),
            /* Search */
            array('id, name, ip, port, dir, players, memory, start_memory, jarfile, autostart, default_level,'
                .' daemon_id, announce_save, kick_delay, suspended, autosave, searchOwner, jardir, crash_check, disk_quota, cpus',
                'safe', 'on'=>'search'),
        );
        if (@Yii::app()->params['user_subdomains_invalid'])
        {
            $rules[] = array('domain', 'match', 'not'=>true, 'pattern'=>'/'.Yii::app()->params['user_subdomains_invalid'].'/',
                'message'=>Yii::t('mc', 'This subdomain name cannot be used'));
        }
        return $rules;
    }

    public function domains()
    {
        return array_map('trim', explode(',', Yii::app()->params['user_subdomains_domain']));
    }

    public function checkDir()
    {
        if (!$this->dir)
        {
            $dir = 'server'.$this->id;
            if (!$this->dirUnique($dir))
            {
                for ($i = 97; $i <= 122; $i++)
                {
                    if ($this->dirUnique($dir.chr($i)))
                    {
                        $this->dir = $dir.chr($i);
                        break;
                    }
                }
            }
            else
                $this->dir = $dir;

            if (!$this->dir)
                $this->dir = 'server'.md5($this->id.'_'.rand());

            $this->isNewRecord = false;
            $this->saveAttributes(array('dir'));
        }
    }

    public function dirUnique($dir)
    {
        $sql = 'select `id` as id from `server` where `daemon_id`=? and `dir`=?';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $cmd->bindValue(1, $this->daemon_id);
        $cmd->bindValue(2, $dir);
        $cols = $cmd->queryColumn();
        return !count($cols) || (!$this->isNewRecord && count($cols) == 1
            && $cols[0]['id'] == $this->id);                
    }


    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('mc', 'ID'),
            'name' => Yii::t('mc', 'Name'),
            'ip' => Yii::t('mc', 'IP'),
            'port' => Yii::t('mc', 'Port'),
            'world' => Yii::t('mc', 'World'),
            'dir' => Yii::t('mc', 'Base directory'),
            'players' => Yii::t('mc', 'Player Slots'),
            'memory' => Yii::t('mc', 'Memory'),
            'start_memory' => Yii::t('mc', 'Startup Memory'),
            'jarfile' => Yii::t('mc', 'JAR File'),
            'autostart' => Yii::t('mc', 'Autostart'),
            'default_level' => Yii::t('mc', 'Default Role'),
            'daemon_id' => Yii::t('mc', 'Daemon'),
            'announce_save' => Yii::t('mc', 'Announce World Save'),
            'kick_delay' => Yii::t('mc', 'Unauthorized Kick Delay'),
            'suspended' => Yii::t('mc', 'Suspended'),
            'autosave' => Yii::t('mc', 'Autosave'),
            'jardir' => Yii::t('mc', 'Look for JARs in'),
            'crash_check' => Yii::t('mc', 'Crash Detection'),
            'disk_quota' => Yii::t('mc', 'Disk Space Limit'),
            'cpus' => Yii::t('mc', 'CPUs'),
            'domain' => Yii::t('mc', 'Domain'),
            'template' => Yii::t('mc', 'Template Name'),
            'setup' => Yii::t('mc', 'Template Setup'),
            'addPorts' => Yii::t('mc', 'Additional Ports'),
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('`id`',$this->id);
        $criteria->compare('`name`',$this->name,true);
        $criteria->compare('`ip`',$this->ip,true);
        $criteria->compare('`port`',$this->port);
        $criteria->compare('`world`',$this->world,true);
        $criteria->compare('`dir`',$this->dir,true);
        $criteria->compare('`players`',$this->players);
        $criteria->compare('`memory`',$this->memory);
        $criteria->compare('`start_memory`',$this->start_memory);
        $criteria->compare('`jarfile`',$this->jarfile,true);
        $criteria->compare('`autostart`',$this->autostart);
        $criteria->compare('`default_level`',$this->default_level);
        $criteria->compare('`daemon_id`',$this->daemon_id);
        $criteria->compare('`announce_save`',$this->announce_save);
        $criteria->compare('`kick_delay`',$this->kick_delay);
        $criteria->compare('`suspended`',$this->suspended);
        $criteria->compare('`autosave`',$this->autosave);
        $criteria->compare('`jardir`',$this->jardir);
        $criteria->compare('`crash_check`',$this->crash_check);
        $criteria->compare('`disk_quota`',$this->disk_quota);
        $criteria->compare('`cpus`',$this->cpus);

        if ($this->searchOwner)
        {
            $cr = new CDbCriteria;
            $cr->compare('`name`', $this->searchOwner, true);
            $sql = 'select `server_id` from `user_server` where `user_id` in (select `id` from `user` where '
                .$cr->condition.') and `role`=:owner';
            $cmd = Yii::app()->db->createCommand($sql);
            foreach ($cr->params as $k=>$v)
                $cmd->bindValue($k, $v);
            $cmd->bindValue(':owner', 'owner');
            $svIds = $cmd->queryColumn();
            $criteria->addInCondition('id', $svIds);
        }

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    private function generatePort()
    {
        $allIfaces = false;
        $ipCond = '';
        if (!strlen($this->ip) || $this->ip == '0.0.0.0')
            $allIfaces = true;
        else
            $ipCond = ' and (`ip`=\'\' or `ip`=\'0.0.0.0\' or `ip`=:ip)';

        $set = Setting::model()->findByPk('defaultServerPort');
        $minPort = (($set && (int)$set->value > 1024) ? (int)$set->value : 25565);
        $set = Setting::model()->findByPk('additionalPorts');
        $addPorts = ($set ? (int)$set->value : 0);
        if (!@Yii::app()->params['fill_port_gaps'])
        {
            $sql = 'select max(`port`) from `server` where `daemon_id`=:dmn';
            if (!$allIfaces)
                $sql .= $ipCond;
        }
        else
        {
            $sql = array(
                'select min(`port`) from `server` where `daemon_id`=:dmn and `port`>='.((int)$minPort),
                ' and (`port`+'.($addPorts + 1).') not in (select `port` from `server` where `daemon_id`=:dmn',
            );
            for ($i = 0; $i < $addPorts; $i++)
                $sql[] = ') and (`port`+'.($addPorts + $i + 2).') not in (select `port` from `server` where `daemon_id`=:dmn';
            $sql[] = ')';
            $sql = implode($allIfaces ? '' : $ipCond, $sql);
        }
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->bindValue(':dmn', $this->daemon_id);
        if (!$allIfaces)
            $cmd->bindValue(':ip', $this->ip);
        $port = $cmd->queryScalar();
        if (!$port)
            return $minPort;
        return max($minPort, $port + $addPorts + 1);
    }

    public function beforeSave()
    {
        if (!$this->ip)
        {
            $set = Setting::model()->findByPk('defaultServerIp');
            if ($set && $set->value != 0)
            {
                $dmn = Daemon::model()->findByPk($this->daemon_id);
                if ($dmn)
                {
                    if ($set->value == 1)
                        $this->ip = $dmn->ip;
                    else
                        $this->ip = $dmn->ftp_ip;
                }
            }
            else
                $this->ip = '0.0.0.0';
        }
        if (!$this->port)
            $this->port = $this->generatePort();
        if (!$this->memory && $this->memory !== '0' && $this->memory !== 0)
        {
            $set = Setting::model()->findByPk('defaultServerMemory');
            if (!$set || !$set->value)
                $this->memory = 1024;
            else
                $this->memory = $set->value;
        }
        if (!$this->start_memory && $this->start_memory !== '0' && $this->start_memory !== 0)
        {
            $set = Setting::model()->findByPk('defaultServerStartMemory');
            if (!$set || !$set->value)
                $this->start_memory = 0;
            else
                $this->start_memory = $set->value;
        }
        if (!$this->players)
        {
            $set = Setting::model()->findByPk('defaultServerPlayers');
            if (!$set || !$set->value)
                $this->players = 8;
            else
                $this->players = $set->value;
        }
        if (!$this->name)
        {
            $set = Setting::model()->findByPk('defaultServerName');
            if (!$set || !$set->value)
                $this->name = Yii::t('mc', 'Minecraft Server');
            else
                $this->name = $set->value;
        }

        if(@Yii::app()->params['user_subdomains']
            && ($this->prevIp != $this->ip || $this->prevPort != $this->port || $this->domain != $this->prevDomain))
        {
            if (($this->domain || $this->prevDomain) && !$this->handleSubdomain())
                return false;
            $this->prevIp = $this->ip;
            $this->prevPort = $this->port;
        }
        return parent::beforeSave();
    }

    private function handleSubdomain()
    {
        $tmp = explode('.', $this->domain, 2);
        $domainName = ''.@$tmp[1];
        $tmp = explode('.', $this->prevDomain, 2);
        $prevDomainName = ''.@$tmp[1];

        $createA = !Yii::app()->params['user_subdomains_only_srv'];

        $log = '. '.Yii::t('mc', 'Additional details have been logged for your administrator');

        $cf = new CloudFlare;

        // Check if domain is taken
        if ($this->domain)
        {
            $cmd = Yii::app()->bridgeDb->createCommand('select `id` from `server` where `domain` like ?');
            $id = $cmd->queryScalar(array($this->domain));
            if ($id && $id !== $this->id)
                return $this->addError('domain', Yii::t('mc', 'This domain name is already taken').$log);
        }

        $zone_id = $recordSRV_id = $recordA_id = 0;

        // This server currently has a domain, fetch information
        if ($this->prevDomain)
        {
            // Get old zone
            if (!($zone_id = $cf->getZone($prevDomainName)))
                return $this->addError('domain', $cf->error.$log);
            // Get old records
            $recordSRV_id = $cf->getRecord($zone_id, '_minecraft._tcp.'.$this->prevDomain, 'SRV');
            $recordA_id = $createA ? $cf->getRecord($zone_id, $this->prevDomain) : 0;
            if ($cf->error)
                return $this->addError('domain', $cf->error.$log);
        }

        // The domain has changed
        if ($domainName !== $prevDomainName)
        {
            // Delete old records if they exist
            if (($recordSRV_id && !$cf->deleteRecord($zone_id, $recordSRV_id))
                || ($recordA_id && !$cf->deleteRecord($zone_id, $recordA_id)))
                return $this->addError('domain', $cf->error.$log);
            $zone_id = $recordSRV_id = $recordA_id = 0;
        }

        // No new subdomain, done
        if (!$this->domain)
            return true;

        // Get new zone if needed
        if (!$zone_id && !($zone_id = $cf->getZone($domainName)))
            return $this->addError('domain', $cf->error.$log);

        $ip = $this->ip;
        if (!$ip || $ip == '0.0.0.0')
        {
            $sc = ServerConfig::model()->findByPk($this->id);
            if ($sc && $sc->display_ip && $sc->display_ip != '0.0.0.0')
                $ip = $sc->display_ip;
        }
        if ($createA)
            $hostname = $this->domain;
        else if (!($hostname = @gethostbyaddr($ip)))
            $hostname = $ip; // assume hostname

        $a = array(
            'type'=>(strpos($ip, ':') === false) ? 'A' : 'AAAA',
            'name'=>$this->domain,
            'content'=>$ip,
            'ttl'=>1,
        );
        $srv = array(
            'type'=>'SRV',
            'data'=>array(
                'service'=>'_minecraft',
                'proto'=>'_tcp',
                'name'=>$this->domain,
                'priority'=>10,
                'weight'=>5,
                'port'=>(int)$this->port,
                'target'=>$hostname,
            ),
            'ttl'=>1,
        );

        if ($createA && !$cf->updateRecord($zone_id, $recordA_id, $a))
            return $this->addError('domain', $cf->error.$log);
        if (!$cf->updateRecord($zone_id, $recordSRV_id, $srv))
        {
            if ($createA)
                Yii::log('SRV record update failed, the A record might be in an inconsistent state', 'warning');
            return $this->addError('domain', $cf->error.$log);
        }
        return true;
    }

    public function afterSave()
    {
        $this->checkDir();

        McBridge::get()->serverCmd($this->id, 'refresh', $null);
        if ($this->prevDaemon && $this->prevDaemon != $this->daemon_id)
        {
            McBridge::get()->cmd($this->prevDaemon, 'server '.$this->id.':refresh');
            $this->prevDaemon = $this->daemon_id;
        }
        return parent::afterSave();
    }

    public function beforeDelete()
    {
        $this->domain = '';
        if(@Yii::app()->params['user_subdomains'] && !$this->handleSubdomain())
            return false;

        $cmd = 'delinstance '.$this->id;

        if ($this->deleteDir === 'yes')
        {
            if (!McBridge::get()->serverCmd($this->id, 'get status', $status))
            {
                $this->addError('deleteDir', Yii::t('mc', 'Cannot delete base directory: ').McBridge::get()->lastError());
                return false;
            }
                
            if (@$status[0]['status'] != 'stopped')
            {
                $this->addError('deleteDir', Yii::t('mc', 'Cannot delete base directory: ')
                    .Yii::t('mc', 'Server still running'));
                return false;
            }

            $shared = Server::model()->findAllByAttributes(
                array('daemon_id'=>$this->daemon_id, 'dir'=>$this->dir));
            if (count($shared) > 1)
            {
                $this->addError('deleteDir', Yii::t('mc', 'Cannot delete base directory: ')
                    .Yii::t('mc', 'Base directory is still in use by other servers'));
                return false;
            }
            $cmd .= ' deleteDir';
         
            //Delete the database as well           
            $this->deleteDatabase();
        }
        
        McBridge::get()->cmd($this->daemon_id, $cmd);
        if ($this->prevDaemon && $this->prevDaemon != $this->daemon_id)
            McBridge::get()->cmd($this->prevDaemon, $cmd);
        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        ServerConfig::model()->deleteByPk($this->id);
        UserServer::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        FtpUserServer::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        Command::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        Schedule::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        $plrs = Yii::app()->bridgeDb->createCommand('select `id` from `player` where `server_id`=?')->query(array($this->id));
        foreach ($plrs as $plr)
            UserPlayer::model()->deleteAllByAttributes(array('player_id'=>$plr['id']));
        Player::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        return parent::afterDelete();
    }

    public function getOnlinePlayers()
    {
        if ($this->playersCached !== false)
            return $this->playersCached;
        if (!McBridge::get()->serverCmd($this->id, 'get status', $status))
            return ($this->playersCached = -2);
  
        if (@$status[0]['status'] == 'running')
            return ($this->playersCached = intval($status[0]['players']));
        return ($this->playersCached = -1);
    }

    public function getIpAuthRole()
    {
        $sc = ServerConfig::model()->findByPk($this->id);
        return $sc->ip_auth_role;
    }

    public function getOwner()
    {
        $sql = 'select `user_id` from `user_server` where `server_id`=? and `role`=?';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(1, $this->id);
        $cmd->bindValue(2, 'owner');
        return $cmd->queryScalar();
    }

    public function setOwner($id)
    {
        if (is_object($id))
            $id = $id->id;
        $prev = $this->owner;
        $res = true;

        if ($id != $prev)
            Yii::log('Changing owner of server '.$this->id.' from '.$prev.' to '.$id);
        if ($id)
        {
            $sql = 'replace into `user_server` (`user_id`,`server_id`, `role`) values(?,?,?)';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(1, (int)$id);
            $cmd->bindValue(2, $this->id);
            $cmd->bindValue(3, 'owner');
            $res = $cmd->execute();
        }
        //FtpUserServer::model()->deleteAllByAttributes(array('server_id'=>$this->id));
        $sql = 'update `user_server` set `role`=? where `server_id`=? and `user_id`!=? and `role`=?';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(1, '');
        $cmd->bindValue(2, $this->id);
        $cmd->bindValue(3, $id ? (int)$id : 0);
        $cmd->bindValue(4, 'owner');
        $cmd->execute();

        if ($id != $prev && $this->sendData && Yii::app()->params['mail_assign']
            && $usr = User::model()->findByPk($id))
        {
            $msg = new YiiMailMessage;
    
            try
            {
                $msg->setFrom(array(Yii::app()->params['admin_email']=>Yii::app()->params['admin_name']));
            }
            catch (Exception $e)
            {
                throw new CHttpException(500, Yii::t('admin', 'Invalid administrator email set under Settings->Panel Configuration'));
            }
            
            $msg->setTo(array($usr->email=>$usr->name));            

            $msg->view = 'serverAssigned';
            $msg->setBody(array(
                'server_id'=>$this->id,
                'user_id'=>$id,
                'user_name'=>$usr->name,
                'host'=>Yii::app()->request->getHostInfo(),
                'panel'=>Yii::app()->request->getBaseUrl(true),
            ));

            Yii::log('Seding assign email to '.$usr->email);
            if (!Yii::app()->mail->send($msg))
                Yii::log('Error sending assign email to '.$usr->email);
            else
                $this->sendData = false;
        }
    
        return $res;
    }

    public static function getDaemon($server)
    {
        if (is_object($server))
            $server = $server->id;
        $sql = 'select `daemon_id` from `server` where `id`=?';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $cmd->bindValue(1, (int)$server);
        return $cmd->queryScalar();
    }

    public function createDefaultCommands()
    {
        $cmds = array(
            array(Yii::t('mc', 'Message of the Day'), 10, 'motd',     ''),
            array(Yii::t('mc', 'Give Item'),          30, 'give',     'builtin:give'),
            array(Yii::t('mc', 'Teleport To'),        30, 'tp',       'builtin:tp'),
            array(Yii::t('mc', 'Summon Player'),      30, 'summon',   'builtin:summon'),
            array(Yii::t('mc', 'Admin Say'),          30, 'asay',     'builtin:asay'),
            array(Yii::t('mc', 'Save World'),         30, 'save',     'builtin:save'),
            array(Yii::t('mc', 'Time'),               10, 'time',     'builtin:time'),
            array(Yii::t('mc', 'Date'),               10, 'date',     'builtin:date'),
            array(Yii::t('mc', 'Player List'),        10, 'list',     'builtin:list'),
            array(Yii::t('mc', 'Say Player List'),    30, 'saylist',  'builtin:saylist'),
            array(Yii::t('mc', 'Create Backup'),      40, '',         'builtin:backup'),
            array(Yii::t('mc', 'Create Full Backup'), 40, '',         'builtin:fullbackup'),
            array(Yii::t('mc', 'Restart'),            40, '',         'builtin:restart'),
            array(Yii::t('mc', 'Restart if Empty'),   40, '',         'builtin:restart_empty'),
            array(Yii::t('mc', 'Stop'),               40, '',         'builtin:stop'),
            array(Yii::t('mc', 'Stop if Empty'),      40, '',         'builtin:stop_empty'),
            array(Yii::t('mc', 'Start'),              40, '',         'builtin:start'),
            array(Yii::t('mc', 'Teleport Other'),     40, '',         'builtin:tp_other'),
        );

        foreach ($cmds as $c)
        {
            $cmd = Command::model()->findByAttributes(array('server_id'=>$this->id, 'name'=>$c[0]));
            if ($cmd)
                continue;
            $cmd = new Command;
            $cmd->server_id = $this->id;
            $cmd->name      = $c[0];
            $cmd->level     = $c[1];
            $cmd->chat      = $c[2];
            $cmd->run       = $c[3];
            $cmd->save();
        }
    }


    public function suspend()
    {
        $success = false;
        if (!$this->hasAttribute('suspended'))
            $this->addError('suspended', Yii::t('mc', 'Attribute not found, database up to date?'));
        else
        {
            $this->suspended = 1;
            $success = $this->save(false);
        }
        Yii::log('Suspended server '.$this->id);
        $scheds = Schedule::model()->findAllByAttributes(array('server_id'=>$this->id,
            'status'=>array(Schedule::Scheduled, Schedule::ReScheduled)));
        foreach ($scheds as $sched)
        {
            $sched->status = Schedule::Suspended;
            $sched->save(false);
        }
        return $success;
    }

    public function resume()
    {
        $success = false;
        if (!$this->hasAttribute('suspended'))
            $this->addError('suspended', Yii::t('mc', 'Attribute not found, database up to date?'));
        else
        {
            $this->suspended = 0;
            $success = $this->save(false);
        }
        Yii::log('Resumed server '.$this->id);
        $scheds = Schedule::model()->findAllByAttributes(array('server_id'=>$this->id,
            'status'=>Schedule::Suspended));
        foreach ($scheds as $sched)
        {
            $sched->status = Schedule::Scheduled;
            $sched->save(false);
        }
        return $success;
    }


    public function getDbInfo()
    {
        $cmd = Yii::app()->db->createCommand('select `name`, `password` from `mysql_db` where `server_id`=?');
        $cmd->bindValue(1, (int)$this->id);
        $info = $cmd->queryRow(false);
        if (!$info)
            return false;
        if (!strlen(@$info[0]))
            $info[0] = $this->mysqlPrefix.((int)$this->id);
        return $info;
    }

    private function openUserDb()
    {
        if (Yii::app()->params['demo_mode'] == 'enabled')
            return new DummyDb;
        $db = new CDbConnection('mysql:host='.$this->mysqlHost,
            $this->mysqlInfo['user'], $this->mysqlInfo['pass']);
        $db->emulatePrepare = true;
        $db->charset = 'utf8';
        $db->active = true;
        return $db;
    }

    public function deleteDatabase()
    {
        $info = $this->dbInfo;
        if (!$info)
            return;
        $user = $info[0];
        Yii::log('Deleting MySQL database for server '.$this->id.': '.$user);

        if (!strlen($user))
        {
            Yii::log('No database provided');
            return false;
        }

        try
        {
            $db = $this->openUserDb();
            $db->createCommand('drop database '.$db->quoteColumnName($user))->execute();
            $db->createCommand('drop user '.$db->quoteValue($user).'@\'%\'')->execute();

            $cmd = Yii::app()->db->createCommand('delete from `mysql_db` where `server_id`=?');
            $cmd->bindValue(1, $this->id);
            $cmd->execute();

            $db->active = false;
        }
        catch (Exception $e)
        {
            Yii::log('Failed to delete MySQL database "'.$user.'"! ('.$e->getMessage().'")');
            return false;
        }
        return true;
    }

    public function createDatabase()
    {
        $user = $this->mysqlPrefix.$this->id;
        $pass = substr(md5(rand()), 0, 10);

        Yii::log('Creating MySQL database for server '.$this->id.': '.$user);

        if (!strlen($user))
        {
            Yii::log('No database provided');
            return false;
        }
        
        try
        {
            $db = $this->openUserDb();
            $db->createCommand('create database '.$db->quoteColumnName($user))->execute();
            $db->createCommand('create user '.$db->quoteValue($user).'@\'%\' identified by '
                .$db->quoteValue($pass))->execute();
            $dbName = str_replace(array('_', '%'), array('\\_', '\\%'), $db->quoteColumnName($user));
            $db->createCommand('grant all privileges on '.$dbName.'.* to '
                .$db->quoteValue($user).'@\'%\'')->execute();

            $cmd = Yii::app()->db->createCommand('replace into `mysql_db` values(?,?,?)');
            $cmd->bindValue(1, $this->id);
            $cmd->bindValue(2, $user);
            $cmd->bindValue(3, $pass);
            $cmd->execute();

            $db->active = false;
        }
        catch (Exception $e)
        {
            Yii::log('Failed to create MySQL database "'.$user.'"! ('.$e->getMessage().')');
            return false;
        }
        return true;
    }

    public function changeDatabasePw()
    {
        $info = $this->dbInfo;
        $user = $info[0];
        $pass = substr(md5(rand()), 0, 10);

        Yii::log('Changing MySQL password for server '.$this->id.': '.$user);

        if (!strlen($user))
        {
            Yii::log('No database provided');
            return false;
        }
        
        try
        {
            $db = $this->openUserDb();
            $db->createCommand('alter user '.$db->quoteValue($user)
                .'@\'%\' identified by '.$db->quoteValue($pass).'')->execute();

            $cmd = Yii::app()->db->createCommand('replace into `mysql_db` values(?,?,?)');
            $cmd->bindValue(1, $this->id);
            $cmd->bindValue(2, $user);
            $cmd->bindValue(3, $pass);
            $cmd->execute();

            $db->active = false;
        }
        catch (Exception $e)
        {
            Yii::log('Failed to change MySQL password for "'.$user.'"! ('.$e->getMessage().')');
            return false;
        }
        return true;
    }

    public function getMysqlInfo()
    {
        if ($this->_mysqlInfo)
            return $this->_mysqlInfo;
        $info = @include(dirname(__FILE__).'/../config/user_databases.php');
        $info = @$info[$this->daemon_id];
        if (!is_array($info))
            $info = array('host'=>Yii::app()->params['user_mysql_host']);
        else if (!isset($info['host']))
            $info['host'] = '*';

        if (!@$info['user'])
        {
            $info['user'] = Yii::app()->params['user_mysql_user'];
            $info['pass'] = Yii::app()->params['user_mysql_pass'];
        }
        else if (!@$info['pass'])
            $info['pass'] = '';

        $dmn = Daemon::model()->findByPk($this->daemon_id);
        if ($info['host'] == '*')
        {
            if ($dmn)
                $info['host'] = $dmn->ip;
            else
                $info['host'] = false;
        }
        else if ($info['host'] == '')
            $info['host'] = false;

        if (!isset($info['prefix']))
            $info['prefix'] = Yii::app()->params['user_mysql_prefix'];

        if (!isset($info['link']))
            $info['link'] = Yii::app()->params['user_mysql_admin'];

        if ($dmn && $info['link'])
            $info['link'] = str_replace('*', $dmn->ip, $info['link']);

        return ($this->_mysqlInfo = $info);
    }


    public function getMysqlHost()
    {
        return @$this->mysqlInfo['host'];
    }

    public function getMysqlPrefix()
    {
        return @$this->mysqlInfo['prefix'];
    }

    public function getMysqlLink()
    {
        return @$this->mysqlInfo['link'];
    }

    public function getAddPorts()
    {
        $set = Setting::model()->findByPk('additionalPorts');
        $addPorts = ($set ? (int)$set->value : 0);
        $ports = array();
        for ($i = 0; $i < $addPorts; $i++)
            $ports[] = $this->port + $i + 1;
        $cmd = Yii::app()->bridgeDb->createCommand('select `port` from `server_port` where `server_id`=?');
        $ports = array_merge($ports, $cmd->queryColumn(array($this->id)));
        return implode(', ', $ports);
    }

    public function addServerPort($port = 0)
    {
        if ($port)
        {
            if ($port < 1024 || $port > 65535)
            {
                return $this->addError('port', Yii::t('mc', 'Failed to allocate new port.').' '
                    .Yii::t('mc', 'Invalid port number.'));
            }
            $cmd = Yii::app()->bridgeDb->createCommand('select `port` from `server_port` where `server_id`=? and `port`=?');
            if ($cmd->queryScalar(array($this->id, $port)))
            {
                return $this->addError('port', Yii::t('mc', 'Failed to allocate new port.').' '
                    .Yii::t('mc', 'Duplicate server port.'));
            }
            $cmd = Yii::app()->bridgeDb->createCommand('insert into `server_port` (`server_id`,`port`) values (?,?)');
            $cmd->execute(array($this->id, $port));
            return $port;
        }
        $range = explode('-', Yii::app()->params['additional_port_range']);
        if (count($range) != 2 || !$range[0] || !$range[1] || $range[0] >= $range[1])
        {
            Yii::log('Port range definition error, expexted X-Y where X < Y.', 'error');
            return $this->addError('port', Yii::t('mc', 'Failed to allocate new port.').' '
                .Yii::t('mc', 'Additional details have been logged for your administrator'));
        }
        $cmd = Yii::app()->bridgeDb->createCommand('select `port` from `server_port` where `server_id` in (select `id` from `server` where `daemon_id`=?)');
        $dmnPorts = $cmd->queryColumn(array($this->daemon_id));
        $port = rand($range[0], $range[1]);
        $step = ($port % 2) ? 1 : -1;
        $found = false;
        for ($i = 0; $i <= $range[1] - $range[0]; $i++)
        {
            if (!in_array($port, $dmnPorts))
            {
                $cmd = Yii::app()->bridgeDb->createCommand('insert into `server_port` (`server_id`,`port`) values (?,?)');
                $cmd->execute(array($this->id, $port));
                $found = true;
                break;
            }
            $port += $step;
            if ($port > $range[1])
                $port = $range[0];
            else if ($port < $range[0])
                $port = $range[1];
        }
        if (!$found)
        {
            Yii::log('Failed to allocate new random port for server '.$this->id, 'warning');
            return $this->addError('port', Yii::t('mc', 'Failed to allocate new port.').' '
                .Yii::t('mc', 'Additional details have been logged for your administrator'));
        }
        return $port;
    }

    public function removeServerPort($port)
    {
        $cmd = Yii::app()->bridgeDb->createCommand('delete from `server_port` where `server_id`=? and `port`=?');
        $cmd->execute(array($this->id, $port));
        return true;
    }
}
