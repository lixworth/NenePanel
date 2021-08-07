<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class RolePermission extends ActiveRecord
{
/*
    string $role
    string $permission
 */
    
    static $defaultPerms = array(
        'guest'=>array(
            'get_status',
            'get_players',
            'view',
            'self_view_player',
        ),
        'user'=>array(
            'self_give',
            'self_tp',
            'get_chat',
            'chat',
            'view_player',
            'view_command',
        ),
        'mod'=>array(
            'start',
            'get_log',
            'player_details',
            'give',
            'tp',
            'kick',
            'get_backup',
        ),
        'smod'=>array(
            'command',
            'stop',
            'restart',
            'start_backup',
            'manage_players',
        ),
        'admin'=>array(
            'edit',
            'edit_configs',
            'manage_plugins',
            'manage_mysql',
            'manage_templates',
            'manage_params',
            'manage_commands',
            'manage_schedule',
            'clear_chat',
            'clear_log',
            'manage_users',
            'restore_backup',
        ),
        'coowner'=>array(
            'manage_ftp',
        ),
        'owner'=>array(
        ),
    );
    static function getPermissions($perm = false)
    {
        $perms = array(
            'get_backup'=>Yii::t('mc', 'View backup status'),
            'start_backup'=>Yii::t('mc', 'Start backup'),
            'restore_backup'=>Yii::t('mc', 'Restore backup'),

            'get_chat'=>Yii::t('mc', 'Read chat'),
            'chat'=>Yii::t('mc', 'Use chat'),
            'clear_chat'=>Yii::t('mc', 'Clear chat'),

            'get_log'=>Yii::t('mc', 'View log'),
            'command'=>Yii::t('mc', 'Send server commands'),
            'clear_log'=>Yii::t('mc', 'Clear log'),

            'get_players'=>Yii::t('mc', 'View player list'),
            'view_player'=>Yii::t('mc', 'View player'),
            'self_view_player'=>Yii::t('mc', 'View own player'),
            'player_details'=>Yii::t('mc', 'View player details'),
            'kick'=>Yii::t('mc', 'Kick players'),
            'give'=>Yii::t('mc', 'Use give command'),
            'tp'=>Yii::t('mc', 'Teleport players'),
            'self_give'=>Yii::t('mc', 'Give self'),
            'self_tp'=>Yii::t('mc', 'Teleport self'),

            'get_status'=>Yii::t('mc', 'View server status'),
            'view'=>Yii::t('mc', 'View server'),
            'start'=>Yii::t('mc', 'Start server'),
            'stop'=>Yii::t('mc', 'Stop server'),
            'restart'=>Yii::t('mc', 'Restart server'),
            'view_command'=>Yii::t('mc', 'View commands'),

            'edit'=>Yii::t('mc', 'Edit server settings'),
            'edit_configs'=>Yii::t('mc', 'Edit server config files'),
            'manage_commands'=>Yii::t('mc', 'Manage commands'),
            'manage_schedule'=>Yii::t('mc', 'Manage schedule'),
            'manage_ftp'=>Yii::t('mc', 'Manage FTP users'),
            'manage_players'=>Yii::t('mc', 'Manage players'),
            'manage_users'=>Yii::t('mc', 'Manage users'),
            'manage_plugins'=>Yii::t('mc', 'Manage plugins'),
            'manage_templates'=>Yii::t('mc', 'Use templates'),
            'manage_mysql'=>Yii::t('mc', 'Manage MySQL databases'),
            'manage_params'=>Yii::t('mc', 'Manage server parameters'),
        );
        return $perm ? $perms[$perm] : $perms;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'role_permission';
    }

    public function rules()
    {
        return array(
            array('role, permission', 'length', 'max'=>16),
        );
    }

    public function attributeLabels()
    {
        return array(
            'role' => Yii::t('mc', 'Role'),
            'permission' => Yii::t('mc', 'Permission'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('`role`', $this->role);
        $criteria->compare('`permission`', $this->permission);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    static function getRoles()
    {
        $r = array_combine(User::$roles, User::getRoleLabels());
        unset($r['none']);
        return $r;
    }

    static function label($permission)
    {
        return @RolePermission::getPermissions($permission);
    }

    static function has($role, $permission)
    {
        return !!RolePermission::model()->findByAttributes(array('role'=>$role, 'permission'=>$permission));
    }

    static function reset($role)
    {
        if (!in_array($role, array_keys(RolePermission::$defaultPerms)) && $role !== '_all')
            return false;
        if ($role == '_all')
            $roles = array_keys(RolePermission::$defaultPerms);
        else
            $roles = array($role);
        foreach ($roles as $r)
        {
            RolePermission::model()->deleteAllByAttributes(array('role'=>$r));
            foreach (RolePermission::$defaultPerms as $k=>$v)
            {
                foreach ($v as $perm)
                {
                    $rp = new RolePermission;
                    $rp->role = $r;
                    $rp->permission = $perm;
                    if (!$rp->save())
                    {
                        Yii::log('Failed to save role: '.CHtml::encode(print_r($rp->getErrors(), true)), 'warning');
                        return false;
                    }
                }
                if ($k == $r)
                    break;
            }
        }
        return true;
    }
}
