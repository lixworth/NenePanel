<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('admin', 'Panel Configuration');
$this->breadcrumbs=array(
    Yii::t('admin', 'Settings')=>array('index'),
    Yii::t('admin', 'Panel Configuration'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Help'),
        'url'=>'#',
        'icon'=>'help',
        'linkOptions'=>array(
            'submit'=>'http://multicraft.org/site/docs?view=settings#panel_config',
            'target'=>'_blank',
            'confirm'=>Yii::t('mc', "You are leaving your control panel.\n\nYou will be forwarded to the documentation on the official Multicraft website.")),
    ),
    array(
        'label'=>Yii::t('admin', 'Back'),
        'url'=>array('daemon/index'),
        'icon'=>'back',
    ),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

echo CHtml::css('.adv { display: none; }');
echo CHtml::beginForm();
echo CHtml::hiddenField('submit_settings', 'true');

if(Yii::app()->user->hasFlash('panel_config')): ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('panel_config'); ?>
</div>
<?php endif;

$attr = array();

function set_t($p, $id, $desc, $hint = '', $advanced = false, $list = false)
{
    $val = '';
    if (!$list)
        $val = CHtml::textField('settings['.$id.']', @$p['config'][$id]);
    else
        $val = CHtml::dropDownList('settings['.$id.']', @$p['config'][$id], $list);
    return array('label'=>$desc, 'type'=>'raw', 'value'=>$val,
        'hint'=>$hint, 'cssClass'=>(!$advanced ? '' : (is_string($advanced) ? $advanced : 'adv')));
}
function set_s($p, $id, $desc, $hint = '', $advanced = false)
{
    return array('label'=>$desc, 'type'=>'raw', 'value'=>CHtml::dropDownList('settings['.$id.']',
            @$p['config'][$id] ? 'sel_true' : 'sel_false', array('sel_true'=>Yii::t('admin', 'Yes'), 'sel_false'=>Yii::t('admin', 'No'))),
        'hint'=>$hint, 'cssClass'=>(!$advanced ? '' : (is_string($advanced) ? $advanced : 'adv')));
}

$attr[] = set_t($p, 'admin_name', Yii::t('admin', 'Administrator Name'), '');
$attr[] = set_t($p, 'admin_email', Yii::t('admin', 'Administrator contact Email'), Yii::t('admin', 'empty to hide the "Support" menu entry'));
$attr[] = set_t($p, 'support_url', Yii::t('admin', 'Support URL'), Yii::t('admin', 'empty to show a contact form that sends a message to the Administrator contact Email'));
$attr[] = set_t($p, 'admin_ips', Yii::t('admin', 'Restrict Administrator IPs'), Yii::t('admin', 'Only allow these IPs to login as a superuser, empty for no restriction. This will also restrict superuser access through the API.'));
$attr[] = set_t($p, 'staff_ips', Yii::t('admin', 'Restrict Staff IPs'), Yii::t('admin', 'Only allow these IPs to login as a Staff, empty for no restriction.'));
$attr[] = set_t($p, 'api_ips', Yii::t('admin', 'Restrict API IPs'), Yii::t('admin', 'Only allow these IPs to use the API, empty for no restriction.'));
$attr[] = set_s($p, 'api_enabled', Yii::t('admin', 'Enable the Multicraft API'));
$attr[] = set_s($p, 'enable_gauth', Yii::t('admin', 'Allow users to enable Google Authenticator'), '', 'gauth_main');
$attr[] = set_t($p, 'gauth_domain', Yii::t('admin', 'Override Google Authenticator Domain ({domain})', array('{domain}'=>$_SERVER['SERVER_NAME'])), '', 'gauth');
$attr[] = set_s($p, 'gauth_single_login', Yii::t('admin', 'Only allow one active login session at a time'), '', 'gauth');
$attr[] = set_s($p, 'user_api_keys', Yii::t('admin', 'Allow users to generate API keys'), Yii::t('admin', 'Allows users to generate their own API key for use in apps. Disabling user registration is recommended.'));
$attr[] = set_s($p, 'hide_userlist', Yii::t('admin', 'Hide the userlist from normal users'));
$attr[] = set_s($p, 'editable_roles', Yii::t('admin', 'Editable user roles'));
$attr[] = set_t($p, 'min_pw_length', Yii::t('admin', 'Minimum password length'));
$attr[] = set_t($p, 'theme', Yii::t('admin', 'Theme'), '', false, Controller::themeSelection());
$attr[] = set_t($p, 'mobile_theme', Yii::t('admin', 'Mobile Theme'), '', false, Controller::mobileThemeSelection());
$attr[] = set_s($p, 'user_theme', Yii::t('admin', 'User can select theme'), '', false);
$attr[] = set_t($p, 'language', Yii::t('admin','Language'), '', false, Controller::languageSelection());
$attr[] = set_s($p, 'status_banner', Yii::t('admin', 'Generate server status banners (requires GD)'), '');
$attr[] = set_s($p, 'mail_welcome', Yii::t('admin', 'Welcome Mail'), Yii::t('admin', 'Send a welcome email when a new user is created'));
$attr[] = set_s($p, 'mail_assign', Yii::t('admin', 'Assign Mail'), Yii::t('admin', 'Send a notification email when a server is assigned to a user'));
$attr[] = set_t($p, 'default_displayed_ip', Yii::t('admin', 'Default Display IP'), Yii::t('admin', 'Used when a new server is created'), false, array(''=>Yii::t('admin', 'Empty (same as IP)'), 'daemon'=>Yii::t('admin', 'Daemon IP'), 'daemon_ftp'=>Yii::t('admin', 'Daemon FTP Server IP')));
$attr[] = set_s($p, 'fill_port_gaps', Yii::t('admin', 'Use lowest possible unused port'), Yii::t('admin', 'If enabled the lowest possible unused port will be used for new servers. When disabled the old behavior will be used (highest used port +1)'));
$attr[] = set_s($p, 'show_memory', Yii::t('admin', 'Show Server Memory'), Yii::t('admin', 'Display server memory to users in the advanced section'));
$attr[] = set_s($p, 'show_daemon', Yii::t('admin', 'Show Server Daemon Name'), Yii::t('admin', 'Display the name of the daemon a server is on to users'));
$attr[] = set_s($p, 'log_bottomup', Yii::t('admin', 'Append console/chat lines at the bottom'), Yii::t('admin', 'When this is enabled the console and chat are displayed with newer messages at the bottom, otherwise newer messages are at the top'));
$attr[] = set_t($p, 'auto_jar_submit', Yii::t('admin', 'Auto-save JAR change'), Yii::t('admin', 'Automatically save server form on JAR file change'), false, array('yes'=>Yii::t('admin', 'Yes'), 'confirm'=>Yii::t('admin', 'Ask for confirmation'), ''=>Yii::t('admin', 'No')));
$attr[] = set_t($p, 'show_serverlist', Yii::t('admin', 'Show Server List For'), '', false, array('guest'=>Yii::t('admin', 'Everyone'), 'user'=>Yii::t('admin', 'Logged in Users'), 'superuser'=>Yii::t('admin', 'Superusers')));
$attr[] = set_s($p, 'use_pluginlist', Yii::t('admin', 'Use online Plugin List'), '');
$attr[] = set_s($p, 'user_mysql', Yii::t('admin', 'Allow Users to Create a MySQL Database'), '', 'mysql_main');
$attr[] = set_t($p, 'user_mysql_host', Yii::t('admin', 'User DB Host'), Yii::t('admin', 'Set to * to use the daemon IP'), 'mysql');
$attr[] = set_t($p, 'user_mysql_user', Yii::t('admin', 'User DB Username'), Yii::t('admin', 'Must have database create and grant privileges'), 'mysql');
$attr[] = set_t($p, 'user_mysql_pass', Yii::t('admin', 'User DB Password'), '', 'mysql');
$attr[] = set_t($p, 'user_mysql_prefix', Yii::t('admin', 'User DB Prefix'), Yii::t('admin', 'The user database is named prefix + server ID'), 'mysql');
$attr[] = set_t($p, 'user_mysql_admin', Yii::t('admin', 'User DB Admin Link'), Yii::t('admin', 'For example a link to phpMyAdmin. "*" will be replaced with the daemon IP'), 'mysql');
$attr[] = set_s($p, 'user_subdomains', Yii::t('admin', 'Allow Users to Create a Subdomain (CloudFlare&#174; API)'), '', 'subdomains_main');
$attr[] = set_t($p, 'user_subdomains_domain', Yii::t('admin', 'Domain for User Subdomains'), Yii::t('mc', 'The domain users will be able to create subdomains for, e.g. "example.com". Can be multiple domains separated by commas, e.g. "a.com,b.com"'), 'subdomains');
$attr[] = set_t($p, 'user_subdomains_cf_email', Yii::t('admin', 'CloudFlare Email for User Subdomains'), '', 'subdomains');
$attr[] = set_t($p, 'user_subdomains_cf_key', Yii::t('admin', 'CloudFlare API Key for User Subdomains'), '', 'subdomains');
$attr[] = set_s($p, 'user_subdomains_only_srv', Yii::t('admin', 'Only create SRV record'), Yii::t('admin', 'If enabled only SRV records will be created and server IPs need to have a reverse DNS entry. Otherwise both A and SRV records will be created with the SRV record using the A record as the target'), 'subdomains');
$attr[] = set_t($p, 'user_subdomains_invalid', Yii::t('admin', 'Regular expression matching forbidden subdomains'), '', 'subdomains');
$attr[] = array('label'=>Theme::icon('closed', array('id'=>'advImg')).Theme::icon('open', array('class'=>'adv')),
    'type'=>'raw', 'value'=>CHtml::link(CHtml::encode(Yii::t('admin', 'Show Advanced Settings')), '#',
        array('id'=>'advTxt', 'onclick'=>'return checkAdv()')));
$attr[] = set_s($p, 'ftp_client_disabled', Yii::t('admin', 'Disable the integrated FTP client (net2ftp)'), '', true);
$attr[] = set_s($p, 'ftp_client_passive', Yii::t('admin', 'Use passive mode in FTP client'), '', true);
$attr[] = set_s($p, 'ftp_client_ssl', Yii::t('admin', 'Enable SSL for FTP client'), '', true);
$attr[] = set_s($p, 'ftp_client_web_zip', Yii::t('admin', 'Use legacy FTP client zip functionality (zip on webserver)'), '', true);
$attr[] = set_s($p, 'backup_world_disable', Yii::t('admin', 'Disable world backups'), Yii::t('admin', 'The classic backup functionality'), true);
$attr[] = set_s($p, 'backup_full', Yii::t('admin', 'Enable full server backups'), Yii::t('admin', 'This requires daemon configuration'), true);
$attr[] = set_s($p, 'templates_disabled', Yii::t('admin', 'Disable template setup functionality'), '', true);
$attr[] = set_t($p, 'kill_button', Yii::t('admin', 'Show the kill button for'), Yii::t('admin', 'This forcefully ends the server, potentially resulting in corruption.'), true, array('none'=>Yii::t('admin', 'No one'), 'superuser'=>Yii::t('admin', 'Superusers'), 'user'=>Yii::t('admin', 'Users')));
$attr[] = set_t($p, 'show_repairtool', Yii::t('admin', 'Show the repair tool button for'), Yii::t('admin', 'This requires more configuration, see the How-To section on the Multicraft website.'), true, array('none'=>Yii::t('admin', 'No one'), 'superuser'=>Yii::t('admin', 'Superusers'), 'user'=>Yii::t('admin', 'Users')));
$attr[] = set_t($p, 'show_delete_all_players', Yii::t('admin', 'Show "Delete all Players" link for'), '', true, array('superuser'=>Yii::t('admin', 'Superusers'), 'none'=>Yii::t('admin', 'No one'), 'user'=>Yii::t('admin', 'Users')));
$attr[] = set_s($p, 'ajax_updates_disabled', Yii::t('admin', 'Disable AJAX updates'), Yii::t('admin', 'Reduces HTTP requests but disables console/chat/status autorefresh'), true);
$attr[] = set_t($p, 'ajax_update_interval', Yii::t('admin', 'AJAX update interval'), Yii::t('admin', 'The time between two AJAX updates (for example console refresh) in milliseconds. Minimum 250, default 2000.'), true);
$attr[] = set_s($p, 'ajax_serverlist', Yii::t('admin', 'Use AJAX in the serverlist for faster loading'), Yii::t('admin', 'This will cause a separate HTTP request for each server visible on the list'), true);
$attr[] = set_s($p, 'delay_daemon_queries', Yii::t('admin', 'Delay daemon queries (only use AJAX)'), Yii::t('admin', 'Skip querying any daemon data until after the page has fully loaded. Daemon data will be loaded in using AJAX updates'), true);
$attr[] = set_s($p, 'sqlitecache_schema', Yii::t('admin', 'Use schema cache to reduce queries'), Yii::t('admin', 'Requires the PDO SQLite extension'), true);
$attr[] = set_s($p, 'sqlitecache_commands', Yii::t('admin', 'Use separate DB for command cache'), Yii::t('admin', 'Requires the PDO SQLite extension'), true);
$attr[] = set_t($p, 'timeout', Yii::t('admin', 'Timeout for daemon connection'), Yii::t('admin', 'in seconds'), true);
$attr[] = set_t($p, 'mark_daemon_offline', Yii::t('admin', 'Mark daemon offline for'), Yii::t('admin', 'The number of seconds to mark a daemon offline for after a connection error. 0 to disable this feature.'), true);
$attr[] = set_s($p, 'register_disabled', Yii::t('admin', 'Disable User Registration'), Yii::t('admin', 'Disables the user registration functionality'), true);
$attr[] = set_t($p, 'login_tries', Yii::t('admin', 'Number of login attempts before blocking'), Yii::t('admin', '0 to disable'), true);
$attr[] = set_t($p, 'login_interval', Yii::t('admin', 'Login block interval'), Yii::t('admin', 'in seconds'), true);
$attr[] = set_t($p, 'reset_token_hours', Yii::t('admin', 'Reset Token Valid for'), Yii::t('admin', 'The reset token expires after the specified number of hours. Use 0 to disable the password reset functionality.'), true);
$attr[] = set_s($p, 'default_ignore_ip', Yii::t('admin', 'Allow IP change for login sessions by default'), Yii::t('admin', 'Allowing IP changes means that the login session will be considered valid even if a users IP changes. This is useful when logging in on mobile devices but it also means that stolen session cookies will be valid.'), true);
$attr[] = set_s($p, 'api_allow_get', Yii::t('admin', 'Allow GET requests to the API'), '', true);
$attr[] = set_s($p, 'block_chat_characters', Yii::t('admin', 'Block special characters in chat'), '', true);
$attr[] = set_s($p, 'log_console_commands', Yii::t('admin', 'Log commands with username in the panel console'), '', true);
$attr[] = set_s($p, 'enable_csrf_validation', Yii::t('admin', 'Enable CSRF validation'), '', true);
$attr[] = set_s($p, 'enable_cookie_validation', Yii::t('admin', 'Enable Cookie validation'), '', true);
$crypts = array(''=>'MD5');
if (@CRYPT_SHA256 === 1)
    $crypts += array('sha256_crypt'=>'SHA256');
if (@CRYPT_SHA512 === 1)
    $crypts += array('sha512_crypt'=>'SHA512');
$attr[] = set_t($p, 'pw_crypt', Yii::t('admin', 'Password Encryption'), Yii::t('mc', 'SHA512 is recommended if available'), true, $crypts);
$attr[] = set_t($p, 'cpu_display', Yii::t('admin', 'CPU Usage to Display'), '', true, array('core'=>Yii::t('admin', 'Usage of one core'), ''=>Yii::t('admin', 'Usage of entire CPU')));
$attr[] = set_t($p, 'ram_display', Yii::t('admin', 'RAM Usage to Display'), '', true, array(''=>Yii::t('admin', '% of assigned RAM'), 'system_percent'=>Yii::t('admin', '% of total system RAM'), 'mb'=>Yii::t('admin', 'Usage in MB'), 'mb_capped'=>Yii::t('admin', 'Usage in MB (Capped)')));
$attr[] = set_s($p, 'enable_disk_quota', Yii::t('admin', 'Enable disk space limit setting (Linux only)'), '', true);
$attr[] = set_s($p, 'enable_cpus', Yii::t('admin', 'Enable CPU limit setting (Docker only)'), '', true);
$attr[] = set_s($p, 'ip_auth', Yii::t('admin', 'Enable IP Authentication'), Yii::t('mc', 'Match player IPs to control panel visitors to assign special roles. Enables the "IP Authentication" field in the server settings.'), true);
$attr[] = set_s($p, 'support_legacy_daemons', Yii::t('admin', 'Support Legacy Daemons'), Yii::t('mc', 'If enabled the panel will allow communication with legacy (<2.0.0) daemons.'), true);
$attr[] = set_s($p, 'support_legacy_api', Yii::t('admin', 'Support Legacy API'), Yii::t('mc', 'If enabled the panel will allow connections from legacy (<2.0.0) API clients.'), true);
$attr[] = set_t($p, 'additional_ports', Yii::t('admin', 'Number of additional ports to allow'), Yii::t('admin', 'This allows users to reserve additional ports for their server and route them to their Docker container. 0 to disable.'), true);
$attr[] = set_t($p, 'additional_port_range', Yii::t('admin', 'Additional port range'), Yii::t('admin', 'Format: Min-Max, for example: 5000-10000.'), true);

$attr[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton(Yii::t('admin', 'Save')));

$this->widget('zii.widgets.CDetailView', array(
    'data'=>array(),
    'attributes'=>$attr,
)); 
echo CHtml::endForm();

?>
<br/>
<br/>
<br/>
<br/>
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

    function checkOther(obj, cls)
    {
        $(cls).toggle($(obj).val() == "sel_true");
    }

    $(function() {
        '.(@$advanced ? 'checkAdv();' : '').'

        sel = $(".mysql_main").find("select");
        sel.change(function() { checkOther(this, ".mysql"); });
        checkOther(sel, ".mysql");
        sel = $(".gauth_main").find("select");
        sel.change(function() { checkOther(this, ".gauth"); });
        checkOther(sel, ".gauth");
        sel = $(".subdomains_main").find("select");
        sel.change(function() { checkOther(this, ".subdomains"); });
        checkOther(sel, ".subdomains");

    });
');
