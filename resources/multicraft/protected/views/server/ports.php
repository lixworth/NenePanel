<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Additional Ports');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('mc', 'Additional Ports'),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

$this->menu = array(
    array(
        'label'=>Yii::t('mc', 'Add Port'),
        'url'=>'#',
        'icon'=>'create',
        'linkOptions'=>array(
            'submit'=>array('ports', 'id'=>$model->id),
            'params'=>array('action'=>'add'),
            'csrf'=>true,
        ),
        'visible'=>count($ports) < Yii::app()->params['additional_ports'],
    ),
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$model->id),
        'icon'=>'back',
    )
);
?>
<?php if (Yii::app()->user->hasFlash('server_error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('server_error'); ?>
</div>
<?php endif ?>

<?php

$removeLink = 'CHtml::link(Yii::t("mc", "Remove"), "#", array(
    "submit"=>array("ports", "id"=>'.$model->id.'),
    "params"=>array("action"=>"remove", "port"=>$data["id"]),
    "confirm"=>Yii::t("mc", "Remove this port?"),
    "csrf"=>true,
))';
$cols = array(
    array('name'=>'port', 'header'=>Yii::t('mc', 'Port'), 'type'=>'raw',
        'headerHtmlOptions'=>array('width'=>'30%'),
        'value'=>'CHtml::label(CHtml::encode($data["id"]), "port_".$data["id"])'),
    array('name'=>'action', 'header'=>'', 'type'=>'raw', 'value'=>$removeLink),
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'configs-grid',
    'dataProvider'=>new CArrayDataProvider($ports),
    'columns'=>$cols,
)); ?>

<?php
if (Yii::app()->user->isStaff())
{
    echo CHtml::beginForm();
    echo CHtml::hiddenField('action', 'admin_add');
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>array(),
        'attributes'=>array(
            array('label'=>Yii::t('mc', 'Add specific port'), 'type'=>'raw', 'value'=>CHtml::textField('admin_port')),
            array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Add Port'))),
        ),
    ));
    echo CHtml::endForm();
}
?>

