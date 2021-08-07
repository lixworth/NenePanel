<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="leftbox">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>CHtml::encode(end($this->breadcrumbs)),
                'hideOnEmpty'=>false,
            ));
            $this->widget('application.components.Menu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
    <div class="rightbox">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>
