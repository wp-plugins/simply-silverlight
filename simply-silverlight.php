<?php
/*
	Plugin Name: Simply Silverlight
	Plugin URI: http://www.digitalwindfire.com/software/simply-silverlight
	Description: Bring the power of Microsoft's visually rich Silverlight technology to your WordPress site today! Simply Silverlight makes deploying Silverlight .xap files to your WordPress blog's posts and pages incredibly easy and intuitive. Don't hesitate, click Activate now!
	Version: 0
	Author: David Wright
	Author URI: http://www.digitalwindfire.com
	License: GPL2
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

// include file containing html display functions
include 'simply-silverlight-html.php';

// register activation function
register_activation_hook(__FILE__, 'simply_silverlight_activate'); 

// register deactivation function
register_deactivation_hook(__FILE__, 'simply_silverlight_deactivate');

// add action for loading the textdomain
add_action('init', 'simply_silverlight_load_textdomain');

// add action to add an admin interface
add_action('admin_menu', 'simply_silverlight_add_admin_menu');

// add action to build the admin page
add_action('admin_init', 'simply_silverlight_build_admin_page');

// add shortcode handler
add_shortcode('simply-silverlight', 'simply_silverlight_shortcode_handler');

// activation function
function simply_silverlight_activate() {
	// check version compatibility
	global $wp_version;	
	$exit_msg='Simply Silverlight requires WordPress 3.0 or later. Please update.';
	
	if (version_compare($wp_version, "3.0", "<"))	{
		exit($exit_msg);
	}
	
	// set default options	
	$options = array('path'             => '/ClientBin/',
                     'width'            => '400',
                     'height'           => '300',
                     'display'          => 'inline',
                     'float'            => 'left',
                     'style'            => '',
                     'background'       => 'white',
                     'version'          => '4.0.60531.0',
                     'autoupgrade'      => 'true',
					 'preservesettings' => 'true');
    
	add_option('simply-silverlight-settings', $options);
}

// deactivation function
function simply_silverlight_deactivate() {
	$options = get_option('simply-silverlight-settings');
	if ($options['preservesettings'] == 'false') {
		delete_option('simply-silverlight-settings');
	}
}

// load textdomain
function simply_silverlight_load_textdomain() {
	$plugin_path = plugin_basename(dirname(__FILE__).'/languages');
	load_plugin_textdomain('simply-silverlight', false, $plugin_path);
}

// create admin menu under plugins page
function simply_silverlight_add_admin_menu() {
	add_submenu_page('plugins.php', __('Simply Silverlight Settings', 'simply-silverlight'), __('Simply Silverlight', 'simply-silverlight'), 'manage_options', 'simply_silverlight', 'simply_silverlight_settings_html');	
}

// register settings group and build admin page
function simply_silverlight_build_admin_page() {
	// register settings group and add validation function
	register_setting('simply-silverlight-settings-group', 'simply-silverlight-settings', 'simply_silverlight_validate_options');
	
	// add main settings section
	add_settings_section('main', '', '', 'simply_silverlight');
	
	// add settings fields to main section	
	add_settings_field('simply-silverlight-settings[path]', __('Path','simply-silverlight'), 'simply_silverlight_path_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[path]'));	
	add_settings_field('simply-silverlight-settings[width]', __('Width','simply-silverlight'), 'simply_silverlight_width_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[width]'));
	add_settings_field('simply-silverlight-settings[height]', __('Height','simply-silverlight'), 'simply_silverlight_height_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[height]'));
	add_settings_field('simply-silverlight-settings[background]', __('Background','simply-silverlight'), 'simply_silverlight_background_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[background]'));
	add_settings_field('simply-silverlight-settings[display]', __('CSS Display','simply-silverlight'), 'simply_silverlight_display_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[display]'));
	add_settings_field('simply-silverlight-settings[float]', __('CSS Float','simply-silverlight'), 'simply_silverlight_float_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[float]'));
	add_settings_field('simply-silverlight-settings[style]', __('CSS Style','simply-silverlight'), 'simply_silverlight_style_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[style]'));
	add_settings_field('simply-silverlight-settings[version]', __('Version','simply-silverlight'), 'simply_silverlight_version_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[version]'));
	add_settings_field('simply-silverlight-settings[autoupgrade]', __('Autoupgrade','simply-silverlight'), 'simply_silverlight_autoupgrade_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[autoupgrade]'));
	add_settings_field('simply-silverlight-settings[preservesettings]', __('Preserve Settings','simply-silverlight'), 'simply_silverlight_preservesettings_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[preservesettings]'));
}

// validate options
function simply_silverlight_validate_options($in) {
	// get current settings from database
	$options = get_option('simply-silverlight-settings');
	
	// copy only known settings to a new array; path, width and height will be validated
	$out['path']             = $options['path'];
	$out['width']            = $options['width'];
	$out['height']           = $options['height'];
	$out['background']       = $in['background'];
	$out['display']          = $in['display'];
	$out['float']            = $in['float'];
	$out['style']            = $in['style'];
	$out['version']          = $in['version'];
	$out['autoupgrade']      = $in['autoupgrade'];
	$out['preservesettings'] = $in['preservesettings'];

	// path must be a directory
	if (preg_match('/\.xap$/i', $in['path'])) {
		add_settings_error('Path', 'path-invalid', __('Path must be a directory.', 'simply-silverlight'), 'error');
		return $options;
	} else {
		$out['path'] = $in['path'];
	}

	// relative paths must begin with a /
	if (!preg_match('/^http:/i', $in['path']) && !preg_match('/^\//i', $in['path']) ) {
		add_settings_error('Path', 'path-invalid', __('Relative paths must begin with a "/".', 'simply-silverlight'), 'error');
		return $options;
	} else {
		$out['path'] = $in['path'];
	}

	// width
	if (!preg_match('/^[0-9]{1,4}$/i', $in['width'])) {
		add_settings_error('Width', 'width-invalid', __('Width must be a number not greater than 9999.', 'simply-silverlight'), 'error');
		return $options;
	} else {
		$out['width'] = $in['width'];
	}

	// height
	if (!preg_match('/^[0-9]{1,4}$/i', $in['height'])) {
		add_settings_error('Height', 'height-invalid', __('Height must be a number not greater than 9999.', 'simply-silverlight'), 'error');
		return $options;
	} else {
		$out['height'] = $in['height'];
	}

	// background default is white
	if (strlen($in['background']) == 0) {
		$out['background'] = 'white';
	}
	
	// return validated array
	return $out;
}

// shortcode handler
function simply_silverlight_shortcode_handler($atts) {
	// get current settings from database
	$options = get_option('simply-silverlight-settings');
	
	extract(shortcode_atts(array(
		'path'        => $options['path'],
		'width'       => $options['width'],
		'height'      => $options['height'],
		'display'     => $options['display'],
		'float'       => $options['float'],
		'style'       => $options['style'],
		'background'  => $options['background'],
		'version'     => $options['version'],
		'autoupgrade' => $options['autoupgrade'],
		'onerror'     => '',
		'initparams'  => '',
		'xap'         => ''		
	), $atts));

	// if initparams supplied wrap in a param element
	if (strlen($initparams) > 0) {
		$initparams = "<param name=\"initParams\" value=\"$initparams\" />";
	}
	
	// concatenate the display and float properties to the style attribute
	$style = "display:$display;float:$float;".ltrim($style, ';');

	// if onerror supplied wrap in a param element
	if (strlen($onerror) > 0) {
		$onerror = "<param name=\"onError\" value=\"$onerror\" />";
	}

	// ensure only a single slash exists between the $path and $xap
	$source = rtrim($path, '/').'/'.ltrim($xap, '/');

	// the html for the silverlight control
	$html = <<<EOT
		<div id="silverlightControlHost" style="$style">
	        <object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="$width" height="$height">
			  <param name="source" value="$source"/>
			  <param name="background" value="$background" />
			  <param name="minRuntimeVersion" value="$version" />
			  <param name="autoUpgrade" value="$autoupgrade" />
			  $initparams
			  $onerror
			  <a href="http://go.microsoft.com/fwlink/?LinkID=149156&v=$version" style="text-decoration:none">
	 			  <img src="http://go.microsoft.com/fwlink/?LinkId=161376" alt="Get Microsoft Silverlight" style="border-style:none"/>
			  </a>
		    </object>
		    <iframe id="_sl_historyFrame" style="visibility:hidden;height:0px;width:0px;border:0px"></iframe>
		</div>
EOT;
	return $html;
}
?>