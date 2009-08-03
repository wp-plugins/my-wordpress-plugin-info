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
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/my-wordpress-plugin-info/tinymce/plugins/mwpi/mwpi-dialog.js"></script>
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
				    <option value="api"><?php _e('API (As Is)', 'my-wordpress-plugin-info'); ?></option>
				    <option value="fmt"><?php _e('Formated', 'my-wordpress-plugin-info'); ?></option>
				  </select>
				</td>
		  </tr>
		  <tr>
				<td nowrap="nowrap"><label for="mwpi_data"><?php _e('Output Data', 'my-wordpress-plugin-info').':'; ?></label></td>
				<td nowrap="nowrap">
				  <select id="mwpi_data" name="mwpi_data" style="width: 200px">
					  <option value="name"><?php _e('Plugin Name', 'my-wordpress-plugin-info'); ?></option>
					  <option value="slug"><?php _e('Plugin Slug', 'my-wordpress-plugin-info'); ?></option>
					  <option value="version"><?php _e('Current Version', 'my-wordpress-plugin-info'); ?></option>
					  <option value="author"><?php _e('Author', 'my-wordpress-plugin-info'); ?></option>
					  <option value="author_profile"><?php _e('Author Profile', 'my-wordpress-plugin-info'); ?></option>
					  <option value="requires"><?php _e('Required Wordpress Version', 'my-wordpress-plugin-info'); ?></option>
					  <option value="tested"><?php _e('High Wordpress version tested', 'my-wordpress-plugin-info'); ?></option>
					  <option value="rating"><?php _e('Rating (%)', 'my-wordpress-plugin-info'); ?></option>
					  <option value="num_ratings"><?php _e('Number of Votes', 'my-wordpress-plugin-info'); ?></option>
					  <option value="rating_raw"><?php _e('Rating (stars)', 'my-wordpress-plugin-info'); ?></option>
					  <option value="downloaded"><?php _e('Number of Downloads', 'my-wordpress-plugin-info'); ?></option>
					  <option value="last_updated"><?php _e('Last Updated', 'my-wordpress-plugin-info'); ?></option>
					  <option value="homepage"><?php _e('Plugin Homepage', 'my-wordpress-plugin-info'); ?></option>
					  <option value="download_link"><?php _e('Plugin Download Link', 'my-wordpress-plugin-info'); ?></option>
					  <option value="tags"><?php _e('Plugin Tags', 'my-wordpress-plugin-info'); ?></option>
					  <option value="description"><?php _e('Plugin "Description" Section', 'my-wordpress-plugin-info'); ?></option>
					  <option value="installation"><?php _e('Plugin "Installation" Section', 'my-wordpress-plugin-info'); ?></option>
					  <option value="faq"><?php _e('Plugin FAQ Section', 'my-wordpress-plugin-info'); ?></option>
					  <option value="screenshots"><?php _e('Plugin "Screenshots" Section', 'my-wordpress-plugin-info'); ?></option>
					  <option value="changelog"><?php _e('Plugin "Change Log" Section', 'my-wordpress-plugin-info'); ?></option>
					  <option value="other_notes"><?php _e('Plugin "Other Notes" Section', 'my-wordpress-plugin-info'); ?></option>
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
