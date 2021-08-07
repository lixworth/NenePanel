<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
function ajaxButton($model, $data, $label, $cmd, $index)
{
    echo CHtml::ajaxButton(
        $label,
        array('view', 'id'=>$model->id),
        array(
            'type'=>'POST',
            'data'=>array(
                'ajax'=>$cmd,
                Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
            ),
            'success'=>'function(e) {if (e) alert(e);}'
        ),
        array('class'=>'btn btn-primary btn-servercontrol')
            + (@$data['buttons'][$index] != '1' ? array() : array('disabled'=>'disbled'))
    );
}
ajaxButton($model, $data, Yii::t('mc', 'Start'), 'start', 0);
ajaxButton($model, $data, Yii::t('mc', 'Stop'), 'stop', 1);
ajaxButton($model, $data, Yii::t('mc', 'Restart'), 'restart', 2);
$kill = Yii::app()->params['kill_button'];
if ($kill && ((Yii::app()->user->isStaff() && in_array($kill, array('superuser', 'user'))) || ($kill == 'user')))
    ajaxButton($model, $data, Yii::t('mc', 'Kill'), 'kill', 3);
