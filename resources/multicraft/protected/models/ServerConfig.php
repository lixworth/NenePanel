<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class ServerConfig extends ActiveRecord
{
/*
    int $server_id
    string $ip_auth_role
    string $give_role
    string $tp_role
    string $summon_role
    string $chat_role
    int $user_jar
    int $user_ftp
    int $visible
    int $user_schedule
    int $user_name
    int $user_visibility
    string $display_ip
    int $user_players
    int $user_mysql
    int $user_jardir
    int $user_templates
    int $user_params
    int $user_memory
    int $user_crash_check
    int $user_subdomain
    int $user_add_ports
*/

    static function getVisibility($idx = false)
    {
        static $v = false;
        if (!$v)
        {
            $v = array(
                Yii::t('mc', 'Owner only'),
                Yii::t('mc', 'By Default Role'),
                Yii::t('mc', 'Users with Roles only'),
            );
        }
        if ($idx !== false)
            return @$v[$idx];
        return $v;
    }

    public function init()
    {
        $defaults = @include(dirname(__FILE__).'/../config/server_defaults.php');
        if (!is_array(@$defaults['config']))
            return;
        foreach ($defaults['config'] as $attr=>$value)
        {
            if ($value === null)
                continue;
            $this->{$attr} = $value;
        }
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'server_config';
    }

    public function rules()
    {
        return array(
            array('server_id', 'numerical', 'on'=>'create'),
            array('server_id', 'unique', 'on'=>'create'),
            array('ip_auth_role, give_role, tp_role, summon_role, chat_role', 'length', 'max'=>16),
            array('display_ip', 'length', 'max'=>64, 'on'=>'superuser'),
            array('visible, user_jar, user_ftp, user_schedule, user_name, user_visibility, user_players, user_mysql,'
                .' user_jardir, user_templates, user_params, user_memory, user_crash_check,'
                .' user_subdomain, user_add_ports', 'numerical', 'on'=>'superuser'),
            array('server_id, ip_auth_role, give_role, tp_role, summon_role, chat_role, user_jar, user_schedule, visible,'
                .' user_name, user_visibility, display_ip, user_players, user_mysql, user_jardir, user_templates,'
                .' user_params, user_memory, user_crash_check, user_subdomain, user_add_ports', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'server_id' => Yii::t('mc', 'Server'),
            'ip_auth_role' => Yii::t('mc', 'IP Auth Role'),
            'give_role' => Yii::t('mc', 'Give Role'),
            'tp_role' => Yii::t('mc', 'Teleport Role'),
            'summon_role' => Yii::t('mc', 'Summon Role'),
            'chat_role' => Yii::t('mc', 'Chat Role'),
            'user_jar' => Yii::t('mc', 'Owner selectable JAR'),
            'user_ftp' => Yii::t('mc', 'Owner managed FTP'),
            'user_schedule' => Yii::t('mc', 'Owner Scheduled Tasks'),
            'visible' => Yii::t('mc', 'Server Visibility'),
            'user_name' => Yii::t('mc', 'Owner can set Name'),
            'user_visibility' => Yii::t('mc', 'Owner set Visibility'),
            'display_ip' => Yii::t('mc', 'Displayed IP'),
            'user_players' => Yii::t('mc', 'Owner set Player Count'),
            'user_mysql' => Yii::t('mc', 'Owner can create MySQL DB'),
            'user_jardir' => Yii::t('mc', 'Owner set JAR directory'),
            'user_templates' => Yii::t('mc', 'Owner can use Templates'),
            'user_params' => Yii::t('mc', 'Owner set Startup Parameters'),
            'user_memory' => Yii::t('mc', 'Owner set Server Memory'),
            'user_crash_check' => Yii::t('mc', 'Owner configurable Crash Detection'),
            'user_subdomain' => Yii::t('mc', 'Owner set Subdomain'),
            'user_add_ports' => Yii::t('mc', 'Owner can add Ports'),
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('`server_id`',$this->server_id);
        $criteria->compare('`ip_auth_role`',$this->ip_auth_role);
        $criteria->compare('`give_role`',$this->give_role);
        $criteria->compare('`tp_role`',$this->tp_role);
        $criteria->compare('`summon_role`',$this->summon_role);
        $criteria->compare('`chat_role`',$this->chat_role);
        $criteria->compare('`user_jar`',$this->user_jar);
        $criteria->compare('`user_ftp`',$this->user_ftp);
        $criteria->compare('`user_schedule`',$this->user_schedule);
        $criteria->compare('`user_name`',$this->user_name);
        $criteria->compare('`user_visibility`',$this->user_visibility);
        $criteria->compare('`visible`',$this->visible);
        $criteria->compare('`display_ip`',$this->display_ip,true);
        $criteria->compare('`user_players`',$this->user_players);
        $criteria->compare('`user_mysql`',$this->user_mysql);
        $criteria->compare('`user_jardir`',$this->user_jardir);
        $criteria->compare('`user_templates`',$this->user_templates);
        $criteria->compare('`user_params`',$this->user_params);
        $criteria->compare('`user_memory`',$this->user_memory);
        $criteria->compare('`user_crash_check`',$this->user_crash_check);
        $criteria->compare('`user_subdomain`',$this->user_subdomain);
        $criteria->compare('`user_add_ports`',$this->user_add_ports);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord && !$this->display_ip)
        {
            $set = @Yii::app()->params['default_displayed_ip'];
            if (in_array($set, array('daemon', 'daemon_ftp'))
                && ($dmn = Daemon::model()->findByPk(Server::getDaemon($this->server_id))))
            {
                if ($set == 'daemon')
                    $this->display_ip = $dmn->ip;
                else
                    $this->display_ip = $dmn->ftp_ip;
            }
            else
                $this->display_ip = ''.@Yii::app()->params['default_display_ip']; // For backward compatibility
        }
        return true;
    }
}
