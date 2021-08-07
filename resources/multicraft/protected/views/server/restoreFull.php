<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Restore Backup');

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
$confirmDel = '"'.CJavaScript::quote(Yii::t('mc', 'This will delete the backup file permanently! Continue?')).'"';
$confirmMove = '"'.CJavaScript::quote(Yii::t('mc', 'This will copy the backup file into your server directory for downloading. Continue?')).'"';
$rename = CJavaScript::quote(Yii::t('mc', 'Please enter the new name of the backup:'));

?>
<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="errorMessage">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php
$cols = array(
    array('name'=>'file', 'header'=>Yii::t('mc', 'File'), 'value'=>'$data["id"]'),
    array('name'=>'time', 'header'=>Yii::t('mc', 'Time'), 'value'=>'$data["time"]'),
    array('name'=>'size', 'header'=>Yii::t('mc', 'Size'), 'value'=>'Theme::formatBytes(@$data["size"])', 'visible'=>$size),
    array('name'=>'action', 'header'=>'', 'headerHtmlOptions'=>array('width'=>'230'),
        'htmlOptions'=>array('style'=>'text-align: center'), 'type'=>'raw',
        'value'=>
            '"<div class=\"btn-group btn-group-xs\">".CHtml::link("'.CJavaScript::quote(Yii::t('mc', 'Restore')).'", "#", array("class"=>"btn btn-default btn-sm btn-group",'
            .'"submit"=>array("server/restoreFull", "id"=>'.$model->id.'),'
            .'"params"=>array("do"=>"true", "action"=>"restore", "file"=>$data["id"]),'
            .'"csrf"=>true,'
            .'"confirm"=>'.$confirm.',))." ".'
            .'CHtml::link("'.CJavaScript::quote(Yii::t('mc', 'Rename')).'", "#", array("class"=>"btn btn-default btn-sm",'
            .'"submit"=>array("server/restoreFull", "id"=>'.$model->id.'),'
            .'"params"=>array("do"=>"true", "action"=>"rename", "file"=>$data["id"], "target"=>"js:target"),'
            .'"csrf"=>true,'
            .'"onclick"=>"target = prompt(\"'.$rename.'\", \"".$data["id"]."\"); if (!target) return false;",))." ".'
            .'CHtml::link("'.CJavaScript::quote(Yii::t('mc', 'Delete')).'", "#", array("class"=>"btn btn-default btn-sm",'
            .'"submit"=>array("server/restoreFull", "id"=>'.$model->id.'),'
            .'"params"=>array("do"=>"true", "action"=>"delete", "file"=>$data["id"]),'
            .'"csrf"=>true,'
            .'"confirm"=>'.$confirmDel.',))." ".'
            .'CHtml::link("'.CJavaScript::quote(Yii::t('mc', 'Copy')).'", "#", array("class"=>"btn btn-default btn-sm",'
            .'"submit"=>array("server/restoreFull", "id"=>'.$model->id.'),'
            .'"params"=>array("do"=>"true", "action"=>"move", "file"=>$data["id"]),'
            .'"csrf"=>true,'
            .'"confirm"=>'.$confirmMove.',))."</div>"'
        ),
);

echo CHtml::css('.topalign td { vertical-align: top }' );
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'configs-grid',
    'ajaxUpdate'=>false,
    'rowCssClass'=>array('even topalign', 'odd topalign'),
    'dataProvider'=>$dataProvider,
    'columns'=>$cols,
)); ?>


