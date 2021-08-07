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
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
	<!-- Brand Logo -->
	<a href="/" class="brand-link">
		<?php echo Theme::img('multicraft.png', 'Multicraft logo', ['class' => 'brand-image']); ?>
		<span class="brand-text font-weight-light"><?php echo CHtml::encode(Yii::app()->name); ?></span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
    
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>CHtml::encode(end($this->breadcrumbs)),
					'hideOnEmpty'=>false,
				));
				$this->widget('application.components.Menu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'nav nav-pills nav-sidebar flex-column nav-flat', 'role'=>'menu', 'data-widget'=>'treeview', 'data-accordion'=>'false'),
					'itemCssClass'=>'nav-item',
				));
				$this->endWidget();
			?>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<?php if($this->notice): ?>
			<div class="row">
				<div class="col-xl-9 col-12">
					<div class="notice callout callout-info">
						<?php echo $this->notice ?>
					</div> <!-- /.notice -->
				</div>
			</div>
			<!-- /.row -->
			<?php endif ?>

			<div class="row">
				<div class="col-xl-9 col-12">
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
				</div>
			</div>
			<!-- /.row -->

			<div class="row">
				<div class="col-xl-9 col-12">
					<?php echo $content; ?>
				</div>
			</div>
			<!-- /.row -->

			</div><!-- /.container-fluid -->
		</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->endContent(); ?>
