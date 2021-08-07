<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/mc/error.template.php begin -->
<div>
<script type="text/javascript" src="<?php echo Theme::js('net2ftp/edit.js'); ?>"></script>
		<p><?php
			Yii::log($net2ftp_result["errormessage"], 'error');
			echo Yii::t('mc', 'FTP login failed, please check your password.<br/><br/>If this error persists please contact your administrator. The error has been logged.');
		?><br /><br />
		<a href="javascript:top.history.back();"><?php echo __("Go back"); ?></a></p><br />
<?php /*
		<div id="error_hidden">
			<a style="float: right; font-size: 0.8em" href="javascript:toggleTextarea('error');">View technical details</a>
		</div>
		<div id="error_shown" style="display: none;">
			<a style="float: right; font-size: 0.8em" href="javascript:toggleTextarea('error');">Hide technical details</a><br /><br />
			The error occured in file <b><?php echo $net2ftp_result["file"]; ?></b> on line <b><?php echo $net2ftp_result["line"]; ?></b>.<br />
			<ul>
<?php			for ($i=0; $i<sizeof($net2ftp_result["debug_backtrace"]); $i++) { ?>
				<li> function <?php echo $net2ftp_result["debug_backtrace"][$i]["function"]; ?> <span style="font-size: 75%">(<?php echo $net2ftp_result["debug_backtrace"][$i]["file"]; ?> on line <?php echo $net2ftp_result["debug_backtrace"][$i]["line"]; ?>)</span>
<?php				if (isset($net2ftp_result["debug_backtrace"][$i]["args"]) == true && sizeof($net2ftp_result["debug_backtrace"][$i]["args"]) > 0) { ?>
				<ul>
<?php					for ($j=0; $j<sizeof($net2ftp_result["debug_backtrace"][$i]["args"]); $j++) { ?>
					<li> argument <?php echo $j; ?>: <?php echo $net2ftp_result["debug_backtrace"][$i]["args"][$j]; ?></li>
<?php					} // end for ?>
				</ul>
<?php				} // end if ?>
				</li>
<?php			} // end for ?>
			</ul>
		</div>
	</div>
*/ ?>
    <div style="clear: both"></div>
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/footer.template.php"); ?>
<!-- Template /skins/mc/error.template.php end -->
