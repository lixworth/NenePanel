<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
?>
<?php $this->renderPartial('//layouts/components/head'); ?>
	<div class="wrapper" id="mini">
		<div class="content-wrapper no-offset">
			<div class="branding">
				<?php echo Theme::img('multicraft.png', 'Multicraft logo', ['class' => 'brand-image']); ?>
				<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
			</div> <!-- /.branding -->
			<div class="card card-primary card-outline content">
				<div class="card-header">
						<!-- Navbar -->
							<nav>
								<!-- Left navbar links -->
								<?php
									$items = array();

									$simple = (Yii::app()->theme && in_array(Yii::app()->theme->name, array('simple', 'mobile', 'platform')));
									$items[] = array('label'=>Yii::t('mc', 'Home'), 'url'=>array('/site/page', 'view'=>'home'), 'linkOptions'=> array('class' => 'nav-link'));
									if (@Yii::app()->params['installer'] !== 'show')
										{
											$items[] = array(
												'label'=>Yii::t('mc', 'Servers'),
												'url'=>array('/server/index', 'my'=>1),
												'linkOptions'=> array('class' => 'nav-link'),
												'visible'=>(!Yii::app()->user->isGuest || Yii::app()->user->showList),
											);
											$items[] = array(
												'label'=>Yii::t('mc', 'Users'),
												'url'=>array('/user/index'),
												'linkOptions'=> array('class' => 'nav-link'),
												'visible'=>(Yii::app()->user->isStaff()
												|| !(Yii::app()->user->isGuest || (Yii::app()->params['hide_userlist'] === true) || $simple)),
											);
											$items[] = array(
												'label'=>Yii::t('mc', 'Profile'),
												'url'=>array('/user/view', 'id'=>Yii::app()->user->id),
												'linkOptions'=> array('class' => 'nav-link'),
												'visible'=>(!Yii::app()->user->isStaff() && !Yii::app()->user->isGuest
												&& ((Yii::app()->params['hide_userlist'] === true) || $simple)),
											);
											$items[] = array(
												'label'=>Yii::t('mc', 'Settings'),
												'url'=>array('/daemon/index'),
												'linkOptions'=> array('class' => 'nav-link'),
												'visible'=>Yii::app()->user->isSuperuser(),
											);
											if (!empty(Yii::app()->params['support_url']))
											{
												$items[] = array(
													'label'=>Yii::t('mc', 'Support'),
													'linkOptions'=> array('class' => 'nav-link'),
													'url'=>Yii::app()->params['support_url']
												);
											}
											else
											{
												$items[] = array(
													'label'=>Yii::t('mc', 'Support'),
													'url'=>array('/site/report'),
													'linkOptions'=> array('class' => 'nav-link'),
													'visible'=>!empty(Yii::app()->params['admin_email']),
												);
											}
										}
										$items[] = array(
											'label'=>Yii::t('mc', 'About'),
											'url'=>array('/site/page', 'view'=>'about'),
											'linkOptions'=> array('class' => 'nav-link'),
											'visible'=>$simple,
										);
										if (Yii::app()->user->isGuest)
										{
											$items[] = array(
												'label'=>Yii::t('mc', 'Login'),
												'url'=>array('/site/login'),
												'linkOptions'=> array('class' => 'nav-link'),
											);
										}
										else
										{
											$items[] = array(
												'label'=>Yii::t('mc', 'Logout', array('{name}'=>Yii::app()->user->name)),
												'url'=>array('/site/logout'),
												'linkOptions'=> array('class' => 'nav-link'),
											);
										}
										$this->widget('zii.widgets.CMenu', array(
											'items'=>$items,
											'htmlOptions'=>array('class'=>'navbar-nav'),
											'itemCssClass'=>'nav-item',
										)); ?>
							</nav>
							<!-- /.navbar -->
				</div> <!-- /.card-header -->
				<div class="card-body" id="content"><?php echo $content; ?></div>
			</div> <!-- /.card -->
		</div> <!-- /#content-wrapper -->
	</div> <!-- /#mini -->

	<footer class="main-footer no-offset">Powered by <?php echo CHtml::link('Multicraft Control Panel', 'https://www.multicraft.org/') ?></footer>
<?php $this->renderPartial('//layouts/components/foot'); ?>
<?php $this->renderPartial('//layouts/components/foot'); ?>
