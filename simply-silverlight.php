<?php
/*
	Plugin Name: Simply Silverlight
	Plugin URI: http://www.digitalwindfire.com/software/simply-silverlight
	Description: Bring the power of Microsoft's visually rich Silverlight technology to your WordPress site today! Simply Silverlight makes deploying Silverlight .xap files to your WordPress blog's posts and pages incredibly easy and intuitive. Don't hesitate, click Activate now!
	Version: 1.0.3
	Author: David Wright
	Author URI: http://www.digitalwindfire.com
	License: GPL2
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

// get current settings from database
$options = get_option('simply-silverlight-settings');

// verify settings exist in database and none are missing
if (!is_array($options)) {
	// install default settings	
	update_option('simply-silverlight-settings', simply_silverlight_default_settings());
} else {
	// check for missing settings
	$options['pluginversion'] = '1.0.2';
	if (!array_key_exists('path', $options))             {$options['path'] = '/ClientBin/';}
	if (!array_key_exists('securepath', $options))       {$options['securepath'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'secure'.DIRECTORY_SEPARATOR;}
	if (!array_key_exists('accesscontrol', $options))    {$options['accesscontrol'] = '';}
	if (!array_key_exists('width', $options))            {$options['width'] = '400';}
	if (!array_key_exists('height', $options))           {$options['height'] = '300';}
	if (!array_key_exists('display', $options))          {$options['display'] = 'inline';}
	if (!array_key_exists('float', $options))            {$options['float'] = 'left';}
	if (!array_key_exists('style', $options))            {$options['style'] = '';}
	if (!array_key_exists('background', $options))       {$options['background'] = 'white';}
	if (!array_key_exists('version', $options))          {$options['version'] = '4.0.60531.0';}
	if (!array_key_exists('autoupgrade', $options))      {$options['autoupgrade'] = 'true';}
	if (!array_key_exists('preservesettings', $options)) {$options['preservesettings'] = 'true';}	
	
	update_option('simply-silverlight-settings', $options);
}

// get default settings
function simply_silverlight_default_settings() {
	$options = array('pluginversion'    => '1.0.2',
	                 'path'             => '/ClientBin/',
					 'securepath'       => dirname(__FILE__).DIRECTORY_SEPARATOR.'secure'.DIRECTORY_SEPARATOR,
					 'accesscontrol'    => '',
                     'width'            => '400',
                     'height'           => '300',
                     'display'          => 'inline',
                     'float'            => 'left',
                     'style'            => '',
                     'background'       => 'white',
                     'version'          => '4.0.60531.0',
                     'autoupgrade'      => 'true',
					 'preservesettings' => 'true');
    
	return $options;
}

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

// add action for settings link
add_action('admin_menu', 'simply_silverlight_settings_action');

// add shortcode handler
add_shortcode('simply-silverlight', 'simply_silverlight_shortcode_handler');

// add filter for url variable
add_filter('query_vars', 'simply_silverlight_query_vars');

// add action to process .xap request
add_action('parse_request', 'simply_silverlight_parse_request');

// activation function
function simply_silverlight_activate() {
	// check version compatibility
	global $wp_version;	
	$exit_msg='Simply Silverlight requires WordPress 3.0 or later. Please update.';
	
	if (version_compare($wp_version, "3.0", "<"))	{
		exit($exit_msg);
	}
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
	add_settings_section('main', '', 'simply_silverlight_main_section_html', 'simply_silverlight');
	
	// add settings fields to main section	
	add_settings_field('simply-silverlight-settings[path]', __('Path','simply-silverlight'), 'simply_silverlight_path_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[path]'));
	add_settings_field('simply-silverlight-settings[securepath]', __('Secure Path','simply-silverlight'), 'simply_silverlight_securepath_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[securepath]'));
	add_settings_field('simply-silverlight-settings[accesscontrol]', __('Access Control','simply-silverlight'), 'simply_silverlight_accesscontrol_setting_html', 'simply_silverlight', 'main', array('label_for' => 'simply-silverlight-settings[accesscontrol]'));
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

// add filter to add settings link
function simply_silverlight_settings_action() {
	$plugin = plugin_basename(__FILE__); 
	add_filter('plugin_action_links_'.$plugin, 'simply_silverlight_settings_add');
}

// add settings link on plugins page
function simply_silverlight_settings_add($links) {
	$settings_link = '<a href="plugins.php?page=simply_silverlight" title="'.__('Configure settings for this plugin', 'simply_silverlight').'">'.__('Settings', 'simply_silverlight').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}

// validate options
function simply_silverlight_validate_options($in) {
    // reset plugin default settings
    if (isset($_POST["simply-silverlight-reset"])) {
      $_REQUEST["_wp_http_referer"] = add_query_arg("reset", "true", $_REQUEST["_wp_http_referer"]);
      return simply_silverlight_default_settings();
    }	
	
	// get current settings from database
	$options = get_option('simply-silverlight-settings');	
	
	// copy only known settings to a new array; path, securepath, width and height will be validated
	$out['pluginversion']    = $options['pluginversion'];
	$out['path']             = $options['path'];
	$out['securepath']       = $options['securepath'];	
	$out['width']            = $options['width'];
	$out['height']           = $options['height'];
	$out['accesscontrol']    = $in['accesscontrol'];
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

    // restore the default secure path
    if (trim(strtolower($in['securepath']), ' "') == 'default') {
        $in['securepath'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'secure'.DIRECTORY_SEPARATOR;
    }

	// warn if secure path doesn't exist
	if (strlen($in['securepath']) > 0) {
		if (!is_dir($in['securepath'])) {
			add_settings_error('Secure Path', 'securepath-invalid', __('Secure path does not exist.', 'simply-silverlight'), 'error');
			
			// allow the path to change even if it doesn't exist
			$options['securepath'] = $in['securepath'];
			
			return $options;
		} else {
			// resolve relative path to absolute
			$in['securepath'] = realpath($in['securepath']);
			
			// ensure the secure path ends with correct directory separator
			if (substr($in['securepath'], -1) != DIRECTORY_SEPARATOR) {
				$out['securepath'] = $in['securepath'].DIRECTORY_SEPARATOR;
			} else {
				$out['securepath'] = $in['securepath'];
			}
		}
	} else {
		// allow deletion of the secure path
		$out['securepath'] = $in['securepath'];
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
		'path'          => $options['path'],
		'securepath'    => $options['securepath'],
		'accesscontrol' => $options['accesscontrol'],
		'width'         => $options['width'],
		'height'        => $options['height'],
		'display'       => $options['display'],
		'float'         => $options['float'],
		'style'         => $options['style'],
		'background'    => $options['background'],
		'version'       => $options['version'],
		'autoupgrade'   => $options['autoupgrade'],
		'onerror'       => '',
		'initparams'    => '',
		'xap'           => '',
		'secure'        => ''		
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

	// set source .xap url
	if ($secure == 'true') {
	    $source = get_option('siteurl').'/index.php?simply-silverlight='.trim($xap, '/');
	} else {
		// ensure only a single slash exists between the $path and $xap
		$source = rtrim($path, '/').'/'.ltrim($xap, '/');
	}

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

// process request for .xap
function simply_silverlight_parse_request($wp) {
    // process requests for simply-silverlight
    if (array_key_exists('simply-silverlight', $wp->query_vars) && $wp->query_vars['simply-silverlight'] != '') {
		// .xap file requested
		$requested_xap = $wp->query_vars['simply-silverlight'];

		// get current settings from database
		$options = get_option('simply-silverlight-settings');

		// if user isn't logged in exit function
		if (!is_user_logged_in()) {
			wp_die('There was a problem with the request.');
		}
		
		// default authentication
		$authenticated = true;
		
		// determine if requested .xap has an acl
		if (preg_match("/$requested_xap\((.*?)\)/i", $options['accesscontrol'], $matches)) {
			// change default authentication to false
			$authenticated = false;
			
			// get acl
			$acl = explode(',', strtolower($matches[1]));

			// current user login and roles
			global $current_user;
			global $user_login;
			get_currentuserinfo();
			$roles = $current_user->roles;			
			
			// check user login
			if (in_array(strtolower($user_login), $acl)) {
				$authenticated = true;
			} else {
				// if user login fails, check roles
				if (!$authenticated) {
					foreach($roles as $role) {
						if (in_array(strtolower($role), $acl)) {
							$authenticated = true;
							break;
						}
					}				
				}
			}
		}
		
		// if authenticated send the .xap
		if ($authenticated) {
			$filename = $options['securepath'].$requested_xap;

			if (file_exists($filename)) {
				$len = filesize($filename);
				header("Content-Length: $len");
				header("Content-Type: application/x-silverlight-app");
				header("Content-Disposition: attachment; filename=\"$requested_xap\"");
				readfile($filename);
				ob_end_flush();
			} else {
                wp_die(__('The requested file does not exist.', 'simply-silverlight'));
		    }
		} else {
			wp_die(__('There was a problem with the request.', 'simply-silverlight'));
		}
    }
}

// process url variable
function simply_silverlight_query_vars($vars) {
    $vars[] = 'simply-silverlight';
    return $vars;
}
?>