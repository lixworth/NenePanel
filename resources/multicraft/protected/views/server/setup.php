<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('mc', 'Setup')
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$model->id),
        'icon'=>'back',
    ),
);

if ($status == 'error'): ?>
<div class="flash-error">
    <?php echo Yii::t('mc', 'There is an error with the daemon connection for this Server') ?>
</div>
<?php
    if (!Yii::app()->user->isStaff())
        return;
endif;
?>

<?php 

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'server-form',
    'enableAjaxValidation'=>false,
));
echo CHtml::errorSummary($model);

if ($model->template && $model->setup != 'done'):
    echo CHtml::hiddenField('cancel_setup', 'true');
    echo '<p>'.Yii::t('mc', 'The following template will be setup on the next server startup').'</p>';
    $attribs[] = array('label'=>Yii::t('mc', 'Template'),
        'value'=>@$templates[$model->template] ? $templates[$model->template] : $model->template);
    $attribs[] = array('label'=>Yii::t('mc', 'Delete all files'), 'value'=>
        (strstr($model->setup, 'delete') === false) ? Yii::t('mc', 'No') : Yii::t('mc', 'Yes'));
    $attribs[] = array('label'=>Yii::t('mc', 'Run on every server startup'), 'value'=>
        (strstr($model->setup, 'always') === false) ? Yii::t('mc', 'No') : Yii::t('mc', 'Yes'));
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Cancel Setup')));
else:
    echo CHtml::hiddenField('setup', 'true');
    if ($status == 'error')
        $value = CHtml::textField('template', @$_POST['template']);
    else
        $value = CHtml::dropDownList('template', @$_POST['template'], $templates);
    $attribs[] = array('label'=>Yii::t('mc', 'Template'), 'type'=>'raw', 'value'=>$value);
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::checkBox('delete_files', @$_POST['delete'], 
        array('style'=>'width: auto')).' '.CHtml::label(Yii::t('mc', 'Delete All Server Files'), 'delete_files'));
    $attribs[] = array('label'=>Yii::t('mc', 'Password'), 'type'=>'raw', 'value'=>CHtml::passwordField('confirm_password'), 
        'cssClass'=>'pw_field');
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::checkBox('always', @$_POST['always'], 
        array('style'=>'width: auto')).' '.CHtml::label(Yii::t('mc', 'Run Setup on every server start'), 'always')
        .'<span class="hint"></span>');
        
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Apply')));
endif;

$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'itemTemplate'=>"<tr class=\"{class}\"><th style=\"width: 30%\">{label}</th><td style=\"width: 70%\">{value}</td></tr>\n",
    'attributes'=>$attribs,
));

$this->endWidget();
?>

<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php

echo CHtml::script('
    function checkDelete(obj)
    {
        $(".pw_field").toggle($(obj).is(":checked"));
    }

    $(function() {
        sel = $("#delete_files");
        sel.change(function() { checkDelete(this); });
        checkDelete(sel);

    });
');
