<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'User List');

$this->breadcrumbs=array(
    Yii::t('mc', 'Users'),
);

$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'My Profile'),
        'url'=>array('user/view', 'id'=>Yii::app()->user->id),
        'icon'=>'user',
    ),
);
if (Yii::app()->user->isStaff())
{
    $this->menu[] =  array(
        'label'=>Yii::t('mc', 'Create User'),
        'url'=>array('create'),
        'icon'=>'user_new',
    );
}
if (@Yii::app()->params['editable_roles'] && Yii::app()->user->isSuperuser())
{
    $this->menu[] =  array(
        'label'=>Yii::t('mc', 'Edit Roles'),
        'url'=>array('roles'),
        'icon'=>'config',
    );
}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array('name'=>'name', 'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->name), array("user/view", "id"=>$data->id))'),
        array('name'=>'email', 'visible'=>Yii::app()->user->isStaff()),
        array('name'=>'global_role', 'value'=>'($data->name == Yii::app()->user->superuser ? "'.CJavaScript::quote(Yii::t('mc', 'Root Superuser')).'"'
            .' : User::getRoleLabel($data->global_role))', 'visible'=>Yii::app()->user->isStaff()),
        array('name'=>'lang', 'visible'=>Yii::app()->user->isStaff(), 'htmlOptions'=>array('width'=>20)),
    ),
)); ?>

