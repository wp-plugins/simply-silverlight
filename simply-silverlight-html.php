<?php
/*
	This file is part of the Simply Silverlight 1.0 plugin for WordPress.
	For more information, please visit http://www.digitalwindfire.com/software/simply-silverlight.
*/

/*
	Copyright 2011  David Wright  (email : davidwright@digitalwindfire.com)

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

// get current settings from database
$options = get_option('simply-silverlight-settings');

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
			</p>
		</form>
	</div>
	<?php
}

function simply_silverlight_path_setting_html() {
	global $options;
	echo "<input id='simply-silverlight-settings[path]' name='simply-silverlight-settings[path]' type='text' style='width: 150px;' value='{$options['path']}'>";
	echo "<span class='description' style='margin-left:20px;'>".__('The location of the .xap file relative to the root of the site. Can be an absolute URL.', 'simply-silverlight')."</span>";
}

function simply_silverlight_width_setting_html() {
	global $options;
	echo "<input id='simply-silverlight-settings[width]' name='simply-silverlight-settings[width]' type='text' style='width: 150px;' value='{$options['width']}'>";
	echo "<span class='description' style='margin-left:20px;'>".__('The Width attribute of the OBJECT tag.', 'simply-silverlight')."</span>";
}

function simply_silverlight_height_setting_html() {
	global $options;
	echo "<input id='simply-silverlight-settings[height]' name='simply-silverlight-settings[height]' type='text' style='width: 150px;' value='{$options['height']}'>";
	echo "<span class='description' style='margin-left:20px;'>".__('The Height attribute of the OBJECT tag.', 'simply-silverlight')."</span>";
}

function simply_silverlight_background_setting_html() {
	global $options;
	echo "<input id='simply-silverlight-settings[background]' name='simply-silverlight-settings[background]' type='text' style='width: 150px;' value='{$options['background']}'>";
	echo "<span class='description' style='margin-left:20px;'>".__('The Background color of the OBJECT tag.', 'simply-silverlight')."</span>";
}

function simply_silverlight_display_setting_html() {
	global $options;
	$items = array("inline", "block", "list-item");
	echo "<select id='simply-silverlight-settings[display]' name='simply-silverlight-settings[display]' style='width: 150px;'>";
	foreach($items as $item) {
		$selected = ($options['display'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "<span class='description' style='margin-left:20px;'>".__('The CSS Display property of the DIV tag\'s Style attribute.', 'simply-silverlight')."</span>";
}

function simply_silverlight_float_setting_html() {
	global $options;
	$items = array("left", "right");
	echo "<select id='simply-silverlight-settings[float]' name='simply-silverlight-settings[float]' style='width: 150px;'>";
	foreach($items as $item) {
		$selected = ($options['float'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "<span class='description' style='margin-left:20px;'>".__('The CSS Float property of the DIV tag\'s Style attribute.', 'simply-silverlight')."</span>";
}

function simply_silverlight_style_setting_html() {
	global $options;
	echo "<input id='simply-silverlight-settings[style]' name='simply-silverlight-settings[style]' type='text' style='width: 150px;' value='{$options['style']}'>";
	echo "<span class='description' style='margin-left:20px;'>".__('The Style attribute of the DIV tag. Takes precedence over the Display and Float properties.', 'simply-silverlight')."</span>";
}

function simply_silverlight_version_setting_html() {
	global $options;
	$items = array("4.0.60531.0", "3.0.50106.0");
	echo "<select id='simply-silverlight-settings[version]' name='simply-silverlight-settings[version]' style='width: 150px;'>";
	foreach($items as $item) {
		$selected = ($options['version'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "<span class='description' style='margin-left:20px;'>".__('The minimum runtime version of Silverlight required by the control.', 'simply-silverlight')."</span>";
}

function simply_silverlight_autoupgrade_setting_html() {
	global $options;
	$items = array("true", "false");
	echo "<select id='simply-silverlight-settings[autoupgrade]' name='simply-silverlight-settings[autoupgrade]' style='width: 150px;'>";
	foreach($items as $item) {
		$selected = ($options['autoupgrade'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "<span class='description' style='margin-left:20px;'>".__('The existing Silverlight runtime will attempt to upgrade itself if necessary.', 'simply-silverlight')."</span>";
}

function simply_silverlight_preservesettings_setting_html() {
	global $options;
	$items = array("true", "false");
	echo "<select id='simply-silverlight-settings[preservesettings]' name='simply-silverlight-settings[preservesettings]' style='width: 150px;'>";
	foreach($items as $item) {
		$selected = ($options['preservesettings'] == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";	
	echo "<span class='description' style='margin-left:20px;'>".__('Settings will be preserved when plugin is deactivated.', 'simply-silverlight')."</span>";
}
?>