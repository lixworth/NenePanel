<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('mc', 'Minecraft FTP Client').' '.Yii::t('mc', 'Login');
$this->breadcrumbs = array(
    $server->name=>array('/server/view', 'id'=>$server->id),
    Yii::t('mc', 'FTP Client')=>array('index', 'id'=>$server->id),
    Yii::t('mc', 'FTP Server Login'),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

$this->menu = array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$server->id),
        'icon'=>'back',
    )
);
?>

<?php echo Yii::t('mc', 'To access your files you can either use this web based client or any other FTP program') ?><br/>
<br/>

<?php

$attribs = array();
$attribs[] = array('label'=>Yii::t('mc', 'FTP Address'), 'value'=>@$daemon->ftp_ip);
$attribs[] = array('label'=>Yii::t('mc', 'FTP Port'), 'value'=>@$daemon->ftp_port);
if ($permissions)
{
    $attribs[] = array('label'=>Yii::t('mc', 'FTP Username'), 'value'=>Yii::app()->user->name.'.'.$server->id);
    $attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'Multicraft Password'), 'password'), 'type'=>'raw',
        'value'=>CHtml::passwordField('password').' <span class="hint">'.($havePw ?
            Yii::t('mc', '(Leave empty to use cached Password)') : '').'</span>');
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Login'), array('id'=>'login_button')));
}
else
{
    $attribs[] = array('label'=>Yii::t('mc', 'No FTP account found'), 'type'=>'raw',
        'value'=>Yii::app()->user->can($server->id, 'manage_users')
            ? CHtml::link(Yii::t('mc', 'Create FTP Account'), array('server/users', 'id'=>$server->id),
                array(
                    'submit'=>array('createAccount', 'id'=>$server->id),
                    'csrf'=>true,
                    'class'=>'btn btn-primary btn-block'
                )
            )
            : Yii::t('mc', 'You do not have FTP access to this server')
        );
}
?>

<?php echo CHtml::beginForm() ?>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>array(),
    'attributes'=>$attribs,
)); 
?>

<?php echo CHtml::endForm(); ?>
