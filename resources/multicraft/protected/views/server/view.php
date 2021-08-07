<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->isNewRecord ? Yii::t('mc', 'New Server') : ($my ? 'Server' : $model->name),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/server.js');
echo CHtml::css('
.adv, .perm { display: none; }

#advanced { display: none; }
#files { display: none; }
');

if (!$model->isNewRecord)
{
$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Chat'),
        'url'=>array('chat', 'id'=>$model->id),
        'visible'=>$chat,
        'icon'=>'chat'
    ),
    array(
        'label'=>$command ? Yii::t('mc', 'Console') : Yii::t('mc', 'Log'),
        'url'=>array('log', 'id'=>$model->id),
        'visible'=>$viewLog,
        'icon'=>'console'
    ),
    array(
        'label'=>Yii::t('mc', 'Players'),
        'url'=>array('/player/index', 'sv'=>$model->id),
        'visible'=>$managePlayers, 'icon'=>'player'
    ),
    array(
        'label'=>Yii::t('mc', 'Files'),
        'url'=>'javascript:showSub("files")',
        'icon'=>['closed', 'open'],
        'linkOptions'=>array('id'=>'files_main'),
        'submenuOptions'=>array('id'=>'files'),
        'visible'=>$editConfigs || $pluginList || $localPlugins || $manageUsers || $templates || $backup,
        'items'=>array(
            array(
                'label'=>Yii::t('mc', 'Config Files'),
                'url'=>array('configs', 'id'=>$model->id),
                'visible'=>$editConfigs,
                'icon'=>'config'
            ),
            array(
                'label'=>Yii::t('mc', 'Plugin List'),
                'url'=>array('pluginList', 'id'=>$model->id),
                'visible'=>$pluginList ? true : false,
                'icon'=>'plugin'
            ),
            array(
                'label'=>Yii::t('mc', 'Local Plugins'),
                'url'=>array('localPlugins', 'id'=>$model->id),
                'visible'=>$localPlugins,
                'icon'=>'plugin'
            ),
            array(
                'label'=>Yii::t('mc', 'FTP File Access'),
                'url'=>array((Yii::app()->params['ftp_client_disabled'] !== true) ? '/ftpClient/index'
                    : 'ftp', 'id'=>$model->id),
                'icon'=>'file'
            ),
            array(
                'label'=>Yii::t('mc', 'Setup'),
                'url'=>array('setup', 'id'=>$model->id),
                'visible'=>$templates,
                'icon'=>'file'
            ),
            array(
                'label'=>Yii::t('mc', 'Backup'),
                'url'=>array('backup', 'id'=>$model->id),
                'visible'=>$backup,
                'icon'=>'backup'
            ),
        )
    ),
    array(
        'label'=>Yii::t('mc', 'Advanced'),
        'url'=>'javascript:showSub("advanced")',
        'icon'=>['closed', 'open'],
        'linkOptions'=>array('id'=>'advanced_main'),
        'submenuOptions'=>array('id'=>'advanced'),
        'visible'=>$manageCommands || $schedule || $manageUsers || $params || $mysql,
        'items'=>array(
            array(
                'label'=>Yii::t('mc', 'Commands'),
                'url'=>array('/command/index', 'sv'=>$model->id),
                'visible'=>$manageCommands,
                'icon'=>'command'
            ),
            array(
                'label'=>Yii::t('mc', 'Scheduled Tasks'),
                'url'=>array('/schedule/index', 'sv'=>$model->id),
                'visible'=>$schedule,
                'icon'=>'schedule'),
            array(
                'label'=>Yii::t('mc', 'Users'),
                'url'=>array('users', 'id'=>$model->id),
                'visible'=>$manageUsers,
                'icon'=>'user'
            ),
            array(
                'label'=>Yii::t('mc', 'Startup Parameters'),
                'url'=>array('params', 'id'=>$model->id),
                'visible'=>$params,
                'icon'=>'params'
            ),
            array(
                'label'=>Yii::t('mc', 'MySQL Database'),
                'url'=>array('mysqlDb', 'id'=>$model->id),
                'visible'=>$mysql,
                'icon'=>'mysql'
            ),
            array(
                'label'=>Yii::t('mc', 'Additional Ports'),
                'url'=>array('ports', 'id'=>$model->id),
                'visible'=>$ports,
                'icon'=>'params'
            ),
        )
    ),
    array(
        'label'=>$model->suspended ? Yii::t('mc', 'Resume Server') : Yii::t('mc', 'Suspend Server'),
        'url'=>'#',
        'visible'=>(Yii::app()->user->isStaff() && !$model->isNewRecord),
        'icon'=>($model->suspended ? 'resume' : 'suspend'),
        'linkOptions'=>array(
            'submit'=>array($model->suspended ? 'resume' : 'suspend', 'id'=>$model->id),
            'csrf'=>true,
            ($model->suspended ? '_' : 'confirm')=>Yii::t('mc', 'This will shut down the server and remove control from normal users until the server is resumed.'),
        ),
    ),
    array(
        'label'=>Yii::t('mc', 'Delete Server'),
        'url'=>array('delete', 'id'=>$model->id),
        'visible'=>$delete,
        'icon'=>'delete'
    ),
    array(
        'label'=>Yii::t('mc', 'Help'),
        'url'=>'#',
        'icon'=>'help',
        'linkOptions'=>array(
            'submit'=>'http://multicraft.org/site/docs?view=settings#server_settings',
            'target'=>'_blank',
            'confirm'=>Yii::t('mc', "You are leaving your control panel.\n\nYou will be forwarded to the documentation on the official Multicraft website.")),
    ),
);
}
else
    $this->menu = array(array('label'=>Yii::t('mc', 'Back'), 'url'=>array('index'), 'icon'=>'back'));
?>

<?php if (Yii::app()->user->isStaff()): ?>
    <div id="movestatus-ajax">
        <?php echo @$data['movestatus'] ?>
    </div>
<?php endif ?>

<?php 
    $statusIcon = Yii::t('mc', 'Server Settings');
    $statusButtons = '';
    if (isset($data)):
    ob_start(); ?>
    <div style="float: left; width: 30px; margin-top: 3px"><img id="statusicon-ajax" src="<?php echo @$data['statusicon'] ?>" alt=""/>
    </div>
    <?php
    $statusIcon = ob_get_clean();
    ob_start();
    ?>
    <div id="buttons">
<?php $this->renderPartial('_buttons', array('model'=>$model, 'data'=>$data)) ?>
    </div>
    <div id="buttons-ajax" style="display: none">
        <?php echo @$data['buttons'] ?>
    </div>
<?php
    $statusButtons = ob_get_clean(); 
    endif ?>

<?php
if (@$my)
{
    $url = CHtml::normalizeUrl(array('view', 'id'=>'__SERVER_ID__'));
    echo CHtml::script('
        function changeServer()
        {
            window.location.href="'.str_replace('__SERVER_ID__', '" + $("#my_servers").val() + "', $url).'";
        }
    ');
    echo '<div>'.CHtml::dropDownList('my_servers', $model->id, $my, array('onchange'=>'changeServer()')).'</div><br/>';
}
?>

<?php 

$statusBanner = '';
if (!!Yii::app()->params['status_banner'] && !$model->isNewRecord)
{
    $statusBanner = '<span id="status_banner">'
        .CHtml::link(CHtml::encode(Yii::t('mc', 'Banner')), array('status/'.$model->id.'.png'), array('target'=>'_blank'))
        .'</span>';
}

$statusDetail = false;
if (@$data['statusdetail'])
    $statusDetail = array('label'=>Yii::t('mc', 'Status'), 'type'=>'raw', 'value'=>'<span id="statusdetail-ajax">'.CHtml::encode($data['statusdetail']).'</span>'.$statusBanner.'</nobr>');

$ip = trim(($settings && $settings->display_ip) ? $settings->display_ip : $model->ip);
if (!strlen($ip) || $ip == '0.0.0.0')
{
    if ($dmn = Daemon::model()->findByPk($model->daemon_id))
        $ip = $dmn->ip;
}
$attribs = array();
$attribs[] = array('label'=>$statusIcon, 'type'=>'raw', 'value'=>$statusButtons, 'cssClass'=>'titlerow', 'template'=>"<tr class=\"{class}\"><th>{label}</th><td colspan=\"2\">{value}</td></tr>\n");
$domainHint = Yii::t('mc', 'You can directly connect to this address without indicating a port.');
if (!$edit)
{
    if ($ip && $ip != '0.0.0.0')
        $attribs[] = array('label'=>CHtml::activeLabel($model, 'ip'), 'type'=>'raw', 'value'=>'<nobr>'.CHtml::encode($ip).'</nobr>');

    if(@Yii::app()->params['user_subdomains'] && $model->domain)
        $attribs[] = array('name'=>'domain', 'value'=>$model->domain.'.'.$domain, 'hint'=>$domainHint);
    $attribs[] =  'port';
    if ($statusDetail)
        $attribs[] = $statusDetail;
}
else
{
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

    $conIds = McBridge::get()->getDaemonIds();
    $conCount = count($conIds);
    if (($conCount > 1 || ($conCount == 1 && $model->daemon_id != $conIds[0])) && Yii::app()->user->isStaff())
    {
        $opt = array();
        
        $attribs[] = array('label'=>$form->labelEx($model,'daemon_id'), 'type'=>'raw',
            'value'=>$form->dropDownList($model, 'daemon_id', McBridge::get()->conStrings(), $opt)
                .' '.$form->error($model,'daemon_id'),
            'hint'=>Yii::t('mc', 'Changing this will shut the server down if running'));
        echo CHtml::hiddenField('move_files', '');
    }
    else if ($model->isNewRecord && $conCount == 1)
    {
        $model->daemon_id = $conIds[0];
        echo $form->hiddenField($model, 'daemon_id');
    }
    else if (Yii::app()->params['show_daemon'])
    {
        $daemon = Daemon::model()->findByPk((int)$model->daemon_id);
        if ($daemon)
            $attribs[] = array('label'=>$form->labelEx($model,'daemon_id'), 'value'=>$daemon->name);
    }
    if (Yii::app()->user->isStaff() || $settings->user_name)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'name'), 'type'=>'raw',
            'value'=>$form->textField($model,'name').' '.$form->error($model,'name'));
    }
    else
        $attribs[] = 'name';
    if (Yii::app()->user->isStaff() || $settings->user_players)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'players'), 'type'=>'raw',
            'value'=>$form->textField($model,'players').' '.$form->error($model,'players'));
    }
    else
        $attribs[] = 'players';
    if ($statusDetail)
        $attribs[] = $statusDetail;
    if (Yii::app()->user->isStaff())
    {
        $owner = User::model()->findByPk($model->owner);
        $assign = $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'name'=>'owner-name',
            'source'=>$this->createUrl('user/autocomplete'),
            'value'=>@$_POST['owner-name'] ? $_POST['owner-name'] : ($owner ? $owner->name : ''),
            'options'=>array(
                'minLength'=>2,
            ),
        ), true);
        $assign .= $form->error($model, 'owner');
        $attribs[] = array('label'=>Yii::t('mc', 'Assign to user'), 'type'=>'raw',
            'value'=>$assign,
            'hint'=>($model->isNewRecord ? '' :
                    Yii::t('mc', 'Remove role and FTP access of old owner manually')));
        if (Yii::app()->params['mail_assign'])
        {
            $attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'Send Assign Notification'), 'Server_sendData'), 'type'=>'raw',
                'value'=>$form->checkBox($model, 'sendData'));
        }
        $attribs[] = array('label'=>$form->labelEx($model,'ip'), 'type'=>'raw',
            'value'=>$form->textField($model,'ip')
                .' '.$form->error($model,'ip'),
            'hint'=>Yii::t('mc', 'Empty for default value'));
        $attribs[] = array('label'=>$form->labelEx($model,'port'), 'type'=>'raw',
            'value'=>$form->textField($model,'port')
                .' '.$form->error($model,'port'),
            'hint'=>Yii::t('mc', 'Empty to select automatically'));
        $attribs[] = array('label'=>$form->labelEx($model,'memory'), 'type'=>'raw',
            'value'=>$form->textField($model,'memory')
                .' '.$form->error($model,'memory'),
            'hint'=>Yii::t('mc', 'In MB. Empty for default amount'));
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
    }
    else
    {
        if ($ip && $ip != '0.0.0.0')
            $attribs[] = array('label'=>CHtml::activeLabel($model, 'ip'), 'value'=>$ip);
        $attribs[] = 'port';
        if (@Yii::app()->params['additional_ports'])
            $attribs[] = 'addPorts';
        $attribs[] = array('label'=>$form->labelEx($model,'world'), 'type'=>'raw',
            'value'=>$form->textField($model,'world').' '.$form->error($model,'world'),
            'hint'=>Yii::t('mc', 'Leave empty for "world"'));
    }
    if(@Yii::app()->params['user_subdomains'] && !$model->isNewRecord)
    {
        if (Yii::app()->user->isStaff() || $settings->user_subdomain)
        {
            if (count($model->domains()) > 1)
            {
                $domainSelection = CHtml::dropDownList('subdomain_domain', $domain,
                    array_combine($model->domains(), $model->domains()), array('style'=>'width: auto'));
            }
            else
            {
                $domainSelection = '<span class="subdomain_domain">'.CHtml::encode(Yii::app()->params['user_subdomains_domain'])
                    .'</span>';
            }
            $attribs[] = array('label'=>$form->labelEx($model, 'domain'), 'type'=>'raw',
                'value'=>$form->textField($model, 'domain', array('class'=>'form-control subdomain_input'))
                    .'<span class="subdomain_domain">.</span>'.$domainSelection
                    .'<div class="clearfix"></div>'.$form->error($model, 'domain'),
                'hint'=>$domainHint,
            );
        }
        else if($model->domain)
            $attribs[] = array('name'=>'domain', 'value'=>$model->domain.'.'.$domain, 'hint'=>$domainHint);
    }
    $jarOptions = array();
    if (is_array($jars))
    {
        $categories = array();
        foreach ($jars as $jar)
        {
            $category = @$jar['category'];
            if (!$category)
            {
                $jarOptions[$jar['jar']] = $jar['name'];
                continue;
            }
            if (!isset($categories[$category]))
                $categories[$category] = array();
            $categories[$category][$jar['jar']] = $jar['name'];
        }
        function natcasekey($a, $b) { return strnatcasecmp($a, $b); }
        uksort($categories, 'natcasekey');
        natcasesort($jarOptions);
        foreach ($categories as $name=>$list)
        {
            natcasesort($list);
            $jarOptions[$name] = $list;
        }
    }

    function JarDropDownList($model, $jars, $jarOptions)
    {
        $icon = @$jars[$model->jarfile]['icon'] ? $jars[$model->jarfile]['icon'] : 'cube';
        $image = CHtml::image(Theme::themeFile('images/icons/'.$icon.'.png'));
        $name = CHtml::encode(@$jars[$model->jarfile]['name']);

        $value = '<div id="jarDropDown">';
        $value .= '<button onclick="return toggleJarDropDown()" class="btn btn-default form-control" id="jarDropDownButton">'.$image.'&nbsp'.$name.'</button>';
        $value .= '<div id="jarDropDownContent">';
        $value .= CHtml::textField('', '', array('onkeyup'=>'filterJarDropDown(event);', 'id'=>'jarDropDownFilter', 'placeholder'=>'Search...', 'autocomplete'=>'off'));
        $value .= '<div id="jarDropDownContentScroll">';

        foreach ($jarOptions as $jar=>$jarName)
        {
            if (is_array($jarName))
            {
                $subJars = $jarName;
                $value .= '<span>'.$jar.'</span>';
            }
            else
                $subJars = array($jar=>$jarName);
            foreach ($subJars as $jar=>$jarName)
            {
                $icon = @$jars[$jar]['icon'] ? $jars[$jar]['icon'] : 'cube';
                $image = CHtml::image(Theme::themeFile('images/icons/'.$icon.'.png'));
                $name = CHtml::encode($jarName);
                $value .= CHtml::link($image.'&nbsp'.$name, '#', array('onclick'=>'return selectJar(this)', 'data-jar'=>$jar));
            }
        }

        $value .= '</div></div></div>';

        echo CHtml::hiddenField('jar-select', '');
        echo CHtml::hiddenField('goto_setup', '');
        return $value;
    }

    if (Yii::app()->user->isStaff() || ($settings->user_jar && in_array($model->jardir, array('server', 'server_base'))))
    {
        $value = '';
        if ($jars)
            $value .= JarDropDownList($model, $jars, $jarOptions);
        $value .= $form->textField($model,'jarfile').' '.$form->error($model,'jarfile');
        $attribs[] = array('label'=>$form->labelEx($model,'jarfile'), 'type'=>'raw',
            'value'=>$value,
            'hint'=>Yii::t('mc', 'Empty for default file.')
                .($model->isNewRecord ? ' '.Yii::t('mc', 'A selection will be shown as soon as the server has been created') : ''));
    }
    else if ($jars && $settings->user_jar)
    {
        $attribs[] = array('label'=>Yii::t('mc', 'Server JAR'), 'type'=>'raw',
            'value'=>JarDropDownList($model, $jars, $jarOptions));
    }
    echo CHtml::hiddenField('confirm_leave', 'true');
    if (Yii::app()->user->isStaff())
    {
        $attribs[] = array('label'=>$form->labelEx($settings,'user_jar'), 'type'=>'raw',
            'value'=>$form->checkBox($settings,'user_jar')
                .' '.$form->error($settings,'user_jar'));
        $attribs[] = array('label'=>$form->labelEx($settings,'user_name'), 'type'=>'raw',
            'value'=>$form->checkBox($settings,'user_name')
                .' '.$form->error($settings,'user_name'));
    }
    if (!($minecraftEula = Setting::model()->findByPk('minecraftEula'))
        || in_array($minecraftEula->value, array('', 'button')))
    {
        $attribs[] = array('label'=>Yii::t('mc', 'Minecraft EULA'), 'type'=>'raw',
            'visible'=>!$model->isNewRecord,
            'value'=>CHtml::ajaxButton(Yii::t('mc', 'Accept EULA'), '', array(
                'type'=>'POST',
                'data'=>array('ajax'=>'accept_eula', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,),
                'success'=>'function(e) {if (e) alert(e);}'),
                array('class'=>'btn btn-default btn-block')),
            'hint'=>Yii::t('mc', 'Use this button if you agree to the Minecraft EULA'));
    }
    $attribs[] = array('label'=>Theme::icon('closed', array('id'=>'advImg')).Theme::icon('open', array('class'=>'adv')), 'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode(Yii::t('mc', 'Show Advanced Settings')), '#', array('id'=>'advTxt', 'onclick'=>'return checkAdv()')));
    if (Yii::app()->user->isStaff())
    {
        $attribs[] = array('label'=>$form->labelEx($model,'world'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->textField($model,'world').' '.$form->error($model,'world'),
            'hint'=>Yii::t('mc', 'Leave empty for "world"'));
        $attribs[] = array('label'=>$form->labelEx($settings,'display_ip'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->textField($settings,'display_ip')
                .' '.$form->error($settings,'display_ip'),
            'hint'=>Yii::t('mc', 'Displayed on banner and in server view. Empty for same as IP'));
        $attribs[] = array('label'=>$form->labelEx($model,'dir'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->textField($model,'dir')
                .' '.$form->error($model,'dir'),
            'hint'=>Yii::t('mc', 'Contains all files for this server'));
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
        if (@Yii::app()->params['user_subdomains'])
        {
            $attribs[] = array('label'=>$form->labelEx($settings,'user_subdomain'), 'type'=>'raw', 'cssClass'=>'adv',
                'value'=>$form->checkBox($settings,'user_subdomain')
                    .' '.$form->error($settings,'user_subdomain'));
        }
        if (@Yii::app()->params['user_mysql'])
        {
            $attribs[] = array('label'=>$form->labelEx($settings,'user_mysql'), 'type'=>'raw', 'cssClass'=>'adv',
                'value'=>$form->checkBox($settings,'user_mysql')
                    .' '.$form->error($settings,'user_mysql'));
        }
        if (@Yii::app()->params['additional_ports'] && isset($settings->user_add_ports))
        {
            $attribs[] = array('label'=>$form->labelEx($settings,'user_add_ports'), 'type'=>'raw', 'cssClass'=>'adv',
                'value'=>$form->checkBox($settings,'user_add_ports')
                    .' '.$form->error($settings,'user_add_ports'));
        }
    }
    else if ($settings->user_memory)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'memory'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->textField($model,'memory')
                .' '.$form->error($model,'memory'),
            'hint'=>Yii::t('mc', 'In MB. Empty for default amount'));
    }
    else if (Yii::app()->params['show_memory'])
        $attribs[] = array('label'=>$form->labelEx($model,'memory'), 'value'=>$model->memory.' '.Yii::t('mc', 'MB'),
            'cssClass'=>'adv');
    if (Yii::app()->user->isStaff() || $settings->user_jardir)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'jardir'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->dropDownList($model,'jardir',Server::getJardirs())
                .' '.$form->error($model,'jardir'),
            'hint'=>Yii::t('mc', '(* Warning: Be sure to run Multicraft in "multiuser" mode with this!)'));
    }
    $attribs[] = array('label'=>$form->labelEx($model,'kick_delay'), 'type'=>'raw', 'cssClass'=>'adv',
        'value'=>$form->textField($model,'kick_delay')
            .' '.$form->error($model,'kick_delay'),
        'hint'=>Yii::t('mc', 'After how many milliseconds to kick players without access'));
    if (Yii::app()->user->isStaff() || $settings->user_schedule)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'autosave'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->checkBox($model,'autosave')
            .' '.$form->error($model,'autosave'),
            'hint'=>Yii::t('mc', 'Regularly save the world to the disk'));
    }
    $attribs[] = array('label'=>$form->labelEx($model,'announce_save'), 'type'=>'raw', 'cssClass'=>'adv',
        'value'=>$form->checkBox($model,'announce_save')
            .' '.$form->error($model,'announce_save'),
        'hint'=>Yii::t('mc', 'Inform the players when the world has been saved'));
    if (Yii::app()->user->isStaff() || $settings->user_crash_check)
    {
        $attribs[] = array('label'=>$form->labelEx($model, 'crash_check'), 'type'=>'raw', 'cssClass'=>'adv',
            'value'=>$form->dropDownList($model, 'crash_check', Server::getCrashCheckModes())
            .' '.$form->error($model, 'crash_check'),
            'hint'=>Yii::t('mc', '"Strict" requires specific command output configured by the hosting provider, for "Basic" any console ouput is sufficient'));
    }
    $rt = Yii::app()->params['show_repairtool'];
    if ($rt && $rt != 'none' && (Yii::app()->user->isStaff() || ($edit && $rt == 'user')))
    {
        $attribs[] = array('label'=>Yii::t('mc', 'Repair Tool'), 'type'=>'raw', 'cssClass'=>'adv',
            'visible'=>!$model->isNewRecord,
            'value'=>CHtml::ajaxButton(Yii::t('mc', 'Run Repair Tool'), '', array(
                    'type'=>'POST', 'data'=>array('ajax'=>'run_repairtool', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,),
                    'success'=>'function(e) {if (e) alert(e);}'
                ),
                array(
                    'confirm'=>Yii::t('mc', 'This tool will only run when your server has been fully stopped first. Use it at your own risk.'),
                    'class'=>'btn btn-default btn-block',
                )
            ),
            'hint'=>Yii::t('mc', 'This is a tool that can fix corrupted worlds. Use it at your own risk and create a backup first.'));
    }
    $attribs[] = array('label'=>Theme::icon('closed', array('id'=>'permImg')).Theme::icon('open', array('class'=>'perm')), 'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode(Yii::t('mc', 'Show Permissions')), '#', array('id'=>'permTxt', 'onclick'=>'return checkPerm()')));

    if (Yii::app()->user->isStaff() || $settings->user_visibility)
    {
        $attribs[] = array('label'=>$form->labelEx($settings,'visible'), 'type'=>'raw', 'cssClass'=>'perm',
            'value'=>$form->dropDownList($settings,'visible',ServerConfig::getVisibility())
                .' '.$form->error($settings,'visible'),
            'hint'=>Yii::t('mc', 'Visibility in the Multicraft server list'));
        $attribs[] = array('label'=>$form->labelEx($model,'default_level'), 'type'=>'raw', 'cssClass'=>'perm',
            'value'=>$form->dropDownList($model,'default_level',$defaultRoles)
                .' '.$form->error($model,'default_level'),
            'hint'=>Yii::t('mc', 'Role assigned to players on first connect ("No Access" for whitelisting)'));
    }
    if (Yii::app()->params['ip_auth'])
    {
        $attribs[] = array('label'=>$form->labelEx($settings,'ip_auth_role'), 'type'=>'raw', 'cssClass'=>'perm',
            'value'=>$form->dropDownList($settings,'ip_auth_role', $ipRoles)
                .' '.$form->error($settings,'ip_auth_role'),
            'hint'=>Yii::t('mc', 'For users whose IP matches a player ingame'));
    }
    $attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'Cheat Role'),'cheat_role'), 'type'=>'raw', 'cssClass'=>'perm',
        'value'=>CHtml::dropDownList('cheat_role', $settings->give_role, $allRoles),
        'hint'=>Yii::t('mc', 'Role required to use web based give/teleport'));

    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton($model->isNewRecord ? Yii::t('mc', 'Create') : Yii::t('mc', 'Save'), array('id'=>'saveButton')));

?>
<br/>

<?php
}

?>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
));

if ($edit)
    $this->endWidget();

?>

<?php if(Yii::app()->user->hasFlash('server')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('server'); ?>
</div>
<?php endif;

$set = Setting::model()->findByPk('resourceCheckInterval');
if (!$set || $set->value > 0): ?>
    <div id="resources-ajax">
    <?php
    if (isset($data['resources']))
        echo $data['resources'];
    ?>
    </div>
<?php endif ?>

<?php if (!$model->isNewRecord): ?>
<br/>

<?php if ($getPlayers): ?>
<table style="width: 100%" class="stdtable">
<tr class="titlerow"> 
    <td><?php echo Yii::t('mc', 'Connected players') ?></td>
</tr>
<tr class="linerow">
    <td></td>
</tr>
<tr>
    <td>
        <!-- PLAYERS -->
        <div id="players-ajax">
        <?php echo @$data['players'] ?>
        </div>
    </td>
</tr>
</table>
<?php endif ?>

<?php
    echo CHtml::script('
        function buttonChange() {
            dis = $("#buttons-ajax").html();
            for (i = 0; i < 4; i++) {
                if (dis[i] != "1")
                    $("input[name=yt" + i + "]").removeAttr("disabled");
                else
                    $("input[name=yt" + i + "]").attr("disabled", "disabled");
            }
        }
    ');
    $this->printRefreshScript('buttonChange'); ?>

<?php endif ?>

<?php
if ($settings->user_jar || Yii::app()->user->isStaff())
{
    $jarTpl = array();
    if (is_array($jars))
    {
        foreach ($jars as $j)
            if (@$j['template'])
                $jarTpl[$j['jar']] = $j['template'];
    }
    echo CHtml::script('
        var jarTpl = '.CJSON::encode($jarTpl).';
        $("#jar-select").change(function() {
            var jar = $("#jar-select").val();
            $("#Server_jarfile").val(jar);
            $("#goto_setup").val("");

            var save = false, ask = false;
            if (jarTpl[jar] && confirm("'.CJavaScript::quote(Yii::t('mc', 'This server needs additional files to run correctly. Your changes will now be saved and you will be forwarded to the "Setup" section to configure your server installation.

Press "Cancel" to stay on this page.')).'")) {
                $("#goto_setup").val(jarTpl[jar]);
                save = true;
            }
            '.(Yii::app()->params['auto_jar_submit'] == 'yes' ? 'save = true;' : '').'
            '.(Yii::app()->params['auto_jar_submit'] == 'confirm' ? 'ask = true;' : '').'
            if (save && (!ask || confirm("'.Yii::t('mc', 'Save changes and reload page?\nYou can press cancel and manually save the changes using the button below.').'"))) {
                $("#confirm_leave").val("false");
                $("#server-form").submit();
            }
        });
    ');
}
if (!$model->isNewRecord && Yii::app()->user->isStaff())
{
    echo CHtml::script('
$("#server-form").submit(function() {
    var initDid = '.$model->daemon_id.';
    var dmnSel = $("#Server_daemon_id") ? $("#Server_daemon_id").children("option:selected").val() : null;
    if (dmnSel && dmnSel != initDid) {
        var move = confirm("'.CJavaScript::quote(Yii::t('mc', 'Press OK to move the server and all server files to the new daemon. This process can take a lot of time depending on the total number and size of all server files.

The daemon dropdown will revert back to the previous one until the transfer is complete.

Pressing cancel will only change the daemon ID setting without moving any files.')).'");
        if (move) {
            $("#move_files").val(dmnSel);
            $("#Server_daemon_id").val(initDid);
        }
    }
    return true;
});
    ');
}
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
