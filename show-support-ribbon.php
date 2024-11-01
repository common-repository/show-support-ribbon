<?php 
/*
	Plugin Name: Show Support Ribbon
	Plugin URI: https://perishablepress.com/show-support-ribbon/
	Description: Displays a customizable "show support" ribbon, banner, or badge on your site.
	Tags: badge, banner, button, ribbon, support
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: https://monzillamedia.com/donate.html
	Contributors: specialk
	Requires at least: 4.6
	Tested up to: 6.7
	Stable tag: 20241010
	Version:    20241010
	Requires PHP: 5.6.20
	Text Domain: show-support-ribbon
	Domain Path: /languages
	License: GPL v2 or later
*/

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 
	2 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	with this program. If not, visit: https://www.gnu.org/licenses/
	
	Copyright 2024 Monzilla Media. All rights reserved.
*/

if (!defined('ABSPATH')) die();

$ssr_wp_vers = '4.6';
$ssr_version = '20241010';
$ssr_plugin  = esc_html__('Show Support Ribbon', 'show-support-ribbon');
$ssr_options = get_option('ssr_options');
$ssr_path    = plugin_basename(__FILE__); // 'show-support-ribbon/show-support-ribbon.php';
$ssr_homeurl = 'https://perishablepress.com/show-support-ribbon/';

function ssr_i18n_init() {
	global $ssr_path;
	load_plugin_textdomain('show-support-ribbon', false, dirname($ssr_path) .'/languages/');
}
add_action('init', 'ssr_i18n_init');

function ssr_require_wp_version() {
	global $ssr_path, $ssr_plugin, $ssr_wp_vers;
	if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
		$wp_version = get_bloginfo('version');
		if (version_compare($wp_version, $ssr_wp_vers, '<')) {
			if (is_plugin_active($ssr_path)) {
				deactivate_plugins($ssr_path);
				$msg =  '<strong>' . $ssr_plugin . '</strong> ' . esc_html__('requires WordPress ', 'show-support-ribbon') . $ssr_wp_vers . esc_html__(' or higher, and has been deactivated!', 'show-support-ribbon') . '<br />';
				$msg .= esc_html__('Please return to the', 'show-support-ribbon') . ' <a href="' . admin_url() . '">' . esc_html__('WordPress Admin area', 'show-support-ribbon') . '</a> ' . esc_html__('to upgrade WordPress and try again.', 'show-support-ribbon');
				wp_die($msg);
			}
		}
	}
}
add_action('admin_init', 'ssr_require_wp_version');

function ssr_footer_text($text) {
	
	$screen_id = ssr_get_current_screen_id();
	
	$ids = array('settings_page_show-support-ribbon/show-support-ribbon');
	
	if ($screen_id && apply_filters('dashboard_widgets_suite_admin_footer_text', in_array($screen_id, $ids))) {
		
		$text = __('Like this plugin? Give it a', 'show-support-ribbon');
		
		$text .= ' <a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/show-support-ribbon/reviews/?rate=5#new-post">';
		
		$text .= __('★★★★★ rating&nbsp;&raquo;', 'show-support-ribbon') .'</a>';
		
	}
	
	return $text;
	
}
add_filter('admin_footer_text', 'ssr_footer_text', 10, 1);

function ssr_get_current_screen_id() {
	
	if (!function_exists('get_current_screen')) require_once ABSPATH .'/wp-admin/includes/screen.php';
	
	$screen = get_current_screen();
	
	if ($screen && property_exists($screen, 'id')) return $screen->id;
	
	return false;
	
}

function ssr_display_ribbon() {
	
	global $ssr_options;
	
	$enable    = isset($ssr_options['ssr_enable']) ? $ssr_options['ssr_enable'] : false;
	$style     = isset($ssr_options['ssr_style'])  ? $ssr_options['ssr_style']  : 'ssr_ribbon';
	$href      = isset($ssr_options['ssr_href'])   ? $ssr_options['ssr_href']   : '';
	$title     = isset($ssr_options['ssr_title'])  ? $ssr_options['ssr_title']  : '';
	$link      = isset($ssr_options['ssr_link'])   ? $ssr_options['ssr_link']   : '';
	$blank     = isset($ssr_options['ssr_blank'])  ? $ssr_options['ssr_blank']  : false;
	$home_only = isset($ssr_options['home_only'])  ? $ssr_options['home_only']  : false;
	
	$blank = $blank ? 'target="_blank" rel="noopener noreferrer"' : '';
	
	if ($home_only && !is_home() && !is_front_page()) return;
	
	if ($enable == true && ssr_check_display_ribbon()) {
		
		if ($style == 'ssr_custom') {
			
			$markup   = isset($ssr_options['ssr_markup']) ? $ssr_options['ssr_markup'] : ssr_custom_markup_default();
			$css_div  = isset($ssr_options['ssr_outer'])  ? $ssr_options['ssr_outer']  : '';
			$css_link = isset($ssr_options['ssr_inner'])  ? $ssr_options['ssr_inner']  : '';
			
			$markup = str_replace("{{css_div}}", $css_div,  $markup);
			$markup = str_replace("{{css_a}}",   $css_link, $markup);
			$markup = str_replace("{{url}}",     $href,     $markup);
			$markup = str_replace("{{title}}",   $title,    $markup);
			$markup = str_replace("{{text}}",    $link,     $markup);
			
			return $markup;
			
		} else {
			
			if ($style == 'ssr_badge') {
				
				$css_div  = 'position:fixed;right:5px;top:5px;z-index:9999;';
				$css_link = 'box-sizing:border-box;display:table-cell;vertical-align:middle;width:92px;height:92px;padding:5px;color:#fff;background:rgba(102,153,204,.7);line-height:16px;font-size:12px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',\'Lucida Sans\',Geneva,Verdana,sans-serif;text-align:center;text-decoration:none;font-weight:700;border:2px solid #efefef;border-radius:50%;box-shadow:1px 1px 3px 0 rgba(0,0,0,.3);';
				
			} elseif ($style == 'ssr_banner') {
				
				$css_div  = 'position:fixed;right:5px;top:5px;z-index:9999;';
				$css_link = 'box-sizing:border-box;display:inline-block;padding:10px 20px;color:rgba(51,102,153,.9);background:rgba(255,255,255,.9);font-size:12px;line-height:16px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',\'Lucida Sans\',Geneva,Verdana,sans-serif;text-align:center;text-decoration:none;font-weight:700;border:1px solid rgba(102,153,204,.7);border-radius:3px;box-shadow:1px 1px 3px 0 rgba(0,0,0,.3);';
				
			} elseif ($style == 'ssr_ribbon') {
				
				$css_div  = 'position:fixed;right:-60px;top:20px;z-index:9999;';
				$css_link = 'box-sizing:border-box;display:block;width:200px;padding:10px 0;color:#fff;background:rgba(102,153,204,.9);font-size:12px;line-height:16px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',\'Lucida Sans\',Geneva,Verdana,sans-serif;text-align:center;text-decoration:none;border:1px solid rgba(255,255,255,.7);transform:rotate(40deg);box-shadow:1px 1px 3px 0 rgba(0,0,0,.3);';
				
			} else {
				
				$css_div  = 'position:fixed;right:10px;top:5px;z-index:9999;';
				$css_link = 'line-height:16px;font-size:12px;';
				
			}
			
			return "\n" .'<div id="show-support-ribbon" class="show-support-ribbon" style="'. $css_div .'"><a href="'. $href .'" title="'. $title .'" '. $blank .' style="'. $css_link .'">'. $link .'</a></div>'. "\n\n";
			
		}
		
	}
	
}

function ssr_add_custom_styles() {
	global $ssr_options;
	$custom_stylez = isset($ssr_options['ssr_styles']) ? $ssr_options['ssr_styles'] : '';
	$custom_stylez = $custom_stylez ? "\n" .'<style type="text/css">'. $custom_stylez .'</style>' : '';
	echo $custom_stylez;
}
add_action('wp_head', 'ssr_add_custom_styles', 100);

function ssr_check_display_ribbon() {
	
	global $ssr_options;
	
	$display_url = isset($ssr_options['ssr_urls']) ? $ssr_options['ssr_urls'] : null;
	
	$protocol = is_ssl() ? 'https://' : 'http://';
	
	$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'undefined';
	
	$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/na';
	
	$current_url = esc_url_raw($protocol . $http_host . $request_uri);
	
	$display = false;
	
	if (!empty($display_url)) {
		
		$display_urls = explode(',', $display_url);
		
		foreach ($display_urls as $url) {
			
			$url = esc_url_raw(trim($url));
			
			if ($url === $current_url) {
				
				$display = true;
				
			}
			
		}
		
	} else {
		
		$display = true;
		
	}
	
	return $display;
	
}

function ssr_enable_display_ribbon() {
	echo ssr_display_ribbon();
}
add_action('wp_footer', 'ssr_enable_display_ribbon');

function ssr_shortcode() {
	return ssr_display_ribbon();
}
add_shortcode('show_support_ribbon','ssr_shortcode');

function show_support_ribbon() {
	echo ssr_display_ribbon();
}

function ssr_plugin_action_links($links, $file) {
	global $ssr_path;
	if ($file == $ssr_path && (current_user_can('manage_options'))) {
		$ssr_links = '<a href="' . get_admin_url() . 'options-general.php?page=' . $ssr_path . '">' . esc_html__('Settings', 'show-support-ribbon') .'</a>';
		array_unshift($links, $ssr_links);
	}
	return $links;
}
add_filter ('plugin_action_links', 'ssr_plugin_action_links', 10, 2);

function add_ssr_links($links, $file) {
	global $ssr_path;
	if ($file === $ssr_path) {
		
		$home_href  = 'https://perishablepress.com/show-support-ribbon/';
		$home_title = esc_attr__('Plugin Homepage', 'show-support-ribbon');
		$home_text  = esc_html__('Homepage', 'show-support-ribbon');
		
		$links[] = '<a target="_blank" rel="noopener noreferrer" href="'. $home_href .'" title="'. $home_title .'">'. $home_text .'</a>';
		
		$rate_href  = 'https://wordpress.org/support/plugin/show-support-ribbon/reviews/?rate=5#new-post';
		$rate_title = esc_html__('Give us a 5-star rating at WordPress.org', 'show-support-ribbon');
		$rate_text  = esc_html__('Rate this plugin', 'show-support-ribbon') .'&nbsp;&raquo;';
		
		$links[] = '<a target="_blank" rel="noopener noreferrer" href="'. $rate_href .'" title="'. $rate_title .'">'. $rate_text .'</a>';
		
	}
	return $links;
}
add_filter('plugin_row_meta', 'add_ssr_links', 10, 2);

function ssr_delete_plugin_options() {
	delete_option('ssr_options');
}
if (isset($tmp['default_options']) && $ssr_options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'ssr_delete_plugin_options');
}

function ssr_add_defaults() {
	$tmp = get_option('ssr_options');
	if ((isset($tmp['default_options']) && $tmp['default_options'] == '1') || (!is_array($tmp))) {
		$arr = array(
			'default_options' => 0,
			'ssr_enable'      => 0,
			'ssr_style'       => 'ssr_ribbon',
			'ssr_markup'      => ssr_custom_markup_default(),
			'ssr_outer'       => 'position:fixed;right:5px;top:5px;z-index:9999;',
			'ssr_inner'       => 'box-sizing:border-box;display:inline-block;padding:10px 20px;color:rgba(51,102,153,.9);background:rgba(255,255,255,.9);font-size:12px;line-height:16px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',\'Lucida Sans\',Geneva,Verdana,sans-serif;text-align:center;text-decoration:none;font-weight:700;border:1px solid rgba(102,153,204,.7);border-radius:3px;box-shadow:1px 1px 3px 0 rgba(0,0,0,.3);',
			'ssr_styles'      => '',
			'ssr_href'        => 'https://example.com/',
			'ssr_title'       => 'Your event here!',
			'ssr_link'        => 'Show Support!',
			'ssr_blank'       => 1,
			'ssr_urls'        => '',
			'home_only'       => 0
		);
		update_option('ssr_options', $arr);
	}
}
register_activation_hook (__FILE__, 'ssr_add_defaults');

function ssr_custom_markup_default() {
	
	return '<div id="show-support-ribbon" class="show-support-ribbon" style="{{css_div}}"><a target="_blank" rel="noopener noreferrer" href="{{url}}" title="{{title}}" style="{{css_a}}">{{text}}</a></div>';
	
}

function ssr_display_styles() {
	
	return array(
		'ssr_badge'  => array(
			'value' => 'ssr_badge',
			'label' => __('Badge', 'show-support-ribbon')
		),
		'ssr_banner' => array(
			'value' => 'ssr_banner',
			'label' => __('Banner', 'show-support-ribbon')
		),
		'ssr_ribbon' => array(
			'value' => 'ssr_ribbon',
			'label' => __('Ribbon', 'show-support-ribbon')
		),
		'ssr_link'   => array(
			'value' => 'ssr_link',
			'label' => __('Link', 'show-support-ribbon')
		),
		'ssr_custom' => array(
			'value' => 'ssr_custom',
			'label' => __('Custom', 'show-support-ribbon')
		)
	);
}

function ssr_init() {
	register_setting('ssr_plugin_options', 'ssr_options', 'ssr_validate_options');
}
add_action ('admin_init', 'ssr_init');

function ssr_validate_options($input) {

	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);

	if (!isset($input['ssr_enable'])) $input['ssr_enable'] = null;
	$input['ssr_enable'] = ($input['ssr_enable'] == '1' ? '1' : '0');

	if (!isset($input['ssr_blank'])) $input['ssr_blank'] = null;
	$input['ssr_blank'] = ($input['ssr_blank'] == '1' ? '1' : '0');

	if (!isset($input['ssr_style'])) $input['ssr_style'] = null;
	if (!array_key_exists($input['ssr_style'], ssr_display_styles())) $input['ssr_style'] = null;
	
	if (isset($input['ssr_markup'])) $input['ssr_markup'] = stripslashes_deep($input['ssr_markup']);
	
	if (isset($input['ssr_outer']))  $input['ssr_outer']  = wp_strip_all_tags($input['ssr_outer']);  else $input['ssr_outer']  = null;
	if (isset($input['ssr_inner']))  $input['ssr_inner']  = wp_strip_all_tags($input['ssr_inner']);  else $input['ssr_inner']  = null;
	if (isset($input['ssr_styles'])) $input['ssr_styles'] = wp_strip_all_tags($input['ssr_styles']); else $input['ssr_styles'] = null;
	if (isset($input['ssr_urls']))   $input['ssr_urls']   = wp_strip_all_tags($input['ssr_urls']);   else $input['ssr_urls']   = null;
	
	if (isset($input['ssr_href']))  $input['ssr_href']  = esc_attr($input['ssr_href']);  else $input['ssr_href']  = null;
	if (isset($input['ssr_title'])) $input['ssr_title'] = esc_attr($input['ssr_title']); else $input['ssr_title'] = null;
	if (isset($input['ssr_link']))  $input['ssr_link']  = esc_attr($input['ssr_link']);  else $input['ssr_link']  = null;
	
	if (!isset($input['home_only'])) $input['home_only'] = null;
	$input['home_only'] = ($input['home_only'] == 1 ? 1 : 0);
	
	return $input;
}

function ssr_add_options_page() {
	global $ssr_plugin;
	add_options_page($ssr_plugin, esc_html__('Support Ribbon', 'show-support-ribbon'), 'manage_options', __FILE__, 'ssr_render_form');
}
add_action ('admin_menu', 'ssr_add_options_page');

function ssr_render_form() {
	global $ssr_plugin, $ssr_options, $ssr_path, $ssr_homeurl, $ssr_version; ?>

	<style type="text/css">
		#mm-plugin-options .mm-panel-overview {
			padding: 0 15px 15px 175px;
			background: url(<?php echo plugins_url(); ?>/show-support-ribbon/ssr-logo.png);
			background-repeat: no-repeat; background-position: 15px 0; background-size: 160px 121px;
			}
		#mm-plugin-options .mm-panel-toggle { margin: 5px 0; }
		#mm-plugin-options .mm-credit-info { margin: -10px 0 10px 5px; font-size: 12px; }
		#mm-plugin-options .button-primary { margin: 0 0 15px 15px; }
		
		#mm-plugin-options #setting-error-settings_updated { margin: 5px 0 15px 0; }
		#mm-plugin-options #setting-error-settings_updated p { margin: 7px 0 6px 0; }
		
		#mm-plugin-options .mm-table-wrap { margin: 15px; }
		#mm-plugin-options .mm-table-wrap td { padding: 5px 10px; vertical-align: middle; }
		#mm-plugin-options .mm-table-wrap .mm-table { padding: 10px 0; }
		#mm-plugin-options .mm-table-wrap .widefat th { padding: 10px 15px; vertical-align: middle; }
		#mm-plugin-options .mm-table-wrap .widefat td { padding: 10px; vertical-align: middle; }
		
		#mm-plugin-options h1 small { line-height: 12px; font-size: 12px; color: #bbb; }
		#mm-plugin-options h2 { margin: 0; padding: 12px 0 12px 15px; font-size: 16px; cursor: pointer; }
		#mm-plugin-options h3 { margin: 20px 15px; font-size: 14px; }
		#mm-plugin-options p { margin-left: 15px; }
		#mm-plugin-options ul { margin: 15px 15px 25px 40px; line-height: 16px; }
		#mm-plugin-options li { margin: 8px 0; list-style-type: disc; }
		
		#mm-plugin-options textarea { width: 80%; }
		#mm-plugin-options input[type=text] { width: 60%; }
		#mm-plugin-options input[type=checkbox] { margin-top: -3px; }
		#mm-plugin-options .mm-radio-inputs { margin: 5px 0; }
		#mm-plugin-options .mm-code {  margin: 0 1px; padding: 5px; background-color: #fafae0; color: #333; font-size: 14px; font-family: monospace; }
		
		#mm-plugin-options .mm-item-caption { margin: 3px 0 0 3px; line-height: 17px; font-size: 12px; color: #777; }
		#mm-plugin-options .mm-item-caption code { margin: 0; padding: 3px; font-size: 12px; background: #f2f2f2; background-color: rgba(0,0,0,0.05); }
		#mm-plugin-options .mm-item-caption-nomargin { margin: 0; }
		#mm-plugin-options textarea + .mm-item-caption { margin: 0 0 0 3px; }
		
		#mm-plugin-options .mm-code-example { margin: 10px 0 20px 0; }
		#mm-plugin-options .mm-code-example div { margin: 0 0 15px 15px; }
		#mm-plugin-options .mm-code-example code { padding: 5px; background-color: #fafae0; color: #555; font-size: 14px; }
		
		#mm-plugin-options pre { padding: 10px 5px; line-height: 18px; font-size: 12px; }
		#mm-plugin-options #mm-panel-tertiary pre { margin: 10px 0 20px 30px; }
		#mm-plugin-options #mm-panel-tertiary hr { width: 97%; margin: 25px auto; }
		#mm-plugin-options .mm-example-heading { margin-left: 15px; }
		#mm-plugin-options .mm-example-heading code { font-size: 13px; }
		
		#mm-plugin-options .mm-custom-style { background-color: #efefef; }
		#mm-plugin-options .mm-custom-style pre { margin: 10px 0 0 0; text-shadow: 1px 1px 1px rgba(255,255,255,0.5); }
		#mm-plugin-options .mm-custom-style label code { font-size: 13px; }
		
		@media (max-width: 1000px) {
			#mm-plugin-options input[type=text] { width: 80%; }
			#mm-plugin-options textarea { width: 90%; }
		}
		@media (max-width: 782px) {
			#mm-plugin-options .mm-radio-inputs { margin: 10px 0; }
		}
		@media (max-width: 600px) {
			#mm-plugin-options input[type=text], 
			#mm-plugin-options textarea { width: 98%; }
		}
	</style>

	<div id="mm-plugin-options" class="wrap">
		<h1><?php echo $ssr_plugin; ?> <small><?php echo 'v' . $ssr_version; ?></small></h1>
		<div class="mm-panel-toggle"><a href="<?php get_admin_url() . 'options-general.php?page=' . $ssr_path; ?>"><?php esc_html_e('Toggle all panels', 'show-support-ribbon'); ?></a></div>

		<form method="post" action="options.php">
			<?php $ssr_options = get_option('ssr_options'); settings_fields('ssr_plugin_options'); ?>

			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">
					
					<div id="mm-panel-overview" class="postbox">
						<h2><?php esc_html_e('Overview', 'show-support-ribbon'); ?></h2>
						<div class="toggle<?php if (isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<div class="mm-panel-overview">
								<p>
									<strong><?php echo $ssr_plugin; ?></strong> <?php esc_html_e('(SSR) displays a custom support ribbon on your site. SSR includes four built-in display styles: badge, banner, ribbon, or link.', 'show-support-ribbon'); ?>
									<?php esc_html_e('SSR also includes the option to use your own custom CSS to style the ribbon and position it anywhere on the page. See the "Customization Tips" panel for more information.', 'show-support-ribbon'); ?>
									<?php esc_html_e('Optionally you may use the shortcode to display the ribbon on any post or page, or use the template tag to display the ribbon anywhere in your theme template.', 'show-support-ribbon'); ?>
								</p>
								<ul>
									<li><a id="mm-panel-primary-link" href="#mm-panel-primary"><?php esc_html_e('Plugin Settings', 'show-support-ribbon'); ?></a></li>
									<li><a id="mm-panel-secondary-link" href="#mm-panel-secondary"><?php esc_html_e('Shortcodes &amp; Template Tags', 'show-support-ribbon'); ?></a></li>
									<li><a id="mm-panel-tertiary-link" href="#mm-panel-tertiary"><?php esc_html_e('Customization Tips', 'show-support-ribbon'); ?></a></li>
									<li><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/show-support-ribbon/"><?php esc_html_e('Plugin Homepage', 'show-support-ribbon'); ?></a></li>
								</ul>
								<p>
									<?php esc_html_e('If you like this plugin, please', 'show-support-ribbon'); ?> 
									<a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/show-support-ribbon/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'show-support-ribbon'); ?>"><?php esc_html_e('give it a 5-star rating', 'show-support-ribbon'); ?>&nbsp;&raquo;</a>
								</p>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-primary" class="postbox">
						<h2><?php esc_html_e('Plugin Settings', 'show-support-ribbon'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p><?php esc_html_e('Here you may enable and configure the plugin. Note: select the "Custom" style to reveal more options.', 'show-support-ribbon'); ?></p>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_enable]"><?php esc_html_e('Display the ribbon?', 'show-support-ribbon'); ?></label></th>
										<td><input type="checkbox" name="ssr_options[ssr_enable]" value="1" <?php if (isset($ssr_options['ssr_enable'])) { checked('1', $ssr_options['ssr_enable']); } ?> /> 
										<?php esc_html_e('Check the box to display the ribbon on your site.', 'show-support-ribbon'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[home_only]"><?php esc_html_e('Limit to home page?', 'show-support-ribbon'); ?></label></th>
										<td><input type="checkbox" name="ssr_options[home_only]" value="1" <?php if (isset($ssr_options['home_only'])) { checked('1', $ssr_options['home_only']); } ?> /> 
										<?php esc_html_e('Check the box to limit display of the ribbon to the home page.', 'show-support-ribbon'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_blank]"><?php esc_html_e('Open ribbon link in new tab?', 'show-support-ribbon'); ?></label></th>
										<td><input type="checkbox" name="ssr_options[ssr_blank]" value="1" <?php if (isset($ssr_options['ssr_blank'])) { checked('1', $ssr_options['ssr_blank']); } ?> /> 
										<?php esc_html_e('Check the box to open the ribbon link in a new tab. Or, leave unchecked to open in same tab.', 'show-support-ribbon'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_style]"><?php esc_html_e('Select your style', 'show-support-ribbon'); ?></label></th>
										<td>
											<?php if (!isset($checked)) $checked = '';
												foreach (ssr_display_styles() as $ssr_display_style) {
													$radio_setting = $ssr_options['ssr_style'];
													if ('' != $radio_setting) {
														if ($ssr_options['ssr_style'] == $ssr_display_style['value']) {
															$checked = "checked=\"checked\"";
														} else {
															$checked = '';
														}
													} ?>
													<div class="mm-radio-inputs">
														<input type="radio" name="ssr_options[ssr_style]" value="<?php echo esc_attr($ssr_display_style['value']); ?>" <?php echo $checked; ?> /> 
														<?php echo $ssr_display_style['label']; ?>
													</div>
											<?php } ?>
										</td>
									</tr>
									<tr class="mm-custom-style">
										<th scope="row"><label class="description" for="ssr_options[ssr_markup]"><?php esc_html_e('Markup', 'show-support-ribbon'); ?></label></th>
										<td><textarea class="textarea large-text code" rows="7" cols="55" name="ssr_options[ssr_markup]"><?php $default_markup = ssr_custom_markup_default(); if (isset($ssr_options['ssr_markup'])) echo esc_textarea($ssr_options['ssr_markup']); else echo esc_textarea($default_markup); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('You may use the following shortcodes:', 'show-support-ribbon'); ?> 
										<code>{{css_div}}</code>, <code>{{css_a}}</code>, <code>{{url}}</code>, <code>{{title}}</code>, <code>{{text}}</code></div></td>
									</tr>
									<tr class="mm-custom-style">
										<th scope="row"><label class="description" for="ssr_options[ssr_outer]"><?php esc_html_e('CSS for', 'show-support-ribbon'); ?> <code>&lt;div&gt;</code></label></th>
										<td><textarea class="textarea large-text code" rows="7" cols="55" name="ssr_options[ssr_outer]"><?php echo esc_textarea($ssr_options['ssr_outer']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Custom CSS for the', 'show-support-ribbon'); ?> <code>&lt;div&gt;</code> <?php esc_html_e('tag', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr class="mm-custom-style">
										<th scope="row"><label class="description" for="ssr_options[ssr_inner]"><?php esc_html_e('CSS for', 'show-support-ribbon'); ?> <code>&lt;a&gt;</code></label></th>
										<td><textarea class="textarea large-text code" rows="7" cols="55" name="ssr_options[ssr_inner]"><?php echo esc_textarea($ssr_options['ssr_inner']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Custom CSS for the', 'show-support-ribbon'); ?> <code>&lt;a&gt;</code> <?php esc_html_e('tag', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr class="mm-custom-style">
										<th scope="row"><label class="description" for="ssr_options[ssr_styles]"><?php esc_html_e('Other/general CSS', 'show-support-ribbon'); ?></label></th>
										<td><textarea class="textarea large-text code" rows="7" cols="55" name="ssr_options[ssr_styles]"><?php echo esc_textarea($ssr_options['ssr_styles']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Any other CSS that you want to add (do not include style tags or other markup)', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_href]"><?php esc_html_e('Link URL', 'show-support-ribbon'); ?></label></th>
										<td><input type="text" size="50" maxlength="1000" name="ssr_options[ssr_href]" value="<?php echo $ssr_options['ssr_href']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Enter the URL that should be used for the ribbon link', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_title]"><?php esc_html_e('Link title', 'show-support-ribbon'); ?></label></th>
										<td><input type="text" size="50" maxlength="1000" name="ssr_options[ssr_title]" value="<?php echo $ssr_options['ssr_title']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Enter the title that should be used for the ribbon link', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_link]"><?php esc_html_e('Link text', 'show-support-ribbon'); ?></label></th>
										<td><input type="text" size="50" maxlength="1000" name="ssr_options[ssr_link]" value="<?php echo $ssr_options['ssr_link']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Enter the anchor text that should be used for the ribbon link', 'show-support-ribbon'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="ssr_options[ssr_urls]"><?php esc_html_e('Targeted Display', 'show-support-ribbon'); ?></label></th>
										<td><input type="text" size="50" maxlength="10000" name="ssr_options[ssr_urls]" value="<?php echo $ssr_options['ssr_urls']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Limit display of ribbon to these URLs (separate URLs with commas)', 'show-support-ribbon'); ?></div></td>
									</tr>
								</table>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'show-support-ribbon'); ?>" />
						</div>
					</div>
					
					<div id="mm-panel-secondary" class="postbox">
						<h2><?php esc_html_e('Shortcode &amp; Template Tag', 'show-support-ribbon'); ?></h2>
						<div class="toggle default-hidden">
							<div class="mm-code-example">
								<h3><?php esc_html_e('Shortcode', 'show-support-ribbon'); ?></h3>
								<div><?php esc_html_e('Display the ribbon on any post or page:', 'show-support-ribbon'); ?></div>
								<div><span class="mm-code">[show_support_ribbon]</span></div>

								<h3><?php esc_html_e('Template tag', 'show-support-ribbon'); ?></h3>
								<div><?php esc_html_e('Display the ribbon anywhere in your theme:', 'show-support-ribbon'); ?></div>
								<div><span class="mm-code">&lt;?php if (function_exists('show_support_ribbon')) show_support_ribbon(); ?&gt;</span></div>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-tertiary" class="postbox">
						<h2><?php esc_html_e('Customization Tips', 'show-support-ribbon'); ?></h2>
						<div class="toggle default-hidden">
							
							<p><?php esc_html_e('For those new to styling HTML with CSS, here are some recipes and tips.', 'show-support-ribbon'); ?></p>
							
							<ul>
								<li>
									<strong><?php _e('Location', 'show-support-ribbon'); ?></strong> &mdash; 
									<?php _e('For the', 'show-support-ribbon'); ?> <code>&lt;div&gt;</code>, <?php _e('use', 'show-support-ribbon'); ?> <code>position:fixed;</code> 
									<?php _e('and then specify the location with something like', 'show-support-ribbon'); ?> <code>right:0; bottom:5px;</code>.
								</li>
								<li>
									<strong><?php _e('Structural styles', 'show-support-ribbon'); ?></strong> &mdash; 
									<?php _e('Apply structural styles such as', 'show-support-ribbon'); ?> <code>margin</code>, <code>width</code>, 
									<?php _e('and', 'show-support-ribbon'); ?> <code>height</code> <?php _e('to the block-level element', 'show-support-ribbon'); ?>, <code>&lt;div&gt;</code>.
								</li>
								<li>
									<strong><?php _e('Aesthetic styles', 'show-support-ribbon'); ?></strong> &mdash; 
									<?php _e('Apply aesthetic styles such as', 'show-support-ribbon'); ?> <code>padding</code>, <code>color</code>, 
									<?php _e('and', 'show-support-ribbon'); ?> <code>font-family</code> <?php _e('to the inline-level element', 'show-support-ribbon'); ?>, <code>&lt;a&gt;</code>.
								</li>
								<li>
									<strong><?php _e('Recipes', 'show-support-ribbon'); ?></strong> &mdash; 
									<?php _e('Using the recipes below as Custom CSS, you can change the position, size, and color of the ribbon. And much more if you get creative', 'show-support-ribbon'); ?> ;)
								</li>
							</ul>
							
							<hr>
							
							<div class="mm-example-heading"><strong><?php _e('Badge', 'show-support-ribbon'); ?></strong> <code>&lt;div&gt;</code></div>
							<ul>
								<li><?php _e('Display top left:', 'show-support-ribbon'); ?> <code>position:fixed; left:5px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display top right:', 'show-support-ribbon'); ?> <code>position:fixed; right:5px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom left:', 'show-support-ribbon'); ?> <code>position:fixed; left:5px; bottom:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom right:', 'show-support-ribbon'); ?> <code>position:fixed; right:5px; bottom:5px; z-index:9999;</code></li>
							</ul>
							
							<div class="mm-example-heading"><strong><?php _e('Badge', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code></div>
<pre>display:block; width:88px; height:88px; color:#fff; background:rgba(102,153,204,0.7); 
font-size:11px; text-align:center; line-height:88px; text-decoration:none; font-weight:bold; 
border:2px solid #efefef; border-radius:99px; box-shadow:1px 1px 3px 0 rgba(0,0,0,0.3);</pre>

							<hr>
							
							<div class="mm-example-heading"><strong><?php _e('Banner', 'show-support-ribbon'); ?></strong> <code>&lt;div&gt;</code></div>
							<ul>
								<li><?php _e('Display top left:', 'show-support-ribbon'); ?> <code>position:fixed; left:-2px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display top right:', 'show-support-ribbon'); ?> <code>position:fixed; right:-2px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom left:', 'show-support-ribbon'); ?> <code>position:fixed; left:-2px; bottom:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom right:', 'show-support-ribbon'); ?> <code>position:fixed; right:-2px; bottom:5px; z-index:9999;</code></li>
							</ul>
							<div class="mm-example-heading"><strong><?php _e('Banner', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code></div>
<pre>display:block; width:120px; height:40px; color:rgba(51,102,153,0.9); background:rgba(255,255,255,0.7); 
font-size:12px; text-align:center; line-height:40px; text-decoration:none; font-weight:bold;
border:1px solid rgba(102,153,204,0.7); border-radius:3px; box-shadow:1px 1px 3px 0 rgba(0,0,0,0.3);</pre>

							<hr>
							
							<div class="mm-example-heading"><strong><?php _e('Ribbon', 'show-support-ribbon'); ?></strong> <code>&lt;div&gt;</code></div>
							<ul>
								<li><?php _e('Display top left:', 'show-support-ribbon'); ?> <code>position:fixed; left:-60px; top:20px; z-index:9999;</code></li>
								<li><?php _e('Display top right:', 'show-support-ribbon'); ?> <code>position:fixed; right:-60px; top:20px; z-index:9999;</code></li>
								<li><?php _e('Display bottom left:', 'show-support-ribbon'); ?> <code>position:fixed; left:-60px; bottom:20px; z-index:9999;</code></li>
								<li><?php _e('Display bottom right:', 'show-support-ribbon'); ?> <code>position:fixed; right:-60px; bottom:20px; z-index:9999;</code></li>
							</ul>
							
							<div class="mm-example-heading">
								<strong><?php _e('Ribbon', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code> <?php _e('(top left)', 'show-support-ribbon'); ?>
							</div>
<pre>display:block; width:200px; height:30px; color:#fff; background:rgba(102,153,204,0.9); 
font-size:12px; line-height:30px; text-align:center; text-decoration:none; 
border:1px solid rgba(255,255,255,0.7); transform: rotate(-40deg);</pre>

							<div class="mm-example-heading">
								<strong><?php _e('Ribbon', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code> <?php _e('(top right)', 'show-support-ribbon'); ?>
							</div>
<pre>display:block; width:200px; height:30px; color:#fff; background:rgba(102,153,204,0.9); 
font-size:12px; line-height:30px; text-align:center; text-decoration:none; 
border:1px solid rgba(255,255,255,0.7); transform: rotate(40deg);</pre>

							<div class="mm-example-heading">
								<strong><?php _e('Ribbon', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code> <?php _e('(bottom left)', 'show-support-ribbon'); ?>
							</div>
<pre>display:block; width:200px; height:30px; color:#fff; background:rgba(102,153,204,0.9); 
font-size:12px; line-height:30px; text-align:center; text-decoration:none; 
border:1px solid rgba(255,255,255,0.7); transform: rotate(40deg);</pre>

							<div class="mm-example-heading">
								<strong><?php _e('Ribbon', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code> <?php _e('(bottom right)', 'show-support-ribbon'); ?>
							</div>
<pre>display:block; width:200px; height:30px; color:#fff; background:rgba(102,153,204,0.9); 
font-size:12px; line-height:30px; text-align:center; text-decoration:none; 
border:1px solid rgba(255,255,255,0.7); transform: rotate(-40deg);</pre>

							<div class="mm-example-heading">
								<?php _e('Note: to add a drop shadow, add the following CSS to the', 'show-support-ribbon'); ?> <code>&lt;a&gt;</code> <?php _e('tag.', 'show-support-ribbon'); ?>
							</div>
<pre>box-shadow:1px 1px 3px 0 rgba(0,0,0,0.3);</pre>

							<div class="mm-example-heading">
								<?php _e('Note: to hide the ribbon on small screens, add the following CSS for the', 'show-support-ribbon'); ?> <code>&lt;div&gt;</code> <?php _e('tag.', 'show-support-ribbon'); ?>
							</div>
<pre>/* adjust the 500px to whatever width is desired */
@media (max-width: 500px) {
	#show-support-ribbon { display: none; }
}</pre>

							<hr>
							
							<div class="mm-example-heading"><strong><?php _e('Link', 'show-support-ribbon'); ?></strong> <code>&lt;div&gt;</code></div>
							<ul>
								<li><?php _e('Display top left:', 'show-support-ribbon'); ?> <code>position:fixed; left:5px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display top right:', 'show-support-ribbon'); ?> <code>position:fixed; right:5px; top:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom left:', 'show-support-ribbon'); ?> <code>position:fixed; left:5px; bottom:5px; z-index:9999;</code></li>
								<li><?php _e('Display bottom right:', 'show-support-ribbon'); ?> <code>position:fixed; right:5px; bottom:5px; z-index:9999;</code></li>
							</ul>
							
							<div class="mm-example-heading"><strong><?php _e('Link', 'show-support-ribbon'); ?></strong> <code>&lt;a&gt;</code></div>
							<pre>font-size:12px;</pre>
						</div>
					</div>
					
					<div id="mm-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Defaults', 'show-support-ribbon'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="ssr_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($ssr_options['default_options'])) { checked('1', $ssr_options['default_options']); } ?> /> 
								<label class="description" for="ssr_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'show-support-ribbon'); ?></label>
							</p>
							<p>
								<span class="mm-item-caption mm-item-caption-nomargin">
									<strong><?php esc_html_e('Tip:', 'show-support-ribbon'); ?></strong> 
									<?php esc_html_e('leave this option unchecked to remember your settings. Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'show-support-ribbon'); ?>
								</span>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'show-support-ribbon'); ?>" />
						</div>
					</div>
					
					<div id="mm-panel-current" class="postbox">
						<h2><?php esc_html_e('WP Resources', 'show-support-ribbon'); ?></h2>
						<div class="toggle">
							<?php require_once('support-panel.php'); ?>
						</div>
					</div>
					
				</div>
			</div>
			
			<div class="mm-credit-info">
				<a target="_blank" rel="noopener noreferrer" href="<?php echo $ssr_homeurl; ?>" title="<?php esc_attr_e('Plugin Homepage', 'show-support-ribbon'); ?>"><?php echo $ssr_plugin; ?></a> <?php esc_html_e('by', 'show-support-ribbon'); ?> 
				<a target="_blank" rel="noopener noreferrer" href="https://twitter.com/perishable" title="<?php esc_attr_e('Jeff Starr on Twitter', 'show-support-ribbon'); ?>">Jeff Starr</a> @ 
				<a target="_blank" rel="noopener noreferrer" href="https://monzillamedia.com/" title="<?php esc_attr_e('Obsessive Web Design &amp; Development', 'show-support-ribbon'); ?>">Monzilla Media</a>
			</div>
			
		</form>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			// toggle panels
			jQuery('.default-hidden').hide();
			jQuery('.mm-panel-toggle a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#mm-panel-primary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-primary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-secondary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-secondary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-tertiary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-tertiary .toggle').slideToggle(300);
				return true;
			});
			// prevent accidents
			if(!jQuery("#mm_restore_defaults").is(":checked")){
				jQuery('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'show-support-ribbon'); ?>");
					if (r == true){  
						jQuery("#mm_restore_defaults").attr('checked', true);
					} else {
						jQuery("#mm_restore_defaults").attr('checked', false);
					}
				});
			}
			// radio select toggle
			if(jQuery('form input[type=radio]:checked').val() == 'ssr_custom'){
				jQuery('.mm-custom-style').show();
			} else {
				jQuery('.mm-custom-style').hide();
			}
			jQuery('form input:radio').change(function(){
				if (jQuery(this).val() == 'ssr_custom') {
					jQuery('.mm-custom-style').slideDown('fast');
				} else {
					jQuery('.mm-custom-style').slideUp('fast');
				}
			});
		});
	</script>

<?php }