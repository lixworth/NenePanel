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
