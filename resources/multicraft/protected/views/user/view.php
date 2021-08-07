<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
if (Yii::app()->user->isStaff() || !Yii::app()->params['hide_userlist'])
    $this->breadcrumbs = array(Yii::t('mc', 'Users')=>array('index'));
else
    $this->breadcrumbs = array(Yii::t('mc', 'Profile'));
$this->breadcrumbs[] = $model->isNewRecord ? Yii::t('mc', 'New User') : $model->name;

Yii::app()->getClientScript()->registerCoreScript('jquery');

if (Yii::app()->user->isStaff()
    && $edit
    && !$model->isNewRecord
    && $model->name != Yii::app()->user->name
    && $model->name != Yii::app()->user->superuser)
{
$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Delete User'),
        'url'=>'#',
        'linkOptions'=>array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=>Yii::t('mc', 'Are you sure you want to delete this user?'),
            'csrf'=>true,
        ),
        'icon'=>'user_del',
    ),
);
}
if ((Yii::app()->params['user_api_keys'] === true || Yii::app()->user->isSuperuser())  && !$model->isNewRecord)
{
    if (!$model->api_key)
    {
        $this->menu[] = array(
                'label'=>Yii::t('mc', 'Generate API Key'),
                'url'=>'#',
                'linkOptions'=>array(
                    'submit'=>array('view','id'=>$model->id),
                    'confirm'=>Yii::t('mc', 'Allow this user to access the Multicraft API?'),
                    'params'=>array('action'=>'new_api_key'),
                    'csrf'=>true,
                ),
                'icon'=>'key_new',
            );
    }
    else
    {
        $this->menu[] = array(
                'label'=>Yii::t('mc', 'Remove API Key'),
                'url'=>'#',
                'linkOptions'=>array(
                    'submit'=>array('view','id'=>$model->id),
                    'confirm'=>Yii::t('mc', 'Disable Multicraft API access for this user?'),
                    'params'=>array('action'=>'del_api_key'),
                    'csrf'=>true,
                ),
                'icon'=>'key_del',
            );
    }
}
if (!$model->isNewRecord && $model->id === Yii::app()->user->model->id && @Yii::app()->params['enable_gauth']
    && isset($model->gauth_secret) && !$model->gauth_secret)
{
    $this->menu[] = array(
            'label'=>Yii::t('mc', 'Enable Google Authenticator'),
            'url'=>array('user/enableGauth', 'id'=>$model->id),
            'icon'=>'key_new',
        );
}
else if ($model->gauthEnabled() && $edit)
{
    $this->menu[] = array(
            'label'=>Yii::t('mc', 'Disable Google Authenticator'),
            'url'=>array('user/disableGauth', 'id'=>$model->id),
            'icon'=>'key_del',
        );
}
if (Yii::app()->user->isStaff() || Yii::app()->params['hide_userlist'] !== true)
{
    $this->menu[] = array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('user/index'),
        'icon'=>'back'
    );
}
?>

<?php
if (!$edit)
{
    $attribs = array('name');
}
else
{
    $form=$this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('autocomplete'=>'off'),
        ));

    if ($model->name != Yii::app()->user->superuser)
    {
        if (Yii::app()->user->isSuperuser() || $staffEdit)
        {
            $attribs[] = array('label'=>$form->labelEx($model,'name'), 'type'=>'raw',
                'value'=>$form->textField($model,'name').' '.$form->error($model,'name'));
        }
        if (Yii::app()->user->isSuperuser())
        {
            $attribs[] = array('label'=>$form->labelEx($model,'global_role'), 'type'=>'raw',
                'value'=>$form->dropDownList($model,'global_role',$allRoles)
                    .' '.$form->error($model,'global_role'),
                'hint'=>Yii::t('mc', 'Role that applies for all servers'));
        }
    }
    else
    {
        $attribs[] = 'name';
        $attribs[] = array('label'=>$model->getAttributeLabel('global_role'), 'value'=>Yii::t('mc', 'Superuser'));
    }
    if (Yii::app()->user->isSuperuser())
    {
        $options = array(
            ''      => Yii::t('mc', 'None'),
            'ro'    => Yii::t('mc', 'Read only'),
            'rw'    => Yii::t('mc', 'Full access')
        );
        $access = isset($_POST['global_ftp_access']) ? $_POST['global_ftp_access'] : $model->getServerFtpAccess(0);
        $attribs[] = array('label'=>Yii::t('mc', 'Global FTP Access'), 'type'=>'raw',
            'value'=>CHtml::dropDownList('global_ftp_access', $access, $options));
    }
    if ($model->api_key)
        $attribs[] = array('label'=>$form->labelEx($model,'api_key'), 'type'=>'raw',
                'value'=>CHtml::textField('ak', $model->api_key, array('id'=>'apiKeyBox', 'readonly'=>'readonly')).' '.$form->error($model,'api_key'));
    $attribs[] = array('label'=>$form->labelEx($model,'lang'), 'type'=>'raw',
            'value'=>$form->dropDownList($model,'lang', $this->languageSelection()).' '.$form->error($model,'lang'));
    if (Yii::app()->user->isSuperuser() || $staffEdit || Yii::app()->params['user_theme'] === true)
    {
        $attribs[] = array('label'=>$form->labelEx($model,'theme'), 'type'=>'raw',
                'value'=>$form->dropDownList($model,'theme', $this->themeSelection()).' '.$form->error($model,'theme'));
    }
    $attribs[] = array('label'=>$form->labelEx($model,'email'), 'type'=>'raw',
            'value'=>$form->textField($model,'email').' '.$form->error($model,'email'));
    if (Yii::app()->user->name == $model->name)
    {
        $attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'Current Password'), 'oldPassword'), 'type'=>'raw',
                'value'=>CHtml::passwordField('oldPassword', '').' '.$form->error($model,'oldPassword'));
        $attribs[] = array('label'=>CHtml::label(Yii::t('mc', 'New Password'), 'User_password'), 'type'=>'raw',
                'value'=>$form->passwordField($model,'password').' '.$form->error($model,'password'));
        $attribs[] = array('label'=>$form->labelEx($model,'confirmPassword'), 'type'=>'raw',
                'value'=>$form->passwordField($model,'confirmPassword').' '.$form->error($model,'confirmPassword'));
    }
    else
    {
        $attribs[] = array('label'=>$form->labelEx($model,'password'), 'type'=>'raw',
                'value'=>$form->passwordField($model,'password').' '.$form->error($model,'password'));
    }
    if (Yii::app()->user->isStaff() && Yii::app()->params['mail_welcome'])
    {
        $attribs[] = array('label'=>CHtml::label($model->isNewRecord ? Yii::t('mc', 'Send Welcome Mail')
                : Yii::t('mc', 'Send new password if changed'), 'User_sendData'), 'type'=>'raw',
            'value'=>$form->checkBox($model, 'sendData'));
    }
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton($model->isNewRecord ? Yii::t('mc', 'Create') : Yii::t('mc', 'Save')));
}


$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
)); 

if ($edit)
    $this->endWidget();

echo CHtml::script('$("#apiKeyBox").focus(function() { this.select(); });');            
?>

<?php if(Yii::app()->user->hasFlash('user')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('user'); ?>
</div>
<?php endif ?>
<br/>
<br/>
<?php
if (!$model->isNewRecord)
{
    $this->widget('zii.widgets.CListView', array(
        'emptyText'=>'',
        'dataProvider'=>$servers,
        'itemView'=>'_server',
        'ajaxUpdate'=>false,
        'sortableAttributes'=>array(
            'name'=>Yii::t('mc', 'Name'),
        ),
    ));
}

