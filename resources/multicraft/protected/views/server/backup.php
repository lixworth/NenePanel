<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Backup');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('mc', 'Backup'),
);

$this->menu=array(
    array(
        'label'=>@Yii::app()->params['backup_full'] ? Yii::t('mc', 'Restore World') : Yii::t('mc', 'Restore'),
        'url'=>array('server/restore', 'id'=>$model->id),
        'icon'=>'restore',
        'visible'=>$restore && !@Yii::app()->params['backup_world_disable'],
    ),
    array(
        'label'=>@Yii::app()->params['backup_world_disable'] ? Yii::t('mc', 'Restore') : Yii::t('mc', 'Restore Full'),
        'url'=>array('server/restoreFull', 'id'=>$model->id),
        'icon'=>'restore',
        'visible'=>$restore && @Yii::app()->params['backup_full'],
    ),
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$model->id),
        'icon'=>'back',
    ),
);
?>

<?php
$world = !@Yii::app()->params['backup_world_disable'];
$full = @Yii::app()->params['backup_full'];

if (Yii::app()->user->can($model->id, 'start_backup'))
{
    if ($world)
    {
        echo CHtml::ajaxButton(!$full ? Yii::t('mc', 'Start') : Yii::t('mc', 'Start World Backup'), '', array(
            'type'=>'POST', 'data'=>array('ajax'=>'start', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,),
            'success'=>'backup_response'
        ), array());
    }
    if ($full)
    {
        echo CHtml::ajaxButton(Yii::t('mc', 'Start Full Backup'), '', array(
            'type'=>'POST', 'data'=>array('ajax'=>'start_full', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,),
            'success'=>'backup_response'
        ), array());
    }
}
?>
<br/>
<br/>

<div id="backup-ajax"><?php echo @$data['backup'] ?></div>

<?php $this->printRefreshScript(); ?>
<?php echo CHtml::script('
    function backup_response(data)
    {
        if (data)
            alert(data);
        setTimeout(function() { refresh("backup"); }, 500);
    }
'); ?>
