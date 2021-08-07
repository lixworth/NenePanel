<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Add or Remove Files');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Update Minecraft'),
    Yii::t('admin', 'Add or Remove Files'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('admin', 'Back'),
        'url'=>array('daemon/updateMc'),
        'icon'=>'back',
    ),
);
?>
<?php if(Yii::app()->user->hasFlash('files-success')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('files-success'); ?>
</div>
<?php endif ?>
<?php if(Yii::app()->user->hasFlash('files-error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('files-error'); ?>
</div>
<?php endif ?>
<?php echo CHtml::beginForm() ?>
<table class="stdtable" style="width: 100%">
<tr class="titlerow">
    <td width="170"><?php echo Yii::t('admin', 'Daemon') ?></td>
    <td><?php echo CHtml::dropDownList('daemon_id', $daemon_id, array(''=>Yii::t('admin', 'All Daemons')) + McBridge::get()->conStrings()) ?></td>
</tr>
</table>
<br/>
<table class="stdtable" style="width: 100%">
<tr class="titlerow">
    <td width="170"><?php echo Yii::t('admin', 'Add Files') ?></td>
    <td></td>
</tr>
<tr class="linerow"><td colspan="2"></td></tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'JAR Filename') ?>
    </td>
    <td>
        <?php echo CHtml::textField('download-target', @$_POST['download-target'], array('style'=>'width: 95%')) ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'File URL') ?>
    </td>
    <td>
        <?php echo CHtml::textField('download-file', @$_POST['download-file'], array('style'=>'width: 95%')) ?>
    </td>
    <td> </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'Conf URL') ?>
    </td>
    <td>
        <?php echo CHtml::textField('download-conf', @$_POST['download-conf'],  array('style'=>'width: 95%')) ?>
    </td>
</tr>
<tr>
    <td>
        <?php
        echo CHtml::submitButton(Yii::t('admin', 'Add'), array('name'=>'do_download'));
        ?>
    </td>
    <td></td>
</tr>
</table>
<br/>
<table class="stdtable" style="width: 100%">
<tr class="titlerow">
    <td width="170"><?php echo Yii::t('admin', 'Remove Files') ?></td>
    <td></td>
</tr>
<tr class="linerow"><td colspan="2"></td></tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'JAR Filename') ?>
    </td>
    <td>
        <?php
        if (count($jars))
            echo CHtml::dropDownList('delete-target', @$_POST['delete-target'], $jars);
        else
            echo CHtml::textField('delete-target', @$_POST['delete-target']);
        ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'Type') ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('delete-file', @$_POST['delete-file'], array(''=>'Select', 'file'=>'JAR File', 'conf'=>'.conf File', 'both'=>'Both Files'), array('style'=>'width: 95%')) ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo Yii::t('admin', 'New JAR setting for servers using the removed JAR') ?>
    </td>
    <td>
        <?php
        if (count($jars))
            echo CHtml::dropDownList('delete-switchto', @$_POST['delete-switchto'], array(''=>'No Change', 'empty'=>'Default') + $jars);
        else
            echo CHtml::textField('delete-switchto', @$_POST['delete-switchto']);
        ?>
    </td>
</tr>
<tr>
    <td>
        <?php echo CHtml::submitButton(Yii::t('admin', 'Remove'), array('name'=>'do_delete')) ?>
    </td>
    <td></td>
</tr>
</table>
<?php echo CHtml::endForm() ?>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<div class="infoBox">
<?php echo Yii::t('admin', 'The target filename should always be of the format "example.jar". The downloaded files will automatically be named "example.jar" and "example.jar.conf" no matter how they were named in their original location. To skip one of the files you can simply leave the URL field empty.') ?><br/>
<br/>
<?php echo Yii::t('admin', 'When you want to delete the "example.jar.conf" you can enter "example.jar" as the file to delete and then select ".conf File" in the drop down menu. Seleting "Both Files" will delete both the "example.jar" and the "example.jar.conf".') ?>
</div>
