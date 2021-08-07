<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('mc', 'About');
$this->breadcrumbs=array(
    Yii::t('mc', 'About'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('', 'view'=>'home'),
        'icon'=>'back',
    ),
);
?>
<center>
    <h2><?php echo Yii::t('mc', 'About Multicraft') ?></h2>
   <div class="muted"> <?php echo 'Copyright &copy; 2010-2021 by '.CHtml::link('xhost.ch GmbH', 'http://www.xhost.ch/').'. All Rights Reserved.'; ?></div>
    <?php echo Theme::img('about/swissmade.png') ?>
</center>

<br/>
<?php echo Yii::t('mc', 'Multicraft uses the following technologies:') ?><br/>
<div id="about">
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/python.png'), 'http://www.python.org', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Theme::img('about/pyftpdlib.png'), 'https://github.com/giampaolo/pyftpdlib', array('class' => 'col-md-6', 'target'=>'_blank')) ?>
    </div>
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/psutil.png'), 'https://github.com/giampaolo/psutil', array('class' => 'col-md-6', 'target'=>'_blank')) ?>
        <?php echo CHtml::link(Theme::img('about/php.png'), 'http://www.php.net', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/yii.png'), 'http://www.yiiframework.com', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Theme::img('about/net2ftp.png'), 'http://www.net2ftp.com/', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/lesscss.png'), 'http://www.lesscss.org/', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Theme::img('about/gulp.png'), 'http://www.gulpjs.com/', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/nodejs.png'), 'http://www.nodejs.org/', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
        <?php echo CHtml::link(Theme::img('about/bootstrap.png'), 'http://www.getbootstrap.com/', array('class' => 'col-md-6', 'target'=>'_blank')); ?>
    </div>
    <div class="row">
        <?php echo CHtml::link(Theme::img('about/multicraft.png'), 'http://www.multicraft.org/', array('class' => 'col-md-12', 'target'=>'_blank')); ?>
    </div>
</div>
