<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Multicraft Status');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Multicraft Status'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('admin', 'Back'),
        'url'=>array('daemon/index'),
        'icon'=>'back',
    ),
);
?>
<div class="row">
    <div class="col-md-6">
        <?php echo Yii::t('admin', 'Your current panel version is {v}', array('{v}' => $this->version)) ?>
    </div>
    <div class="col-md-6 pull-right text-right">
        <?php echo Yii::t('mc', 'Update list every {field} seconds',
            array('{field}'=>CHtml::textField('refresh_ival', '30', array('size'=>'3', 'class'=>'')))) ?>
    </div>
    &nbsp;
</div>
<?php
$gridView = $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'status-grid',
    'emptyText'=>Yii::t('admin', 'No daemons found.').'<br/><br/>'.Yii::t('admin', 'Please check that at least one daemon is started and that it uses the same database you configured as the daemon database using the control panel installer.'),
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array('name'=>'id', 'headerHtmlOptions'=>array('width'=>'4%')),
        array('name'=>'name', 'headerHtmlOptions'=>array('width'=>'20%')),
        array('header'=>'', 'type'=>'raw', 'headerHtmlOptions'=>array('width'=>'4%'),
            'value'=>'"<div id=\"status_icon_".$data->id."\"><img src=\"'.Theme::themeFile('images/icons/changing.png').'\" alt=\"\"/></div>"'),
        array('name'=>'ip', 'headerHtmlOptions'=>array('width'=>'15%')),
        array('name'=>'port', 'headerHtmlOptions'=>array('width'=>'8%')),
        array('header'=>Yii::t('admin', 'Servers'), 'headerHtmlOptions'=>array('width'=>'7%'), 'value'=>'$data->serverCount'),
        array('header'=>Yii::t('admin', 'Memory'), 'headerHtmlOptions'=>array('width'=>'10%'),
            'value'=>'$data->usedMemory.(@$data->memory?"/".$data->memory:"")."MB"'),
        array('header'=>Yii::t('admin', 'Status'), 'type'=>'raw',
            'value'=>'"<div id=\"status_".$data->id."\"></div>"'),
        array('header'=>'', 'type'=>'raw',
            'value'=>'CHtml::link(Theme::icon("delete"), "#", array(
                "submit"=>array("removeDaemon", "id"=>$data->id),
                "confirm"=>Yii::t("admin", "This will only remove the daemon entry for this server from the database. If the daemon is still running or is started again this entry will be put back in."),
                "csrf"=>true,
            ))',
            'headerHtmlOptions'=>array('width'=>'5%')),
    ),
), true);

echo CHtml::css('.grid-view table.items tbody tr { height: 60px; }');
if(Yii::app()->request->isAjaxRequest)
{
    echo $gridView;
    Yii::app()->end();
}


echo $gridView;

echo CHtml::script('
var refreshDelay = 300;
var itemsPerRefresh = 2;

var curIdx = 0;
var imgs = {
    "success": "'.CJavaScript::quote(Theme::themeFile('images/icons/online.png')).'",
    "error": "'.CJavaScript::quote(Theme::themeFile('images/icons/offline.png')).'"
}

function setField(id, data) {
    if (data) {
        $("#status_" + id).html(data["content"]);
        $("#status_icon_" + id).children("img").attr("src", imgs[data["class"]]);
    }
}

function updateField() {
    var elem = $("#status-grid > table > tbody > tr:nth-child(" + (curIdx++ + 1) + ")");
    var val = parseInt(elem.children("td:first").text());
    if (!val)
    {
        curIdx = 0;
        nextRequest();
        return;
    }
    jQuery.ajax({
        "url": "'.CJavaScript::quote(CHtml::normalizeUrl(array('daemon/ajaxGetDaemonStatus', 'id'=>''))).'" + val,
        "success": function(data) { setField(val, data); },
        "complete": function() { nextRequest(); },
        "dataType": "json",
        "cache": false,
    });
}

function nextRequest() {
    setTimeout(function() { updateField(); }, refreshDelay);
}

function updateAll() {   
    for (var i = 0; i < itemsPerRefresh; i++) {
        updateField();
    }
}

updateAll();

var refreshTimer = 0;

function refreshGrid() {
    $("#status-grid").yiiGridView("update");
}

function refreshIvalChanged() {
    if (refreshTimer) {
        clearInterval(refreshTimer);
        refreshTimer = 0;
    }
    var ival = $("#refresh_ival").val();
    if (ival > 0)
        refreshTimer = setInterval(refreshGrid, ival * 1000);
}

$(function() {
    refreshIvalChanged();

    $("#refresh_ival").bind("keyup input paste", refreshIvalChanged);
});

'); ?>

