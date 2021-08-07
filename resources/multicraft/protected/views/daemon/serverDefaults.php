<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Server Defaults'),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');
echo CHtml::css('
.adv, .perm { display: none; }

#advanced { display: none; }
#files { display: none; }
');

$this->menu = array(array('label'=>Yii::t('mc', 'Back'), 'url'=>array('index'), 'icon'=>'back'));

?>
<div class="infoBox">
    <?php
    echo Yii::t('admin', 'Here you can define the default settings used for new servers. These defaults are also used when creating a server through the API (i.e. using a billing system).');
    ?>
</div>

<?php if(Yii::app()->user->hasFlash('server_error')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('server_error'); ?>
</div>
<?php endif ?>

<?php

//possible values for default_role
$defaultRoles = array_combine(User::$roleLevels, User::getRoleLabels());
array_pop($defaultRoles);//remove owner
array_pop($defaultRoles);//remove coowner
array_pop($defaultRoles);//remove admin
if (isset($defaultRoles[0]))
    $defaultRoles[0] = Yii::t('mc', 'No Access');
//possible values for permission roles
$allRoles = array_combine(User::$roles, User::getRoleLabels());
//possible values for ip authentication
$ipRoles = $allRoles;
array_pop($ipRoles);//remove owner
array_pop($ipRoles);//remove coowner
array_pop($ipRoles);//remove admin

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'server-form',
    'enableAjaxValidation'=>false,
));
echo CHtml::hiddenField('confirm_leave', 'true');

$conIds = McBridge::get()->getDaemonIds();
$conCount = count($conIds);
if ($conCount > 1)
{
    $opt = array();
    $attribs[] = array('label'=>$form->labelEx($model,'daemon_id'), 'type'=>'raw',
        'value'=>$form->dropDownList($model, 'daemon_id', McBridge::get()->conStrings(), $opt)
            .' '.$form->error($model,'daemon_id'),);
}
else
{
    $attribs[] = array('label'=>$form->labelEx($model,'daemon_id'), 'type'=>'raw',
        'value'=>$form->textField($model, 'daemon_id').' '.$form->error($model,'daemon_id'),);
}
$attribs[] = array('label'=>$form->labelEx($model,'name'), 'type'=>'raw',
    'value'=>$form->textField($model,'name').' '.$form->error($model,'name'));
$attribs[] = array('label'=>$form->labelEx($model,'players'), 'type'=>'raw',
    'value'=>$form->textField($model,'players').' '.$form->error($model,'players'));
$attribs[] = array('label'=>$form->labelEx($model,'ip'), 'type'=>'raw',
    'value'=>$form->textField($model,'ip')
        .' '.$form->error($model,'ip'));
$attribs[] = array('label'=>$form->labelEx($model,'port'), 'type'=>'raw',
    'value'=>$form->textField($model,'port')
        .' '.$form->error($model,'port'),
    'hint'=>Yii::t('mc', 'Empty to select automatically'));
$attribs[] = array('label'=>$form->labelEx($model,'memory'), 'type'=>'raw',
    'value'=>$form->textField($model,'memory')
        .' '.$form->error($model,'memory'));
$attribs[] = array('label'=>$form->labelEx($model,'disk_quota'), 'type'=>'raw',
    'value'=>$form->textField($model,'disk_quota')
        .' '.$form->error($model,'disk_quota'),
    'hint'=>Yii::t('mc', 'In MB. Empty for no limit. Requires a server restart to take effect'),
    'visible'=>@Yii::app()->params['enable_disk_quota'] ? true : false);
$attribs[] = array('label'=>$form->labelEx($model, 'cpus'), 'type'=>'raw',
    'value'=>$form->textField($model, 'cpus')
        .' '.$form->error($model, 'cpus'),
    'hint'=>Yii::t('mc', 'The number of CPUs this server can use. 0 for no limit'),
    'visible'=>@Yii::app()->params['enable_cpus'] ? true : false);
$attribs[] = array('label'=>$form->labelEx($model,'jarfile'), 'type'=>'raw',
    'value'=>$form->textField($model,'jarfile').' '.$form->error($model,'jarfile'));
$attribs[] = array('label'=>$form->labelEx($model,'template'), 'type'=>'raw',
    'value'=>$form->textField($model,'template').' '.$form->error($model,'template'),
    'hint'=>Yii::t('mc', 'Name of the template folder or zip file'));
$attribs[] = array('label'=>$form->labelEx($model, 'setup'), 'type'=>'raw',
    'value'=>$form->dropDownList($model, 'setup', Server::getSetupOptions()).' '.$form->error($model, 'setup'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_jar'), 'type'=>'raw',
    'value'=>$form->checkBox($settings,'user_jar')
        .' '.$form->error($settings,'user_jar'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_name'), 'type'=>'raw',
    'value'=>$form->checkBox($settings,'user_name')
        .' '.$form->error($settings,'user_name'));
$attribs[] = array('label'=>Theme::icon('closed', array('id'=>'advImg')).Theme::icon('open', array('class'=>'adv')), 'type'=>'raw',
        'value'=>CHtml::link(CHtml::encode(Yii::t('mc', 'Show Advanced Settings')), '#', array('id'=>'advTxt', 'onclick'=>'return checkAdv()')));
$attribs[] = array('label'=>$form->labelEx($model,'world'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->textField($model,'world').' '.$form->error($model,'world'));
$attribs[] = array('label'=>$form->labelEx($settings,'display_ip'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->textField($settings,'display_ip')
        .' '.$form->error($settings,'display_ip'),
    'hint'=>Yii::t('mc', 'Displayed on banner and in server view. Empty for same as IP'));
$attribs[] = array('label'=>$form->labelEx($model,'start_memory'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->textField($model,'start_memory')
        .' '.$form->error($model,'start_memory'),
    'hint'=>Yii::t('mc', 'In MB. Empty for same as Max. Memory'));
$attribs[] = array('label'=>$form->labelEx($model,'autostart'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($model,'autostart')
        .' '.$form->error($model,'autostart'),
    'hint'=>Yii::t('mc', 'Start this server automatically when Multicraft restarts'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_schedule'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_schedule')
        .' '.$form->error($settings,'user_schedule'),
    'hint'=>Yii::t('mc', 'Owner can create scheduled tasks and change the autosave setting'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_ftp'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_ftp')
        .' '.$form->error($settings,'user_ftp'),
    'hint'=>Yii::t('mc', 'Owner can give FTP access to other users'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_visibility'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_visibility')
        .' '.$form->error($settings,'user_visibility'),
    'hint'=>Yii::t('mc', 'Owner can change the server visibility and Default Role'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_players'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_players')
        .' '.$form->error($settings,'user_players'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_jardir'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_jardir')
        .' '.$form->error($settings,'user_jardir'),
    'hint'=>Yii::t('mc', 'Owner can change the "Look for JARs in" setting'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_templates'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_templates')
        .' '.$form->error($settings,'user_templates'),
    'hint'=>Yii::t('mc', 'Owner can use the Setup/Template functionality'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_params'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_params')
        .' '.$form->error($settings,'user_params'),
    'hint'=>Yii::t('mc', 'Owner can select additional server startup parameters'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_memory'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_memory')
        .' '.$form->error($settings,'user_memory'),
    'hint'=>Yii::t('mc', 'Owner can change the amount of server memory'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_crash_check'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_crash_check')
        .' '.$form->error($settings,'user_crash_check'),
    'hint'=>Yii::t('mc', 'Owner can change basic crash detection settings. If crash detection is disabled globally the user settings will have no effect'));
$attribs[] = array('label'=>$form->labelEx($settings,'user_subdomain'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_subdomain')
        .' '.$form->error($settings,'user_subdomain'),
    'visible'=>@Yii::app()->params['user_subdomains'] ? true : false);
$attribs[] = array('label'=>$form->labelEx($settings,'user_mysql'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_mysql')
        .' '.$form->error($settings,'user_mysql'),
    'visible'=>@Yii::app()->params['user_mysql'] ? true : false);
$attribs[] = array('label'=>$form->labelEx($settings,'user_add_ports'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($settings,'user_add_ports')
        .' '.$form->error($settings,'user_add_ports'),
    'visible'=>@Yii::app()->params['additional_ports'] ? true : false);
$attribs[] = array('label'=>$form->labelEx($model,'jardir'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->dropDownList($model,'jardir',Server::getJardirs())
        .' '.$form->error($model,'jardir'),
    'hint'=>Yii::t('mc', '(* Warning: Be sure to run Multicraft in "multiuser" mode with this!)'));
$attribs[] = array('label'=>$form->labelEx($model,'kick_delay'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->textField($model,'kick_delay')
        .' '.$form->error($model,'kick_delay'),
    'hint'=>Yii::t('mc', 'After how many milliseconds to kick players without access'));
$attribs[] = array('label'=>$form->labelEx($model,'autosave'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($model,'autosave')
    .' '.$form->error($model,'autosave'),
    'hint'=>Yii::t('mc', 'Regularly save the world to the disk'));
$attribs[] = array('label'=>$form->labelEx($model,'announce_save'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->checkBox($model,'announce_save')
        .' '.$form->error($model,'announce_save'),
    'hint'=>Yii::t('mc', 'Inform the players when the world has been saved'));
$attribs[] = array('label'=>$form->labelEx($model, 'crash_check'), 'type'=>'raw', 'cssClass'=>'adv',
    'value'=>$form->dropDownList($model, 'crash_check', Server::getCrashCheckModes())
    .' '.$form->error($model, 'crash_check'),
    'hint'=>Yii::t('mc', '"Strict" requires specific command output configured by the hosting provider, for "Basic" any console ouput is sufficient'));
$attribs[] = array('label'=>Theme::icon('closed', array('id'=>'permImg')).Theme::icon('open', array('class'=>'perm')), 'type'=>'raw',
        'value'=>CHtml::link(CHtml::encode(Yii::t('mc', 'Show Permissions')), '#', array('id'=>'permTxt', 'onclick'=>'return checkPerm()')));
$attribs[] = array('label'=>$form->labelEx($settings,'visible'), 'type'=>'raw', 'cssClass'=>'perm',
    'value'=>$form->dropDownList($settings,'visible',ServerConfig::getVisibility())
        .' '.$form->error($settings,'visible'),
    'hint'=>Yii::t('mc', 'Visibility in the Multicraft server list'));
$attribs[] = array('label'=>$form->labelEx($model,'default_level'), 'type'=>'raw', 'cssClass'=>'perm',
    'value'=>$form->dropDownList($model,'default_level',$defaultRoles)
        .' '.$form->error($model,'default_level'),
    'hint'=>Yii::t('mc', 'Role assigned to players on first connect ("No Access" for whitelisting)'));
$attribs[] = array('label'=>$form->labelEx($settings,'ip_auth_role'), 'type'=>'raw', 'cssClass'=>'perm',
    'value'=>$form->dropDownList($settings,'ip_auth_role', $ipRoles)
        .' '.$form->error($settings,'ip_auth_role'),
    'hint'=>Yii::t('mc', 'For users whose IP matches a player ingame'),
    'visible'=>@Yii::app()->params['ip_auth'] ? true : false);
$attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'Cheat Role'),'cheat_role'), 'type'=>'raw', 'cssClass'=>'perm',
    'value'=>CHtml::dropDownList('cheat_role', $settings->give_role, $allRoles),
    'hint'=>Yii::t('mc', 'Role required to use web based give/teleport'));
$attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('mc', 'Save'), array('id'=>'saveButton')));

?>
<br/>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
));

$this->endWidget();

echo CHtml::script('
    advShow = false;
    txtOpen = "'.CJavaScript::quote(Yii::t('mc', 'Hide Advanced Settings')).'";
    txtClosed = "'.CJavaScript::quote(Yii::t('mc', 'Show Advanced Settings')).'";
    function checkAdv() {
        advShow = !advShow;
        $("#advImg").toggle(!advShow);
        $("#advTxt").html(advShow ? txtOpen : txtClosed);
        $(".adv").toggle(advShow);
        return false;
    }
    $("#adv_opts").change(function() { checkAdv(); });
    '.(@$advanced ? '$(function() { checkAdv(); });' : '').'
');

echo CHtml::script('
    permShow = false;
    permTxtOpen = "'.CJavaScript::quote(Yii::t('mc', 'Hide Permissions')).'";
    permTxtClosed = "'.CJavaScript::quote(Yii::t('mc', 'Show Permissions')).'";
    function checkPerm() {
        permShow = !permShow;
        $("#permImg").toggle(!permShow);
        $("#permTxt").html(permShow ? permTxtOpen : permTxtClosed);
        $(".perm").toggle(permShow);
        return false;
    }
    $("#perm_opts").change(function() { checkPerm(); });
    '.(@$advanced ? '$(function() { checkPerm(); });' : '').'
');

echo CHtml::script('
jQuery(function($) {
$("#server-form :input").bind("change", function() { setChanged(true); });
$("#saveButton").click(function() { setChanged(false); });

function confirmLeave() {
    if ($("#confirm_leave").val() == "true")
        return "'.CJavaScript::quote(Yii::t('mc', 'Leave page without saving changes?')).'";
}
function setChanged(changed) {
    if (changed)
        $(window).bind("beforeunload", confirmLeave);
    else
        $(window).unbind("beforeunload");
}
});
');
?>
