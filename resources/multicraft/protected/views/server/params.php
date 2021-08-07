<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Startup Parameters');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('mc', 'Startup Parameters'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$model->id),
        'icon'=>'back',
    ),
);
?>

<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php if ($error): ?>
<div class="flash-error">
    <?php echo $error ?>
</div>
<?php endif ?>

<?php

$cols = array(
    array('header'=>'', 'type'=>'raw', 'headerHtmlOptions'=>array('width'=>'30'),
            'value'=>'CHtml::checkBox("param_".$data["id"], $data["checked"], array(
                "id"=>"param_".$data["id"],
                "ajax"=>array(
                    "type"=>"POST",
                    "data"=>array(
                        Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                        "param"=>$data["id"],
                        "checked"=>"js:$(\'#param_".$data["id"]."\').is(\':checked\') ? 1 : 0",
                    ),
                    "success"=>"js:function(e) {if(e)alert(e);}"
                ),
                "return"=>true,
            ))'),
    array('name'=>'param', 'header'=>Yii::t('mc', 'Parameter'), 'type'=>'raw',
        'headerHtmlOptions'=>array('width'=>'30%'),
        'value'=>'CHtml::label(CHtml::encode($data["param"]), "param_".$data["id"])'),
    array('name'=>'info', 'header'=>Yii::t('mc', 'Information')),
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'configs-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>$cols,
)); ?>



