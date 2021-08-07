<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/mc/unzip1.template.php begin -->

<table>
	<tr><td>
		<input type="button" class="extralongbutton btn btn-default" value="<?php echo __("Set all targetdirectories"); ?>" onclick="CopyValueToAll(document.UnzipForm, document.forms['UnzipForm'].headerDirectory, 'targetdirectory');" /> &nbsp; 
		<input type="text" class="form-control" style="width: 300px; display: inline" name="headerDirectory" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
		<?php printActionIcon("listdirectories", "createDirectoryTreeWindow('" . $net2ftp_globals["directory_js"] . "', 'UnzipForm.headerDirectory');"); ?>
		<div style="font-size: 65%"><?php echo __("To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."); ?></div>
		<div style="font-size: 65%"><?php echo __("Note: the target directory must already exist before anything can be copied into it."); ?></div>
	</td></tr>
</table>

<br /><br />

<?php	for ($i=1; $i<=sizeof($list["all"]); $i++) { ?>
<?php		printDirFileProperties($i, $list["all"][$i], "hidden", ""); ?>

<?php 	echo __("Unzip archive <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); ?><br />

<?php 	echo __("Target directory:"); ?>
		<input type="text" class="form-control" style="width: 400px; display: inline" name="list[<?php echo $i; ?>][targetdirectory]" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
<?php 	printActionIcon("listdirectories", "createDirectoryTreeWindow('" . $net2ftp_globals["directory_js"] . "', 'UnzipForm.elements[\'list[$i][targetdirectory]\']');"); ?><br />

		<br /><br />

<?php	} // end for ?>

<!-- Template /skins/mc/unzip1.template.php end -->
