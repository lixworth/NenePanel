<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$title = Yii::t('mc', '{source} Plugin List', array('{source}'=>@$srcs[$plugins->source_id]));
$ciTitle = Yii::t('mc', 'Currently Installed');
$this->pageTitle = Yii::app()->name . ' - '.$title.($installed ? ' - '.$ciTitle : '');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
);
if ($installed)
{
    $this->breadcrumbs[$title] = array('server/pluginList', 'id'=>$model->id);
    $this->breadcrumbs[] = $ciTitle;
}
else
    $this->breadcrumbs[] = $title;

$this->menu = array();
if (!$installed)
{
    $this->menu[] = array(
        'label'=>$ciTitle,
        'url'=>array('server/pluginList', 'id'=>$model->id, 'installed'=>true),
        'icon'=>'plugin',
    );
}
$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>array(($installed ? 'server/pluginList' : 'server/view'), 'id'=>$model->id),
    'icon'=>'back',
);

$get = $_GET;
unset($get['source_id']);
unset($get['cat']);
echo CHtml::beginForm('?'.http_build_query($get), 'GET');
?>
<div class="row">
<div class="col-md-3">
<?php echo Yii::t('mc', 'Source') ?>
<?php echo CHtml::dropDownList('source_id', $plugins->source_id, $srcs); ?>
</div>
<div class="col-md-9">
<?php echo Yii::t('mc', 'Category') ?>
<?php echo CHtml::dropDownList('cat', $plugins->categories, array(''=>'All Categories') + array_combine($cats, $cats)); ?>
</div>
</div>

<?php
echo CHtml::endForm();
echo CHtml::script('$("#cat,#source_id").change(function() {
            $(this).closest("form").submit();
        });
');
?>

<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php

$cols = array(
    array('name'=>'name', 'type'=>'raw', 'value'=>'CHtml::link(CHtml::encode($data->name), array("plugin", "id"=>'.$model->id.', "installed"=>'.($installed ? 'true' : 'false').', "source_id"=>$data->source_id, "plugin_id"=>$data->id, "ServerPlugin_page"=>@$_GET["ServerPlugin_page"]))'),
    array('name'=>'description', 'type'=>'html', 'value'=>'substr($data->description, 0, 64).(strlen($data->description) > 64 ? "..." : "")'),
);
if (count($allStatus) > 1)
    $cols[] = array('name'=>'stage', 'filter'=>array_combine($allStatus, $allStatus));
$cols[] = array('name'=>'updated', 'value'=>'(@date("Ymd") == @date("Ymd", $data->updated))'
    .' ? '.CJSON::encode(Yii::t('mc', 'Today')).'.", ".@date("H:i", $data->updated) : @date("M d, Y", $data->updated)');

echo CHtml::css('.topalign td { vertical-align: top }' );
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'configs-grid',
    'filter'=>$plugins,
    'ajaxUpdate'=>false,
    'rowCssClass'=>array('even topalign', 'odd topalign'),
    'dataProvider'=>$plugins->search($installed ? $model->id : 0),
    'columns'=>$cols,
)); ?>

<br/>
<br/>
