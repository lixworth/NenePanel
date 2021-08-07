<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/mc/copymovedelete1.template.php begin -->

<?php /* ----- Copy or Move: print header table ----- */ ?>
<?php	if ($net2ftp_globals["state2"] == "copy" || $net2ftp_globals["state2"] == "move") { ?>
		<table>
			<tr><td>
				<div style="font-size: 80%; margin-bottom: 10px"><?php echo __("To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."); ?></div>
				<input type="button" class="extralongbutton btn btn-default" value="<?php echo __("Set all targetdirectories"); ?>" onclick="CopyValueToAll(document.forms['CopyMoveDeleteForm'], document.forms['CopyMoveDeleteForm'].headerDirectory, 'targetdirectory');" /> &nbsp; 
				<input type="text" class="form-control" style="width: 300px; display: inline" name="headerDirectory" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
				<?php printActionIcon("listdirectories", "createDirectoryTreeWindow('" . $net2ftp_globals["directory_js"] . "','CopyMoveDeleteForm.headerDirectory');"); ?>
			</td></tr>
		</table>
		<br />
<?php	} // end if
	/* ----- Delete: print warning message ----- */
	elseif ($net2ftp_globals["state2"] == "delete") { ?>
		<?php echo __("Are you sure you want to delete these directories and files?"); ?><br />
		<?php echo __("All the subdirectories and files of the selected directories will also be deleted!"); ?><br /><br />
<?php	} // end elseif ?>

<?php /* ----- List of selected entries ----- */ ?>
<?php	for ($i=1; $i<=sizeof($list["all"]); $i++) { ?>
<?php		printDirFileProperties($i, $list["all"][$i], "hidden", ""); ?>
		<input type="hidden" name="list[<?php echo $i; ?>][sourcedirectory]" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
<?php		if     ($net2ftp_globals["state2"] == "copy") {
			if     ($list["all"][$i]["dirorfile"] == "d") { echo __("Copy directory <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "-") { echo __("Copy file <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "l") { echo __("Copy symlink <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
		}
		elseif ($net2ftp_globals["state2"] == "move") {
			if     ($list["all"][$i]["dirorfile"] == "d") { echo __("Move directory <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "-") { echo __("Move file <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "l") { echo __("Move symlink <b>%1\$s</b> to:", $list["all"][$i]["dirfilename"]); }
		}
		elseif ($net2ftp_globals["state2"] == "delete") {
			if     ($list["all"][$i]["dirorfile"] == "d") { echo __("Directory <b>%1\$s</b>", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "-") { echo __("File <b>%1\$s</b>", $list["all"][$i]["dirfilename"]); }
			elseif ($list["all"][$i]["dirorfile"] == "l") { echo __("Symlink <b>%1\$s</b>", $list["all"][$i]["dirfilename"]); }
		} 
?>
		<br />
<?php /* ----- Copy or move: ask for options ----- */ ?>
<?php		if ($net2ftp_globals["state2"] == "copy" || $net2ftp_globals["state2"] == "move") { ?>
			<table>
				<tr>
					<td><?php echo __("Target directory:"); ?>&nbsp;</td>
					<td>
						<input type="text" class="form-control" style="width: 300px;" name="list[<?php echo $i; ?>][targetdirectory]" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
					</td>
				</tr>
				<tr><td>
					<?php echo __("Target name:"); ?>      &nbsp;</td><td><input type="text" class="input form-control" name="list[<?php echo $i; ?>][newname]" value="<?php echo $list["all"][$i]["dirfilename_html"]; ?>" />
				</td></tr>
			</table><br />
<?php		} // end if ?>
<?php	} // end for ?>
<br/>
<!-- Template /skins/mc/copymovedelete1.template.php end -->
