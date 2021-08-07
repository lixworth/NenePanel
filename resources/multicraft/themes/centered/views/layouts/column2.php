<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
?>

<?php
if (Yii::app()->user->isGuest && (Yii::app()->controller->id == "site"))
    return $this->renderPartial('//layouts/mini', array('content'=>$content));

$this->beginContent('//layouts/main');
?>
<div class="col-md-3" id="sidebar">
    <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>CHtml::encode(end($this->breadcrumbs)),
            'hideOnEmpty'=>false
        ));
        $this->widget('application.components.Menu', array(
            'items'=>$this->menu,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
    ?>
</div>
<div class="col-md-9 col-md-offset-3 col-toppad">
    <?php
        if (count($this->breadcrumbs) > 1) {
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'homeLink'=>'',
                'links'=>$this->breadcrumbs,
                'tagName' => 'ol',
                'htmlOptions' => array('class'=>'breadcrumb'),
                'separator' => '',
                'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                'inactiveLinkTemplate' => '<li class="active">{label}</li>',
            ));
        }
    ?>
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
