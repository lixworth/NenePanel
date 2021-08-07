<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('mc', 'Multicraft Installer');

?>
<div class="row">
<div class="col-md-8">
<?php if (!$p['config_exists']): ?>
The configuration file does not exist, please create the file <?php echo $p['config_file'] ?> and make sure it's writable by the webserver.
<?php elseif (!$p['config_writeable']): ?>
The configuration file is not writeable, please ensure that the webserver can write to the config file <?php echo $p['config_file'] ?>
<?php else: ?>
The configuration file exists and is writeable, you are ready to begin the installation.
<?php endif ?>
</div>
<div class="col-md-4">
<?php echo CHtml::beginForm(array('index', 'step'=>'panel'), 'get') ?>
<?php echo CHtml::submitButton('Continue') ?>
<?php echo CHtml::endForm() ?>
</div>
</div>
