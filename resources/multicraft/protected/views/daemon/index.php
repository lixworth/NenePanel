<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Minecraft Manager Settings');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings'),
);

$this->menu=array(
        array(
            'label'=>Yii::t('admin', 'Update Minecraft'),
            'url'=>array('daemon/updateMC'),
            'icon'=>'update',
        ),
        array(
            'label'=>Yii::t('admin', 'Multicraft Status'),
            'url'=>array('daemon/status'),
            'icon'=>'status',
        ),
        array(
            'label'=>Yii::t('admin', 'Panel Configuration'),
            'url'=>array('daemon/panelConfig'),
            'icon'=>'config',
        ),
        array(
            'label'=>Yii::t('admin', 'Statistics'),
            'url'=>array('daemon/statistics'),
            'icon'=>'statistics',
        ),
        array(
            'label'=>Yii::t('admin', 'Operations'),
            'url'=>array('daemon/operations'),
            'icon'=>'operations',
        ),
        array(
            'label'=>Yii::t('admin', 'Config File Settings'),
            'url'=>array('configFile/index'),
            'icon'=>'file',
        ),
        array(
            'label'=>Yii::t('admin', 'Server Defaults'),
            'url'=>array('daemon/serverDefaults'),
            'icon'=>'config',
        ),
        array(
            'label'=>Yii::t('mc', 'Help'),
            'url'=>'#',
            'icon'=>'help',
            'linkOptions'=>array(
                'submit'=>'http://multicraft.org/site/docs?view=settings#global_settings',
                'target'=>'_blank',
                'confirm'=>Yii::t('mc', "You are leaving your control panel.\n\nYou will be forwarded to the documentation on the official Multicraft website.")),
        ),
    );

Yii::app()->clientScript->registerCssFile(Theme::css('detailview.css'));
Yii::app()->getClientScript()->registerCoreScript('jquery');
?>

<?php echo CHtml::beginForm() ?>
<?php echo CHtml::hiddenField('submit', 'true') ?>
<table class="detail-view">
<tr class="titlerow">
    <td><?php echo Yii::t('admin', 'Setting') ?></td>
    <td></td>
    <td><?php echo Yii::t('admin', 'Default') ?></td>
</tr>
<?php
echo CHtml::css('.adv { display: none; }');
$i = 0;
$adv = false;
foreach ($settings as $name=>$setting): ?>
<?php if (@$setting['adv'] && !$adv): ?>
<tr class="<?php echo ($i++ % 2) ? 'even' : 'odd' ?>"style="height: 32px" >
    <td><?php echo Theme::icon('closed', array('id'=>'advImg')).Theme::icon('open', array('class'=>'adv')) ?></td>
    <td><?php echo CHtml::link(Yii::t('admin', 'Show Advanced Settings'), '#', array('id'=>'advTxt', 'onclick'=>'return checkAdv()')) ?></td>
    <td></td>
</tr>
<?php $adv = true ?>
<?php endif ?>
<tr class="<?php echo ($i++ % 2) ? 'even' : 'odd' ?><?php echo (@$setting['adv'] ? ' adv' : '') ?>">
    <th><?php echo CHtml::label($setting['label'], 'Setting['.$name.']') ?></th>
    <?php if ($setting['unit'] == 'bool'): ?>
    <td><?php echo CHtml::checkBox('Setting['.$name.']', $setting['value']) ?></td>
    <td class="default"><?php echo $setting['default'] ? Yii::t('admin', 'true') : Yii::t('admin', 'false') ?></td>
    <?php elseif (is_array($setting['unit'])): ?>
    <td><?php echo CHtml::dropDownList('Setting['.$name.']', $setting['value'], $setting['unit']) ?></td>
    <td class="default"><?php echo $setting['unit'][$setting['default']] ?></td>
    <?php else: ?>
    <td style="width: 35%">
         <?php if (!empty($setting['unit'])): ?>
            <div class="input-group">
                <?php echo CHtml::textField('Setting['.$name.']', $setting['value']) ?>
                <span class="input-group-addon"><?php echo $setting['unit'] ?></span>
            </div>
        <?php else: ?>
            <?php echo CHtml::textField('Setting['.$name.']', $setting['value']) ?>
        <?php endif ?>
    </td>
    <td class="default hintRow"><?php echo $setting['default'].' '.$setting['unit'] ?>
    <?php if (@$setting['hint']): ?>
        &nbsp;<a class="hint" data-content="<?php echo htmlentities($setting['hint'], ENT_QUOTES, 'UTF-8') ?>"><?php echo Theme::img('icons/hint.png', '', array('class'=>'hintIcon')) ?></a>
    <?php endif ?>
    </td>
    <?php endif ?>
</tr>
<?php endforeach ?>
<tr>
    <td></td>
    <td><?php echo CHtml::submitButton(Yii::t('admin', 'Save')) ?></td>
    <td></td>
</tr>
</table>
<?php
echo CHtml::script('
    advShow = false;
    txtOpen = "'.CJavaScript::quote(Yii::t('admin', 'Hide Advanced Settings')).'";
    txtClosed = "'.CJavaScript::quote(Yii::t('admin', 'Show Advanced Settings')).'";
    function checkAdv()
    {
        advShow = !advShow;
        $("#advImg").toggle(!advShow);
        $("#advTxt").html(advShow ? txtOpen : txtClosed);
        $(".adv").toggle(advShow);
        return false;
    }
    '.(@$advanced ? '$(function() { checkAdv(); });' : '').'
');
echo CHtml::endForm();
?>
<br/>
