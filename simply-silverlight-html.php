<?php
/*
	This file is part of the Simply Silverlight 1.0.3 plugin for WordPress.
	For more information, please visit http://www.digitalwindfire.com/software/simply-silverlight.
*/

/*
	Copyright 2011-2012  David Wright  (email : davidwright@digitalwindfire.com)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

function simply_silverlight_settings_html() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e('Simply Silverlight Settings', 'simply-silverlight') ?></h2>
		<form method="post" action="options.php">
			<?php settings_errors(); ?>
			<?php settings_fields('simply-silverlight-settings-group'); ?>
			<?php do_settings_sections('simply_silverlight'); ?>
			<p class="submit">
				<input id="submit" name="submit" class="button-primary" type="submit" value="<?php _e('Save Changes') ?>">
				<input id="simply-silverlight-reset" name="simply-silverlight-reset" type="submit" value="<?php _e('Restore Defaults') ?>">
			</p>
		</form>
	</div>
	
	<div>
		<p style="font-weight:bold"><?php _e('Like this plugin? Consider making a donation. Thank you.') ?></p>
		
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="donations@digitalwindfire.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Simply Silverlight - Donation">
			<input type="hidden" name="item_number" value="1002">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" title="<?php _e('Make a donation for Simply Silverlight') ?>">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<?php
}

function simply_silverlight_main_section_html() {
	echo "<p>".__('To deploy a Silverlight application on your site, copy the .xap file to the Path indicated below and add the following shortcode to your post or page: [simply-silverlight xap=filename.xap]. To prevent guest users from accessing the app use the Secure Path instead and add the secure attribute to the shortcode: [simply-silverlight xap=filename.xap secure=true].')."</p>";
	echo "<p>".__('For more examples and documentation please visit ')."<a href='http://www.digitalwindfire.com/software/simply-silverlight/' target='_blank' title='Visit Simply Silverlight Homepage'>www.digitalwindfire.com</a>.</p>";
}

function simply_silverlight_path_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:40%;'>";
	echo "<input id='simply-silverlight-settings[path]' name='simply-silverlight-settings[path]' type='text' style='width:100%;' value='{$options['path']}'>";
	echo "</div>";
	echo "<div style='float:left;width:60%;'>";
	echo "<p class='description' style='margin-left:20px;'>".__('A URL containing .xap files. This can be relative to the root of your site or an absolute URL. Typically, Silverlight apps are stored in a ClientBin directory off the root of a site.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_securepath_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:40%;'>";
	echo "<input id='simply-silverlight-settings[securepath]' name='simply-silverlight-settings[securepath]' type='text' style='width:100%;' value='{$options['securepath']}'>";
	if (strlen($options['securepath']) > 0 && !file_exists($options['securepath'])) {
		echo "<p style='color:red;font-size:95%;'>".__('WARNING! The specified path does NOT exist.')."</p>";
	}
	echo "</div>";
	echo "<div style='float:left;width:60%;'>";
	echo "<p class='description' style='margin-left:20px;'>".__('A secure location containing .xap files. The default path is protected from Internet access by web.config (IIS 7) and .htaccess (Apache) files. Ensure this directory is NOT Internet accessible. (Hint: To restore the default location, enter "default" and then click Save Changes.)', 'simply-silverlight');
	echo "</div>"; 
	echo "</div>";
}

function simply_silverlight_accesscontrol_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:40%;'>";
	echo "<textarea id='simply-silverlight-settings[accesscontrol]' name='simply-silverlight-settings[accesscontrol]' cols='100' style='width:100%; min-width:100%; max-width:100%; height:150px; min-height:150px;' value='{$options['accesscontrol']}'>{$options['accesscontrol']}</textarea>";
	echo "</div>";
	echo "<div style='float:left;width:60%;'>";
	echo "<p class='description' style='margin-left:20px;'>".__('Access control for .xap files in the Secure Path. An empty Access Control means that ANY logged-in user can access .xap files in the Secure Path, guest users CANNOT. To limit access to specific users or roles enter an access control list (ACL) for each .xap. The format is the .xap filename followed by a comma-delimited list of allowed usernames or roles in parentheses. Separate each ACL with a newline. For example, if filename.xap should only be accessed by users belonging to the Administrator or Subscriber roles as well as to the user Joe, regardless of his role membership, you would enter: filename.xap(Administrator,Subscriber,Joe).', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_width_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
        echo "<input id='simply-silverlight-settings[width]' name='simply-silverlight-settings[width]' type='text' style='width:100%;' value='{$options['width']}'>";
        echo "</div>";
        echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The Width attribute of the OBJECT tag.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_height_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<input id='simply-silverlight-settings[height]' name='simply-silverlight-settings[height]' type='text' style='width:100%;' value='{$options['height']}'>";
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The Height attribute of the OBJECT tag.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_background_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<input id='simply-silverlight-settings[background]' name='simply-silverlight-settings[background]' type='text' style='width:100%;' value='{$options['background']}'>";
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The Background color of the OBJECT tag.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_display_setting_html() {
    $options = get_option('simply-silverlight-settings');
	$items = array("inline", "block", "list-item");
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<select id='simply-silverlight-settings[display]' name='simply-silverlight-settings[display]' style='width:100%;'>";
	foreach($items as $item) {
		$selected = ($options['display'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The CSS Display property of the DIV tag\'s Style attribute.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_float_setting_html() {
    $options = get_option('simply-silverlight-settings');
	$items = array("left", "right");
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<select id='simply-silverlight-settings[float]' name='simply-silverlight-settings[float]' style='width:100%;'>";
	foreach($items as $item) {
		$selected = ($options['float'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The CSS Float property of the DIV tag\'s Style attribute.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_style_setting_html() {
    $options = get_option('simply-silverlight-settings');
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<input id='simply-silverlight-settings[style]' name='simply-silverlight-settings[style]' type='text' style='width:100%;' value='{$options['style']}'>";
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The Style attribute of the DIV tag. Takes precedence over the Display and Float properties.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_version_setting_html() {
    $options = get_option('simply-silverlight-settings');
	$items = array("5.0.60401.0", "4.0.60531.0", "3.0.50106.0");
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<select id='simply-silverlight-settings[version]' name='simply-silverlight-settings[version]' style='width:100%;'>";
	foreach($items as $item) {
		$selected = ($options['version'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The minimum runtime version of Silverlight required by the control.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_autoupgrade_setting_html() {
    $options = get_option('simply-silverlight-settings');
	$items = array("true", "false");
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<select id='simply-silverlight-settings[autoupgrade]' name='simply-silverlight-settings[autoupgrade]' style='width:100%;'>";
	foreach($items as $item) {
		$selected = ($options['autoupgrade'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('The existing Silverlight runtime will attempt to upgrade itself if necessary.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}

function simply_silverlight_preservesettings_setting_html() {
    $options = get_option('simply-silverlight-settings');
	$items = array("true", "false");
	echo "<div>";
	echo "<div style='float:left;width:20%;'>";
	echo "<select id='simply-silverlight-settings[preservesettings]' name='simply-silverlight-settings[preservesettings]' style='width:100%;'>";
	foreach($items as $item) {
		$selected = ($options['preservesettings'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "</div>";
	echo "<div style='float:left;width:80%;'>";
        echo "<p class='description' style='margin-left:20px;'>".__('Settings will be preserved when plugin is deactivated.', 'simply-silverlight')."</p>";
	echo "</div>";
	echo "</div>";
}
?>