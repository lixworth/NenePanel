<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Multicraft Statistics');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Multicraft Statistics'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('admin', 'Back'),
        'url'=>array('daemon/index'),
        'icon'=>'back',
    ),
);

Yii::app()->clientScript->registerCssFile(Theme::css('detailview.css'));
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Theme::js('bootstrap.min.js'));
Yii::app()->clientScript->registerScriptFile(Theme::js('jquery.knob.min.js'));
Yii::app()->clientScript->registerScriptFile(Theme::js('statistics.js'));
?>

<h3>Statistics</h3>
<div class="row">
    <div class="col-md-3">
        <div class="stat">
            <span class="title"><?php echo Yii::t('admin', 'Active Servers') ?></span>
            <input type="text" data-width="100%" class="dial" data-readOnly=true data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="<?php echo $servers ?>" value="<?php echo $activeServers ?>">
            <div class="info"><?php echo $servers ? round($activeServers / $servers * 100) : 0 ?>% <?php echo Yii::t('admin', 'Of Total') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat">
            <span class="title"><?php echo ucwords(Yii::t('admin', 'Total Assigned RAM')) ?></span>
            <input type="text" data-width="100%" class="dial" data-readOnly=true data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="<?php echo $totalMemory > $memory ? $totalMemory : $memory ?>" value="<?php echo $memory ?>">
            <div class="info"><?php echo $totalMemory ? round($memory / $totalMemory * 100) : 0 ?>% <?php echo Yii::t('admin', 'Of Total') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat">
            <span class="title"><?php echo ucwords(Yii::t('admin', 'Active Server RAM')) ?></span>
            <input type="text" data-width="100%" class="dial" data-readOnly=true data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="<?php echo $totalMemory > $activeMemory ? $totalMemory : $activeMemory ?>" value="<?php echo $activeMemory ?>">
            <div class="info"><?php echo $totalMemory ? round($activeMemory / $totalMemory * 100) : 0 ?>% <?php echo Yii::t('admin', 'Of Total') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat">
            <span class="title"><?php echo ucwords(Yii::t('admin', 'Online Players')) ?></span>
            <input type="text" id="player_dial" data-width="100%" class="dial" data-readOnly=true data-angleOffset="-125" data-angleArc="250" data-min="0" data-max="<?php echo $slots ?>" value="0">
            <div class="info"><span id="player_percent">0</span>% <?php echo Yii::t('admin', 'Used') ?></div>
        </div>
    </div>
</div>

<table class="detail-view">
<tr class="display-upper">
    <td><?php echo Yii::t('admin', 'Total Servers') ?></td>
    <td><?php echo Yii::t('admin', 'Active Servers') ?></td>
    <td><?php echo Yii::t('admin', 'Suspended Servers') ?></td>
    <td><?php echo Yii::t('admin', 'Daemons') ?></td>
    <td><?php echo Yii::t('admin', 'Average servers per daemon') ?></td>
    <td><?php echo Yii::t('admin', 'Total player slots') ?></td>
    <td><?php echo Yii::t('admin', 'Total memory assigned') ?></td>
</tr>
<tr class="display-sub">
    <td><?php echo $servers ?></td>
    <td><?php echo $activeServers ?></td>
    <td><?php echo ($servers - $activeServers) ?></td>
    <td><?php echo $daemons ?></td>
    <td><?php echo number_format($activeSvPerDaemon, 2).' <div class="suspended">('.number_format($svPerDaemon, 2).')</div>' ?></td>
    <td><?php echo $activeSlots.' <div class="suspended">'.$slots.'</div>' ?> </td>
    <td><?php echo $activeMemory.'<small>' . Yii::t('admin', 'MB') . '</small> <div class="suspended">'.number_format($memory).'<small>' . Yii::t('admin', 'MB') . '</small></div>' ?></td>
</tr>
</table>
<span style="float:right; font-size: 10px"><?php echo Yii::t('admin', 'Values in brackets include suspended servers.') ?></span>


<table class="detail-view table table-striped">
<tr class="titlerow">
    <td colspan="3"><?php echo Yii::t('admin', 'Live Statistics') ?></td>
    <td id="status"><i class="fa fa-refresh fa-spin"></i> pending</td>
</tr>
<tr class="display-upper">
    <td><?php echo Yii::t('admin', 'Online servers') ?></td>
    <td><?php echo Yii::t('admin', 'Online players') ?></td>
    <td><?php echo Yii::t('admin', 'Average players per server') ?></td>
    <td><?php echo Yii::t('admin', 'Total memory assigned to online servers') ?></td>
</tr>
<tr class="display-sub">
    <td id="servers"></td>
    <td id="players"></td>
    <td id="avg_players"></td>
    <td id="memory"></td>
</tr>
</table>


<?php

echo CHtml::script('
function stats_response(data)
{
    for (var key in data)
        $("#" + key).html(data[key]);
    $("#status").html("");
}

function query_stats()
{
'.CHtml::ajax(array(
    'type'=>'POST',
    'dataType'=>'json',
    'data'=>array(
        'ajax'=>'stats',
        Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
        ),
    'success'=>'stats_response'
    )).'
}

query_stats();


');
    

