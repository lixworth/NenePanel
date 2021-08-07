<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('mc', 'Users')=>array('index'),
    Yii::t('mc', 'Edit Roles')=>array('roles'),
    User::getRoleLabel($role),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

$this->menu[] = array(
    'label'=>Yii::t('mc', 'Reset'),
    'url'=>'#',
    'linkOptions'=>array(
        'submit'=>array('resetRole', 'role'=>$role),
        'confirm'=>Yii::t('mc', 'Reset this role to the default permissions?'),
        'csrf'=>true,
    ),
    'icon'=>'user_del',
);
$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>array('roles'),
    'icon'=>'back'
);
?>
<?php if(Yii::app()->user->hasFlash('user')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('user'); ?>
</div>
<?php endif ?>
<h3><?php echo Yii::t('mc', 'Permissions for role "{role}"', array('{role}'=>User::getRoleLabel($role))) ?></h3>
<?php
echo CHtml::beginForm();
echo CHtml::hiddenField('role', $role);
$this->heading(Yii::t('mc', 'Server Status'));
$this->checkbox('get_status');
$this->checkbox('view');
$this->checkbox('get_players');
$this->checkbox('view_command');
$this->heading(Yii::t('mc', 'Backup'));
$this->checkbox('get_backup');
$this->checkbox('start_backup');
$this->checkbox('restore_backup');
$this->heading(Yii::t('mc', 'Chat'));
$this->checkbox('get_chat');
$this->checkbox('chat');
$this->checkbox('clear_chat');
$this->heading(Yii::t('mc', 'Console'));
$this->checkbox('get_log');
$this->checkbox('command');
$this->checkbox('clear_log');
$this->heading(Yii::t('mc', 'Players'));
$this->checkbox('view_player');
$this->checkbox('self_view_player');
$this->checkbox('player_details');
$this->checkbox('kick');
$this->checkbox('give');
$this->checkbox('tp');
$this->checkbox('self_give');
$this->checkbox('self_tp');
$this->heading(Yii::t('mc', 'Server Management'));
$this->checkbox('start');
$this->checkbox('stop');
$this->checkbox('restart');
$this->checkbox('edit');
$this->checkbox('edit_configs');
$this->checkbox('manage_commands');
$this->checkbox('manage_schedule');
$this->checkbox('manage_ftp');
$this->checkbox('manage_players');
$this->checkbox('manage_users');
$this->checkbox('manage_plugins');
$this->checkbox('manage_templates');
$this->checkbox('manage_mysql');
$this->checkbox('manage_params');
$this->saveButton();
echo CHtml::endForm();
?>

