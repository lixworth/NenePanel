<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
if (Yii::app()->user->isStaff() || !Yii::app()->params['hide_userlist'])
    $this->breadcrumbs = array(Yii::t('mc', 'Users')=>array('index'));
else
    $this->breadcrumbs = array(Yii::t('mc', 'Profile'));
$this->breadcrumbs[$model->name] = array('view', 'id'=>$model->id);
$this->breadcrumbs[] = Yii::t('mc', 'Enable Google Authenticator');

$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>array('user/view', 'id'=>$model->id),
    'icon'=>'back'
);
?>

<?php
$attribs[] = array('label'=>'', 'value'=>Yii::t('mc', 'Scan the QR-Code below with your Google Authenticator app or enter the key manually'));
$attribs[] = array('label'=>Yii::t('mc', 'QR-Code'), 'type'=>'raw',
        'value'=>CHtml::image($qr, 'QR'));
$attribs[] = array('label'=>Yii::t('mc', 'Account Name'), 'value'=>$domain);
$attribs[] = array('label'=>Yii::t('mc', 'Key'), 'type'=>'raw',
        'value'=>CHtml::textField('', $secret, array('readonly'=>'readonly')));
$attribs[] = array('label'=>Yii::t('mc', 'Google Authenticator Code'), 'type'=>'raw',
        'value'=>CHtml::activeTextField($model, 'gauth_token').' '.CHtml::error($model, 'gauth_token'));
$attribs[] = array('label'=>Yii::t('mc', 'Confirm Panel Password'), 'type'=>'raw',
        'value'=>CHtml::activePasswordField($model, 'confirmPassword').' '.CHtml::error($model, 'confirmPassword'));
$attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Enable Google Authenticator')));

echo CHtml::beginForm();

?>
<!-- Try to work around ignored autocomplete settings -->
<input type="text" style="position: absolute; top: -3px; width: 1px; height: 1px; border: 1px solid white"/>
<input type="password" style="position: absolute; top: -3px; width: 1px; height: 1px; border: 1px solid white" />
<?php

$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
)); 

echo CHtml::endForm();
?>
