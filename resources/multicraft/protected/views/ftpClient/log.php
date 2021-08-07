<?php
/**
 *
 *   Copyright © 2010-2016 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('mc', 'Minecraft FTP Client').' - '.Yii::t('mc', 'Log');

$this->breadcrumbs=array(
    $server->name=>array('/server/view', 'id'=>$server->id),
    Yii::t('mc', 'FTP Client')=>array('index', 'id'=>$server->id),
    Yii::t('mc', 'Browse')=>array('browse', 'id'=>$server->id),
    Yii::t('mc', 'Log'),
);

$this->menu = array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('browse', 'id'=>$server->id),
        'icon'=>'back',
    )
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

echo $body;
?>

<div id="log_bottomup" style="display: none"><?php echo Yii::app()->params['log_bottomup'] === true ? 'true' : '' ?></div>
<div id="log-ajax" class="logArea"><?php echo CHtml::encode(''.@$data['log']) ?></div>
<br/>
<br/>
<?php echo $this->printRefreshScript(false, ''.@$data['log_seq']) ?>
<script src="<?php echo Theme::js('console.js') ?>"></script>
