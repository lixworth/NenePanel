<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$title = Yii::t('mc', '{source} Plugin List', array('{source}'=>$source));
$this->pageTitle = Yii::app()->name . ' - '.$title.' - '.CHtml::encode($plugin->name);

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    $title=>array('pluginList', 'id'=>$model->id),
    $plugin->name,
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/pluginList', 'id'=>$model->id, 'installed'=>$installed,
            'ServerPlugin_page'=>@$_GET['ServerPlugin_page']),
        'icon'=>'back',
    ),
);

?>

<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif ?>

<?php if (count($plugin->getGameVersions())): ?>
<div class="plugin_version_info">
<table class="plugin_version_table">
<thead>
<tr>
    <th><?php echo Yii::t('mc', 'Server Version') ?></th>
    <th><?php echo Yii::t('mc', 'Compatible Plugin Versions') ?></th>
</tr>
</thead>
<tbody>
<?php
foreach ($plugin->getGameVersions() as $gv=>$v)
    echo '<tr><td>'.CHtml::encode($gv).'</td><td>'.CHtml::encode(implode(', ', $v)).'</td></tr>';
?>
</tbody>
</table>
</div>
<?php endif ?>

<h1><?php echo CHtml::encode($plugin->name) ?></h1>
<?php
    $authors = $plugin->authors;
    if ($authors)
        echo Yii::t('mc', 'by {author}', array('{author}'=>CHtml::encode($authors))).'<br/>';
?>
<br/>
<h5><?php echo Yii::t('mc', 'Description') ?></h5>
<?php echo CHtml::encode(CHtml::decode($plugin->description)) ?><br/>
<?php echo CHtml::link(CHtml::encode(Yii::t('mc', 'more')), $plugin->link) ?><br/>
<br/>
<h5><?php echo Yii::t('mc', 'Plugin Page') ?></h5>
<?php echo CHtml::link(CHtml::encode($plugin->link), $plugin->link) ?><br/>
<br/>
<h5><?php echo Yii::t('mc', 'Status') ?></h5>
<?php
function button($label, $action, $data = array())
{
    echo CHtml::ajaxButton($label, '', array(
        'type'=>'POST',
        'data'=>$data + array(
            'ajax'=>$action,
            Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken
        ),
        'beforeSend'=>'js:runAction("'.CJavaScript::quote($action).'")',
        'success'=>'actionSuccess',
        'error'=>'actionError',
    ), array(
        'id'=>$action,
    ));
}

?>
<div id="actions">

    <span id="info_disabled">
        <?php echo Yii::t('mc', 'Disabled') ?>
    </span>
    <span id="info_installed">
        <?php echo Yii::t('mc', 'Installed') ?>
    </span>
    <span id="info_notinstalled">
        <?php echo Yii::t('mc', 'Not installed') ?>
    </span>
    <span id="info_version">
         (<?php echo Yii::t('mc', 'Version') ?>: <span id="version_number"><?php echo CHtml::encode(@$versions[$version]['version']) ?></span>)
    </span>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <?php
            button(Yii::t('mc', 'Enable'), 'enable');
            button(Yii::t('mc', 'Disable'), 'disable');
            button(Yii::t('mc', 'Remove'), 'remove');
            ?>
        </div>
    </div>
<?php
    $versions = $plugin->getVersions();
    $vList = array();
    if (count($versions))
    {
        foreach ($versions as $k=>$v)
            $vList[$k] = $v['version'].' - '.@date('M d, Y', $v['date']).($v['type'] ? ' - '.$v['type'] : '');
    }
    echo Yii::t('mc', 'Version');
?>
    <div class="row">
        <div class="col-md-8">
            <?php echo CHtml::dropDownList('version', $version, $vList, array('style'=>'width: 100%')); ?>
        </div>
        <div class="col-md-4">
            <span>
                <?php button(Yii::t('mc', 'Install'), 'install', array('version'=>'js:$("#version").val()')); ?>
            </span>
            <span>
                <?php button(Yii::t('mc', 'Change to'), 'update', array('version'=>'js:$("#version").val()')); ?>
            </span>
        </div>
    </div>
</div>
<div id="pending" style="display: none">

<div class="plugin_action_pending"><?php echo Theme::img('gridview/loading.gif') ?></div>
&nbsp;&nbsp;
<?php echo Yii::t('mc', 'Please wait for the action to complete.') ?>
</div>

<?php
echo CHtml::script('
    var expect = "none";
    var expectV = "none";
    var checkTimeout = 15;
    var checkCount = 0;
    var prevStatus = "none";
    var prevVersion = "none";

    function refresh() {
        '.CHtml::ajax(array('type'=>'POST', 'dataType'=>'json',
                'success'=>'js:set_status', 'data'=>array('ajax'=>'get_status',
                    Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                )
            )).'
    }

    function set_status(data) {
        status = data["status"];
        version = data["version"];
        if (expect != "none") {
            checkCount++;
            if (checkCount >= checkTimeout || (status == expect && (expectV == "none" || expectV == version))) {
                $("#actions").show();
                $("#pending").hide();
                expect = "none";
                expectV = "none";
                if (checkCount >= checkTimeout)
                    alert("'.CJavaScript::quote(Yii::t('mc', 'The operation timed out, please check the console for more information.')).'");
                checkCount = 0;
            }
        }
        scheduleRefresh();
        if (status == prevStatus && version == prevVersion)
            return;
        prevStatus = status;
        prevVersion = version;
        if (status == "installed" || status == "disabled") {
            $("#update").show();
            $("#remove").show();
            $("#install").hide();
            if (status == "disabled") {
                $("#enable").show();
                $("#disable").hide();
                $("#info_disabled").show();
                $("#info_installed").hide();
            }
            else {
                $("#disable").show();
                $("#enable").hide();
                $("#info_installed").show();
                $("#info_disabled").hide();
            }
            $("#info_version").show();
            $("#version_number").text((vn = $("#version option[value=\'" + version + "\']").text()) ? vn : version);
            $("#info_notinstalled").hide();
        }
        else {
            $("#install").show();
            $("#info_notinstalled").show();
            $("#update").hide();
            $("#remove").hide();
            $("#enable").hide();
            $("#disable").hide();
            $("#info_disabled").hide();
            $("#info_installed").hide();
            $("#info_version").hide();
        }
    }

    function scheduleRefresh(delay) {
        setTimeout(function() { refresh(); }, '.((int)Yii::app()->params['ajax_update_interval']).');
    }

    $(document).ready(function() {
        set_status({"status": "'.CJavaScript::quote(CHtml::encode($status)).'", "version": "'.CJavaScript::quote(CHtml::encode($version)).'"});
    });

    function runAction(action) {
        if (action == "remove")
            expect = "";
        else if (action == "disable")
            expect = "disabled";
        else if (action == "enable")
            expect = "installed";
        else if (action == "install")
            expect = "installed";
        else if (action == "update") {
            expect = "installed";
            expectV = $("#version").val();
        }
        $("#actions").hide();
        $("#pending").show();
        checkCount = 0;
    }

    function actionSuccess(e) {
        if (e) {
            alert(e);
            expect = prevStatus;
            expectV = "none";
        }
    }

    function actionError() {
        alert("'.CJavaScript::quote(Yii::t('mc', 'Failed to send request.')).'");
        expect = prevStatus;
        expectV = "none";
    }
');
?>
<br/>
<br/>
<br/>
