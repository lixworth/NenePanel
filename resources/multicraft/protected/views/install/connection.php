<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('mc', 'Daemon Connection');

?>
<h2>Daemon configuration</h2>
You can now configure and start your Multicraft daemon. Please verify these settings in your <b>multicraft.conf</b>:
<br/>
<pre><?php
if ($p['daemon_db_driver'] == 'sqlite' && function_exists('posix_geteuid') && function_exists('posix_getpwuid'))
{
    $uid = posix_geteuid();
    $info = posix_getpwuid($uid);
    $name = @$info['name'];
    if (!@strlen($name))
        $name = $uid;
    if (!$name)
        $name = 'www-data';
    echo 'webUser = '.$name."\n";
}
else
{
    echo "#webUser = \n";
}

echo 'password = '.$p['config']['daemon_password']."\n";
echo 'database = '.$p['config']['daemon_db']."\n";
if ($p['daemon_db_driver'] == 'mysql')
{
    echo 'dbUser = '.$p['config']['daemon_db_user']."\n";
    echo 'dbPassword = '.$p['config']['daemon_db_pass']."\n";
}
?></pre>
The default <b>start</b> command for Linux is:
<pre>/home/minecraft/multicraft/bin/multicraft start</pre>
For Windows running the multicraft.exe is sufficient.<br/>
<br/>
<br/>
<h2>Detected Daemons</h2>
<?php if ($this->p['daemons']): ?>
<div class="row">
<div class="col-md-8">
One or more daemons have been detected. If you see at least one entry below you can complete the installation.
</div>
<div class="col-md-4">
<?php echo CHtml::beginForm(array('index', 'step'=>'done')) ?>
<?php echo CHtml::submitButton('Continue') ?>
<?php echo CHtml::endForm() ?>
</div>
</div>
<?php else: ?>
<div class="row">
<div class="col-md-8">
No daemon has been detected in the database. Make sure that your daemon is using the correct database and that it starts up correctly (you can add the -n switch to the start command to debug startup issues).<br/>
<br/>
As soon as you see at least one entry below you can complete the installation.
</div>
<div class="col-md-4">
<?php echo CHtml::beginForm(array('index', 'step'=>'connection')) ?>
<?php echo CHtml::submitButton('Refresh') ?>
<?php echo CHtml::endForm() ?>
</div>
</div>
<?php endif ?>
<br/>
Otherwise please refer to the <?php echo CHtml::link('Troubleshooting Guide', 'http://www.multicraft.org/site/page?view=troubleshooting') ?>.
<?php 
$title = $this->pageTitle;
$menu = $this->menu;
$breadcrumbs = $this->breadcrumbs;

$model = new Daemon('search');
$model->dbCriteria->order = 'id ASC';
$model->unsetAttributes();
if(isset($_GET['Daemon']))
    $model->attributes=$_GET['Daemon'];

$this->renderPartial('_daemonStatus',array(
    'model'=>$model,
));

$this->pageTitle = $title;
$this->menu = $menu;
$this->breadcrumbs = $breadcrumbs;

?>

