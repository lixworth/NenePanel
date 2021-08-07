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
$this->breadcrumbs[] = Yii::t('mc', 'Disable Google Authenticator');

$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>array('user/view', 'id'=>$model->id),
    'icon'=>'back'
);
?>

<?php
echo CHtml::beginForm();

if (Yii::app()->user->model->id === $model->id)
{
    $attribs[] = array('label'=>'', 'value'=>Yii::t('mc', 'Enter your password to disable Google Authenticator'));
    $attribs[] = array('label'=>Yii::t('mc', 'Confirm Panel Password'), 'type'=>'raw',
        'value'=>CHtml::activePasswordField($model, 'confirmPassword').' '.CHtml::error($model, 'confirmPassword'));
}
else
{
    $attribs[] = array('label'=>'', 'value'=>Yii::t('mc', 'Please confirm disabling Google Authenticator for this user'));
    echo CHtml::activeHiddenField($model, 'name');
}
$attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Disable Google Authenticator')));

$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
)); 

echo CHtml::endForm();
?>
