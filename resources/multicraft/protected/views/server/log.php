<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.($command ? Yii::t('mc', 'Console') : Yii::t('mc', 'Log'));

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    $command ? Yii::t('mc', 'Console') : Yii::t('mc', 'Log'),
);

$this->menu = array(
    array(
        'label'=>Yii::t('mc', 'Back'),
        'url'=>array('server/view', 'id'=>$model->id),
        'icon'=>'back',
    )
);
?>

<h3 class="row">
    <div class="col-md-6">
        <div class="pull-left"><img id="statusicon-ajax" src="<?php echo @$data['statusicon'] ?>" alt=""/></div>
        <?php echo Yii::t('mc', 'Server') ?> <?php echo $command ? Yii::t('mc', 'Console') : Yii::t('mc', 'Log') ?>
    </div>
    <div class="col-xs-6 text-right">
        <div id="buttons">
<?php $this->renderPartial('_buttons', array('model'=>$model, 'data'=>$data)) ?>
        </div>
        <div id="buttons-ajax" style="display: none">
            <?php echo @$data['buttons'] ?>
        </div>
        <div id="log_bottomup" style="display: none"><?php echo Yii::app()->params['log_bottomup'] === true ? 'true' : '' ?></div>
    </div>
</h3>
<br/>
<?php
$log = '<div id="log-ajax" class="logArea">'.CHtml::encode(''.@$data['log']).'</div>';
?>
<?php
if (Yii::app()->params['log_bottomup'] === true)
    echo $log;
?>
<?php if ($command): ?>
<?php echo CHtml::beginForm() ?>
<table class="stdtable" style="width: 100%">
        <div style="display:none">
            <input type="text" name="ieBugWorkaround"/>
        </div>
        <div class="input-group">
            <input type="text" id="command" name="command" value="" class="form-control" data-focus/>
            <span class="input-group-btn">
            <?php echo CHtml::ajaxSubmitButton(Yii::t('mc', 'Send'), '', array('type'=>'POST',
                    'data'=>array('ajax'=>'command', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                    'command'=>"js:$('#command').val()"), 'success'=>'js:command_response'
                ), array('class' => 'btn btn-primary')) ?>
            </span>
        </div>
        <div class="flash-error" id="command-error" style="display: none"></div>
    </td>
</tr>
</table>
<?php echo CHtml::endForm() ?>
<?php endif ?>
<?php
if (Yii::app()->params['log_bottomup'] !== true)
    echo $log;
else
    echo '<br/>';
?>
<?php echo CHtml::ajaxLink(Yii::t('mc', 'Clear log'), '', array('type'=>'POST',
    'data'=>array('ajax'=>'clearLog', Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,),
    'success'=>'js:clearLogData')); ?>
<br/>
<br/>
<?php
    echo CHtml::script('
        function buttonChange() {
            dis = $("#buttons-ajax").html();
            for (i = 0; i < 4; i++)
            {
                if (dis[i] != "1")
                    $("input[name=yt" + i + "]").removeAttr("disabled");
                else
                    $("input[name=yt" + i + "]").attr("disabled", "disabled");
            }
        }
    ');
    $this->printRefreshScript('buttonChange', ''.@$data['log_seq']); ?>
<?php echo CHtml::script('
    function clearLogData()
    {
        $("#log-ajax").html("");
    }
    function command_response(data)
    {
        $("#command").focus();
        if (data)
        {
            $("#command-error").text(data)
            $("#command-error").show()
        }
        else
        {
            $("#command-error").hide()
            $("#command").val("")
        }
        setTimeout(function() { refresh("log"); }, 500);
    }

    $(document).ready(function() {
        $("#command").focus();
    });'); ?>
<script src="<?php echo Theme::js('console.js') ?>"></script>
