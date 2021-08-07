<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
?>
<!doctype html>
<html lang="en">
<!--
 -
 -   Copyright © 2010-2021 by xhost.ch GmbH
 -
 -   All rights reserved.
 -
 -->
<head>
	<meta content="initial-scale=1.0, width=device-width, user-scalable=yes" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rev="made" href="mailto:info@multicraft.org">
	<meta name="description" content="Multicraft: The Minecraft server control panel">
	<meta name="keywords" content="Multicraft, Minecraft, server, management, control panel, hosting">
	<meta name="author" content="xhost.ch GmbH">
	<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico" />

	<link rel="stylesheet" type="text/css" href="<?php echo Theme::css('overlayScrollbars/OverlayScrollbars.min.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo Theme::css('theme.css') ?>" />

	<script src="<?php echo Theme::js('fontawesome/fontawesome.js') ?>"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<?php if (Yii::app()->user->isGuest && (Yii::app()->controller->id == "site")): ?>
	<body class="hold-transition layout-fixed mini">
<?php else: ?>
	<body class="hold-transition <?= $this->layout == '//layouts/column2' ? 'sidebar-mini' : 'sidebar-collapse' ?> layout-fixed layout-navbar-fixed">
<?php endif; ?>
    <script>document.getElementsByTagName('body')[0].classList.add(localStorage.getItem('remember.lte.pushmenu') || '');</script>
