<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/mc/zip1.template.php begin -->
<div>
<?php echo __("Save the zip file on the FTP server as:"); ?> <input type="text" class="form-control" class="input" name="zipactions[save_filename]" value="<?php echo $zipfilename; ?>" />
</div> &nbsp; 

<?php for ($i=1; $i<=sizeof($list["all"]); $i++) { ?>
<?php		printDirFileProperties($i, $list["all"][$i], "hidden", ""); ?>
<?php	} // end for ?>

<!-- Template /skins/mc/zip1.template.php end -->
