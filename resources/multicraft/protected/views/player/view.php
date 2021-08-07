<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('server/index'),
    $sv ? @Server::model()->findByPk((int)$sv)->name : Yii::t('mc', 'All')=>$sv ? array('server/view', 'id'=>$sv) : array('/server'),
);
if ($manage)
    $this->breadcrumbs[Yii::t('mc', 'Players')] = $sv ? array('player/index', 'sv'=>$sv) : array('player/admin');
$this->breadcrumbs[] = $model->isNewRecord ? Yii::t('mc', 'New Player') : $model->name;

if (!$model->isNewRecord)
{
$this->menu=array(
    array(
        'label'=>Yii::t('mc', 'Delete Player'),
        'url'=>'#',
        'linkOptions'=>array(
            'submit'=>array('delete', 'id'=>$model->id),
            'confirm'=>Yii::t('mc', 'Are you sure you want to delete this player?'),
            'csrf'=>true,
        ),
        'visible'=>$edit,
        'icon'=>'player_del',
    ),
);
}

$this->menu[] = array(
    'label'=>Yii::t('mc', 'Back'),
    'url'=>$manage ? ($sv ? array('player/index', 'sv'=>$sv) : array('player/admin')) : array('server/view', 'id'=>$sv),
    'icon'=>'back',
);

?>

<?php
if (!$edit)
{
    $attribs = array('name', 'level'=>array('name'=>'level',
        'value'=>User::getRoleLabel(User::getLevelRole($model->level))));
    $user = User::model()->findByPk((int)$model->user);
    if ($user)
        $attribs[] = array('label'=>Yii::t('mc', 'Belongs to'), 'type'=>'raw',
            'value'=>CHtml::encode($user->name));
}
else
{
    $form=$this->beginWidget('CActiveForm', array(
            'id'=>'player-form',
            'enableAjaxValidation'=>false,
        ));

    if (!$sv)
        $attribs[] = array('label'=>$form->labelEx($model,'server_id'), 'type'=>'raw',
                'value'=>$form->dropDownList($model,'server_id', CHtml::listData(Server::model()->findAll(),
                    'id', 'name')).' '.$form->error($model,'server_id'));
    $attribs[] = array('label'=>$form->labelEx($model,'name'), 'type'=>'raw',
            'value'=>$form->textField($model,'name').' '.$form->error($model,'name'));  
    $attribs[] = array('label'=>$form->labelEx($model,'level'), 'type'=>'raw',
            'value'=>$form->dropDownList($model,'level',$playerRoles)
            .' '.$form->error($model,'level'));
    $user = User::model()->findByPk($model->user);
    $assign = $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name'=>'user-name',
        'source'=>$this->createUrl('user/autocomplete', array('server_id'=>$sv)),
        'value'=>@$_POST['user-name'] ? $_POST['user-name'] : ($user ? $user->name : ''),
        'options'=>array(
            'minLength'=>2,
        ),
    ), true);
    $assign .= $form->error($model, 'user');
    $attribs[] = array('label'=>Yii::t('mc', 'Assign to user'), 'type'=>'raw',
        'value'=>$assign);
    $attribs[] = array('label'=>$form->labelEx($model,'banned'), 'type'=>'raw',
            'value'=>$form->dropDownList($model, 'banned', array(''=>Yii::t('mc', 'False'), 'true'=>Yii::t('mc', 'True'))));
    $attribs[] = array('label'=>'', 'type'=>'raw', 'value'=>CHtml::submitButton($model->isNewRecord ? Yii::t('mc', 'Create') : Yii::t('mc', 'Save')));
}
if (!$model->isNewRecord)
{
    $attribs[] = 'status';
    $attribs[] = array('name'=>'lastseen', 'value'=>$model->lastseen ? @date(Yii::t('mc', 'd. M Y, H:i'), (int)$model->lastseen) : Yii::t('mc', 'Never'));
    if ($viewDetails)
        $attribs = array_merge($attribs, array('ip', 'previps', 'quitreason'));
}
if (@$give && $model->status == 'online')
{
    $defItem = '1:0';
    ob_start(); 
?>
        <div id="give-form">
        <?php
            $listdata = array();
            foreach ($itemlist as $idx => $item)
                $listdata[$idx] = $item['name'];
            asort($listdata);
            echo CHtml::dropDownList('give-item', $defItem, $listdata);
            $range = range(64, 1);
            echo CHtml::dropDownList('give-amount', @$defAmount, array_combine($range, $range));
         ?>
        <?php echo CHtml::ajaxButton(
            Yii::t('mc', 'Give'), '', array(
                    'type'=>'POST',
                    'data'=>array(
                        'ajax'=>'give',
                        'item'=>"js:$('#give-item').val()",
                        Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                        'amount'=>"js:$('#give-amount').val()"
                    ),
                    'success'=>'function(e) {if (e) alert(e);}'
                ),
                array('id'=>'give-button')
            ) ?>
        </div>

<?php
    $attribs[] = array('label'=>Yii::t('mc', 'Give'), 'type'=>'raw', 'value'=>ob_get_clean());
}

if (@$tp && $model->status == 'online')
{
    $attribs[] = array('label'=>Yii::t('mc', 'Teleport to'), 'type'=>'raw',
            'value'=>CHtml::tag('select', array('id'=>'tp-ajax'), ''.@$data['tp']).' '
            .CHtml::ajaxButton(Yii::t('mc', 'Teleport'), '', array(
                    'type'=>'POST',
                    'data'=>array(
                        'ajax'=>'tp',
                        Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                        'player'=>"js:$('#tp-ajax').val()"
                    ),
                    'success'=>'function(e) {if (e) alert(e);}'
                ),
                array('id'=>'teleport-button')
            ));
}

if (@$tp && $model->status == 'online')
{
    $attribs[] = array('label'=>Yii::t('mc', 'Summon'), 'type'=>'raw',
            'value'=>CHtml::tag('select', array('id'=>'summon-ajax'), ''.@$data['summon']).' '
            .CHtml::ajaxButton(Yii::t('mc', 'Summon'), '', array(
                    'type'=>'POST',
                    'data'=>array(
                        'ajax'=>'summon',
                        Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                        'player'=>"js:$('#summon-ajax').val()"
                    ),
                    'success'=>'function(e) {if (e) alert(e);}'
                ),
                array('id'=>'summon-button')
            ));
}


$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attribs,
)); 

if ($edit)
    $this->endWidget();
?>

<?php if(Yii::app()->user->hasFlash('player')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('player'); ?>
</div>
<?php endif ?>

<?php if (!$model->isNewRecord) $this->printRefreshScript(); ?>
