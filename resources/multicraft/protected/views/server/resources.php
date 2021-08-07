<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$showCM = ($pid && ($cpu !== null || $memory !== null));
$showQuota = ($quotaUsage !== false && $quotaUsage >= 0 && $model->disk_quota);
if (!$showCM && !$showQuota)
    return;
?>
<h3><?php echo Yii::t('mc', 'Resource usage') ?></h3>
<?php if ($showCM): ?>
<div class="row">
	<div class="col-md-6">
		<h4><?php echo Yii::t('mc', 'CPU') ?></h4>
		<div class="progress progress-striped">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $cpu ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cpu ?>%">
				<?php echo $cpu.Yii::t('mc', '%') ?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<h4><?php echo Yii::t('mc', 'Memory') ?></h4>
		<div class="progress progress-striped">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $memoryPercent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $memoryPercent ?>%">
				<?php echo $memory.$memorySign ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>
<?php
if ($showQuota):
$percent = (int)min(100, 100 * ((float)$quotaUsage / $model->disk_quota));
?>
<div class="row">
	<div class="col-md-12">
		<h4><?php echo Yii::t('mc', 'Disk Space Usage') ?></h4>
		<div class="progress progress-striped">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%">
                <?php echo $quotaUsage.'/'.$model->disk_quota.' '.Yii::t('mc', 'MB') ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>
