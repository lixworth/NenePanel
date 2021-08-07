<?php
$showCM = ($pid && ($cpu !== null || $memory !== null));
$showQuota = ($quotaUsage !== false && $quotaUsage >= 0 && $model->disk_quota);
if (!$showCM && !$showQuota)
    return;
?>
<br/>
<br/>
<table style="width: 100%" class="stdtable">
<tr class="titlerow"> 
    <td><?php echo Yii::t('mc', 'Resource usage') ?></td>
</tr>
<tr class="linerow">
    <td></td>
</tr>
<tr><td></td></tr>
</table>
<?php if ($showCM): ?>
<div style="float: left; width: 50%"><?php echo Yii::t('mc', 'CPU') ?></div>
<div style="float: left"><?php echo Yii::t('mc', 'Memory') ?></div>
<div style="clear: both"></div>
<div style="float: left; width: 50%">
    <div id="resource_cpu" style="width: 82%; border: 1px solid #555; position: relative">
        <div style="width: <?php echo $cpu ?>%; background-color: #C6D880; height: 100%">&nbsp;</div>
        <div style="width: 100%; position: absolute; top: 0; left: 0; height: 100%; text-align: center">
            <?php echo $cpu.Yii::t('mc', '%') ?>
        </div>
    </div>
</div>
<div id="resource_cpu" style="float: left; width: 41%; border: 1px solid #555; position: relative">
    <div style="width: <?php echo $memoryPercent ?>%; background-color: #C6D880; height: 100%">&nbsp;</div>
    <div style="width: 100%; position: absolute; top: 0; left: 0; height: 100%; text-align: center">
        <?php echo $memory.$memorySign ?>
    </div>
</div>
<div style="clear: both"></div>
<br/>
<?php endif ?>
<?php
if ($showQuota):
$percent = min(100, 100 * ((float)$quotaUsage / $model->disk_quota));
?>
<div><?php echo Yii::t('mc', 'Disk Space Usage') ?></div>
<div id="resource_quota" style="width: 91%; border: 1px solid #555; position: relative">
    <div style="width: <?php echo (int)$percent ?>%; background-color: #C6D880; height: 100%">&nbsp;</div>
    <div style="width: 100%; position: absolute; top: 0; left: 0; height: 100%; text-align: center">
        <?php echo $quotaUsage.'/'.$model->disk_quota.' '.Yii::t('mc', 'MB') ?>
    </div>
</div>
<br/>
<?php endif ?>
