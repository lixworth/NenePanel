<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

if (!isset($ajaxServerlist))
    $ajaxServerlist = Yii::app()->params['ajax_serverlist'];
?>
<div class="row server-list" onClick="window.location='<?php echo CHTML::normalizeUrl(array('server/view', 'id'=>$data->id)) ?>'">
    <?php
    $pl = 0;
    $img = $data->suspended ? 'offline.png' : 'changing.png';
    if (!$ajaxServerlist)
    {
        $pl = $data->getOnlinePlayers();
        $img = $pl >= 0 ? 'online.png' : 'offline.png';
    }
    ?>
    <div class="col-xs-1" id="sv_icon_<?php echo $data->id ?>">
        <?php echo Theme::img('icons/'.$img) ?>
    </div>
    <div class="col-xs-6">
        <?php echo CHTML::link(CHtml::encode($data->name), array('server/view', 'id'=>$data->id)) ?>
    </div>
    <div class="col-xs-5">

            <span id="sv_status_<?php echo $data->id ?>">
            <?php
            if ($data->suspended)
                echo Yii::t('mc', 'Suspended').'</span>';
            else
            {
                if (!$ajaxServerlist)
                {
                    if ($pl >= 0)
                        echo CHtml::encode($pl).' /  '.CHtml::encode($data->players).' '.Yii::t('mc', 'Players');
                    else
                        echo Yii::t('mc', 'Offline').($pl == -2 ? ' ('.Yii::t('mc', 'error').')' : '');
                }
                else
                    echo Yii::t('mc', 'Pending');
                echo '</span>';
                echo '<span id="sv_maxplr_'.$data->id.'" style="display: none"> /  '.CHtml::encode($data->players).' '.Yii::t('mc', 'Players').'</span>';
                if ($pl >= 0 && Yii::app()->user->can($data->id, 'chat'))
                {
                    echo '<span id="sv_chatlink_'.$data->id.'"'.($ajaxServerlist ? ' style="display: none"' : '')
                        .'> ('.CHtml::link(Yii::t('mc', 'Chat'), array('server/chat', 'id'=>$data->id)).')</span>';
                }
            }
            ?>
    </div>
    <?php
        if (!!$ajaxServerlist && !$data->suspended)
            echo CHtml::script('get_status('.$data->id.');')
    ?>
</div>
