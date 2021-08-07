<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('mc', 'Users')=>array('index'),
    Yii::t('mc', 'Edit Roles'),
);

Yii::app()->getClientScript()->registerCoreScript('jquery');

$this->menu[] = array(
    'label'=>Yii::t('mc', 'Reset all'),
    'url'=>'#',
    'linkOptions'=>array(
        'submit'=>array('resetRole', 'role'=>'_all'),
        'confirm'=>Yii::t('mc', 'This will reset all roles to the default permissions, continue?'),
        'csrf'=>true,
    ),
    'icon'=>'user_del',
);
$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>array('user/index'),
    'icon'=>'back'
);

$attribs = array();
foreach (RolePermission::getRoles() as $k=>$v)
{
    $cmd = RolePermission::model()->dbConnection->createCommand('select count(*) from `role_permission` where `role`=:role');
    $perms = $cmd->queryScalar(array(':role'=>$k));
    $attribs[] = array(
        'id'=>$k,
        'link'=>CHtml::link(CHtml::encode($v), array('editRole', 'role'=>$k)),
        'perms'=>$perms,
    );
}
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'role-grid',
    'dataProvider'=>new CArrayDataProvider($attribs),
    'columns'=>array(
        array('name'=>Yii::t('mc', 'Role'), 'type'=>'raw', 'value'=>'$data["link"]'),
        array('name'=>Yii::t('mc', 'Assigned Permissions'), 'type'=>'raw', 'value'=>'$data["perms"]'),
    ),
)); ?>

<?php if(Yii::app()->user->hasFlash('user')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('user'); ?>
</div>
<?php endif ?>
<br/>
<br/>
