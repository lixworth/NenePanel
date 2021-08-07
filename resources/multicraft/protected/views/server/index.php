<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
$this->pageTitle = Yii::app()->name . ' - '.Yii::t('mc', 'Server List');

$this->breadcrumbs=array(
    Yii::t('mc', 'Servers'),
);

Yii::app()->getClientScript()->registerCss('manage', '#manage { display: none; }');

if (Yii::app()->user->isSuperuser())
{
    $firstrun = dirname(__FILE__).'/../../runtime/firstrun';
    if (!@file_exists($firstrun))
    {
        Yii::app()->clientScript->registerScript('firstrun_eula', 'setTimeout(function() { alert("'.CJavaScript::quote(Yii::t('mc', 'By using this software you accept the Multicraft EULA:
http://www.multicraft.org/eula.txt')).'"); }, 250)');
        if (!@touch($firstrun))
            Yii::app()->clientScript->registerScript('firstrun_touch', 'alert("'.CJavaScript::quote(Yii::t('mc', 'Failed to create file {file}. Please create it manually to hide the EULA notice.', array('{file}'=>$firstrun))).'")');
    }

    $this->menu=array(
        array(
            'label'=>Yii::t('mc', 'Create Server'),
            'url'=>array('create'),
            'icon'=>'create',
        ),
        array(
            'label'=>Yii::t('mc', 'Manage Servers'),
            'url'=>array('server/admin'),
            'icon'=>'server',
        ),
        array(
            'label'=>Yii::t('mc', 'Manage Server Data'),
            'url'=>'javascript:showSub("manage")',
            'icon'=>['closed', 'open'],
            'linkOptions'=>array('id'=>'manage_main'),
            'submenuOptions'=>array('id'=>'manage'),
            'items'=>array(
                array(
                    'label'=>Yii::t('mc', 'Manage Players'),
                    'url'=>array('player/admin'),
                    'icon'=>'player',
                ),
                array(
                    'label'=>Yii::t('mc', 'Manage Commands'),
                    'url'=>array('command/admin'),
                    'icon'=>'command',
                ),
                array(
                    'label'=>Yii::t('mc', 'Manage Tasks'),
                    'url'=>array('schedule/admin'),
                    'icon'=>'schedule',
                ),
            ),
        ),
    );
}
else if (Yii::app()->user->isStaff())
{
    $this->menu=array(
        array(
            'label'=>Yii::t('mc', 'Manage Servers'),
            'url'=>array('server/admin'),
            'icon'=>'server',
        ),
    );
}
else if (Yii::app()->user->showList)
{
    if (!$my)
    {
        $this->menu[] = array(
            'label'=>Yii::t('mc', 'My Servers'),
            'url'=>array('server/index', 'my'=>true),
            'visible'=>!Yii::app()->user->isGuest,
            'icon'=>'server'
        );
    }
    else
    {
        $this->menu[] = array(
            'label'=>Yii::t('mc', 'All Servers'),
            'url'=>array('server/index'),
            'visible'=>!Yii::app()->user->isGuest,
            'icon'=>'back'
        );
    }
}

if (!!Yii::app()->params['ajax_serverlist'])
    echo CHtml::script('
    function get_status(server)
    {
        '.CHtml::ajax(array(
            'type'=>'POST',
            'dataType'=>'json',
            'data'=>array(
                'ajax'=>'get_status',
                'server'=>'js:server',
                Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                ),
            'success'=>'status_response'
            )).'
    }

    function status_response(data)
    {
        id = parseInt(data["id"]);
        pl = parseInt(data["pl"]);
        img = pl >= 0 ? \''.CJavaScript::quote(Theme::img('icons/online.png')).'\' : \''.CJavaScript::quote(Theme::img('icons/offline.png')).'\';
        $("#sv_icon_"+id).html(img);
        if (pl >= 0)
        {
            str = pl;
            $("#sv_maxplr_"+id).show();
            $("#sv_chatlink_"+id).show();
        }
        else
        {
            str = "'.CJavaScript::quote(Yii::t('mc', 'Offline')).'" + (pl == -2 ? " ('.CJavaScript::quote(Yii::t('mc', 'error')).')" : "");
        }
        $("#sv_status_"+id).html(str);
    }
');
?>

<?php $this->widget('zii.widgets.CListView', array(
    'emptyText'=>'<br/>'.Yii::t('mc', 'Your own servers and other servers you have access to will be listed here.'),
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'sortableAttributes'=>array(
        'name'=>Yii::t('mc', 'Name'),
    ),
));

