<?php

/**
 * @author minimus
 * @copyright 2009
 */

$wpconfig = realpath("../../../../../../wp-config.php");
if (!file_exists($wpconfig))  {
	echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;	
	die;	
}
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>My WP Plugin Info</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/my-wordpress-plugin-info/tinymce/plugins/mwpi/mwpi-block-dialog.js"></script>
	<base target="_self" />
</head>

<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
  <form name="mwpi" action="#">
    <table border="0" cellpadding="4" cellspacing="0">
		  <tr>
			  <td nowrap="nowrap"><label for="mwpi_slug"><?php _e('Slug', 'my-wordpress-plugin-info').':'; ?></label></td>
			  <td><input id="mwpi_slug" name="mwpi_slug" style="width: 200px"/></td>
		  </tr>
		  <tr>
			  <td nowrap="nowrap"><label for="mwpi_mode"><?php _e('Output Mode', 'my-wordpress-plugin-info').':'; ?></label></td>
			  <td nowrap="nowrap">
				  <select id="mwpi_mode" name="mwpi_mode" style="width: 200px">
				    <option value="info"><?php _e('Info', 'my-wordpress-plugin-info'); ?></option>
				    <option value="download"><?php _e('Download', 'my-wordpress-plugin-info'); ?></option>
				  </select>
				</td>
		  </tr>
		</table>
		<div class="mceActionPanel">
		  <div style="float: left">
        <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'my-wordpress-plugin-info'); ?>" onclick="tinyMCEPopup.close();" />
      </div>
      <div style="float: right">
        <input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'my-wordpress-plugin-info'); ?>" onclick="insertMWPICode();" />
      </div>
    </div>
  </form>
