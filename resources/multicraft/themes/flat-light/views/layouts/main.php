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
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-blue">
		<?php if($this->layout == '//layouts/column2') :?>
			<span class="navbar-item" id="navbar-toggle">
				<a class="nav-link" data-widget="pushmenu" data-enable-remember="true" href="#" role="button"><i class="fas fa-bars"></i></a>
			</span> <!-- /#navbar-toggle -->
		<?php endif; ?>
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
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$items,
					'htmlOptions'=>array('class'=>'navbar-nav', 'id'=>'navbar-menu'),
					'itemCssClass'=>'nav-item',
				)); ?>

    <!-- Right navbar links -->
    <?php
			$items = array();
			if (Yii::app()->user->isGuest)
				{
					$items[] = array(
						'label'=>Yii::t('mc', 'Login'),
						'url'=>array('/site/login'),
						'linkOptions'=> array('class' => 'btn btn-primary'),
					);
				}
				else
				{
					$items[] = array(
						'label'=>Yii::t('mc', 'Logout', array('{name}'=>Yii::app()->user->name)),
						'url'=>array('/site/logout'),
						'linkOptions'=> array('class' => 'btn btn-primary'),
					);
				}
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$items,
					'htmlOptions'=>array('class'=>'navbar-nav ml-auto', 'id'=>'user-menu'),
					'itemCssClass'=>'nav-item',
				));
		?>

		<span id="topmenu-toggle">
			<a class="nav-link" href="#" role="button"><i class="fas fa-ellipsis-v"></i></a>
		</span> <!-- /#topmenu-toggle -->
  </nav>
  <!-- /.navbar -->

	<?php echo $content; ?>
</div> <!-- /.wrapper -->
<?php $this->renderPartial('//layouts/components/foot'); ?>
