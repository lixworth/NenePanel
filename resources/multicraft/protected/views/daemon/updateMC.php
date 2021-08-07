<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Update Minecraft');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Update Minecraft'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('admin', 'Add or Remove Files'),
        'url'=>array('daemon/files'),
        'icon'=>'file',
    ),
    array(
        'label'=>Yii::t('admin', 'Back'),
        'url'=>array('daemon/index'),
        'icon'=>'back',
    ),
);

$gridView = $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'status-grid',
    'emptyText'=>'No match',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array('name'=>'id', 'headerHtmlOptions'=>array('width'=>'5%')),
        array('name'=>'name', 'headerHtmlOptions'=>array('width'=>'25%')),
        array('header'=>'', 'type'=>'raw', 'headerHtmlOptions'=>array('width'=>'4%'),
            'value'=>'"<div id=\"status_icon_".$data->id."\"><img src=\"'.Theme::themeFile('images/icons/changing.png').'\" alt=\"\"/></div>"'),
        array('header'=>Yii::t('admin', 'Status'), 'type'=>'raw',
            'value'=>'"<div id=\"status_".$data->id."\"></div>"'),
        array('header'=>'', 'type'=>'raw',
            'value'=>'CHtml::button(Yii::t("admin", "Go"), array("onclick"=>"javascript:goBtn(".$data->id.")"))',
            'headerHtmlOptions'=>array('width'=>'5%')),
    ),
), true);

if(Yii::app()->request->isAjaxRequest)
{
    echo $gridView;
    Yii::app()->end();
}

?>

<form action="" method="post">
<table class="detail-view">
<tr class="titlerow">
    <td>
        <?php echo Yii::t('admin', 'Update Settings') ?>
    </td>
    <td></td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'File') ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('update-target', '', array(), array('style'=>'min-width: 183px')) ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'Type') ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('update-file', '', $file) ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'Action') ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('update-action', '', $action) ?>
    </td>
</tr>
<tr>
    <td>
    </td>
    <td>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'All Daemons') ?>
    </td>
    <td>
        <?php
        echo CHtml::ajaxSubmitButton(Yii::t('admin', 'Go'), '', array(
            'type'=>'POST',
            'data'=>array(
                'ajax'=>"js:$('#update-action').val()",
                'target'=>"js:$('#update-target').val()",
                'file'=>"js:$('#update-file').val()",
                Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
            ),
            'success'=>'function(e) {if (e) alert(e);}'
        ));
        ?>
    </td>
</tr>
</table>
</form>
<br/>

<?php echo CHtml::script('
function goBtn(daemon) {
    '.CHtml::ajax(array(
        'type'=>'POST',
        'data'=>array(
            'ajax'=>'start',
            'daemon'=>'js:daemon',
            'target'=>"js:$('#update-target').val()",
            'file'=>"js:$('#update-file').val()",
            'ajax'=>"js:$('#update-action').val()",
            Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
        ),
        'success'=>'function(e) {if (e) alert(e);}'
        )).'
    return false;
}

'); 

echo $gridView;

echo CHtml::script('

var refreshDelay = 300;
var itemsPerRefresh = 1;
var jars = {};

var curIdx = 0;
var imgs = {
    "success": "'.CJavaScript::quote(Theme::themeFile('images/icons/online.png')).'",
    "notice": "",
    "error": "'.CJavaScript::quote(Theme::themeFile('images/icons/error.png')).'"
}

function setField(id, data) {
    if (data) {
        $("#status_" + id).html(data["content"]);
        $("#status_icon_" + id).children("img").attr("src", imgs[data["class"]]);

        for (t in data["jars"]) {
            if (jars[t] != true) {
                jars[t] = true;
                $("#update-target").append($("<option/>", { value: t, text : data["jars"][t] }));
            }
        }
    }
}

function updateField() {
    var elem = $("#status-grid > table > tbody > tr:nth-child(" + (curIdx++ + 1) + ")");
    var val = elem.children("td:first").text();
    if (!val) {
        curIdx = 0;
        nextRequest();
        return;
    }
    jQuery.ajax({
        "url": "'.CJavaScript::quote(CHtml::normalizeUrl(array('daemon/ajaxGetUpdateStatus', 'id'=>''))).'" + val,
        "success": function(data) { setField(val, data); },
        "complete": function() { nextRequest(); },
        "dataType": "json",
        "cache": false,
    });
}

function nextRequest(idx) {
    setTimeout(function() { updateField(); }, refreshDelay);
}

function updateAll() {   
    for (var i = 0; i < itemsPerRefresh; i++) {
        updateField();
    }
}

updateAll();

'); ?>

<br/>
<br/>
<div class="infoBox">
<?php echo Yii::t('admin', '<b>.conf file</b>: Contains server binary specific configuration and download links') ?><br/>
<?php echo Yii::t('admin', '<b>JAR File</b>: The server binary itself') ?>
</div>
