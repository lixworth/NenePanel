<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Archive Restore');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('mc', 'Backup')=>array('server/backup', 'id'=>$model->id),
    Yii::t('mc', 'Restore'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/backup', 'id'=>$model->id),
        'icon'=>'back',
    ),
);

$confirm = '"'.CJavaScript::quote(Yii::t('mc', 'This will overwrite existing files with files from the archive. It is recommended that the server is stopped before performing a restore.

The operation will run in the background and can take a while to complete. See the console for information about the progress of the unpack.')).'"';

?>
<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php
$cols = array(
    array('name'=>'file', 'header'=>Yii::t('mc', 'File'), 'value'=>'$data["id"]'),
    array('name'=>'time', 'header'=>Yii::t('mc', 'Time'), 'value'=>'$data["time"]'),
    array('name'=>'action', 'header'=>'', 'headerHtmlOptions'=>array('width'=>'120'),
        'htmlOptions'=>array('style'=>'text-align: center'), 'type'=>'raw',
        'value'=>'CHtml::link("'.CJavaScript::quote(Yii::t('mc', 'Restore')).'", "#", array(
            "submit"=>array("server/restore", "id"=>'.$model->id.'),
            "params"=>array("restore"=>"true", "file"=>$data["id"]),
            "csrf"=>true,
            "confirm"=>'.$confirm.',
        ))'),
);

echo CHtml::css('.topalign td { vertical-align: top }' );
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'configs-grid',
    'ajaxUpdate'=>false,
    'rowCssClass'=>array('even topalign', 'odd topalign'),
    'dataProvider'=>$dataProvider,
    'columns'=>$cols,
)); ?>


