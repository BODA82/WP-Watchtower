<?php
/*
Plugin Name: WP Watchtower
Plugin URI:  http://cspir.es
Description: Custom WordPress tools for webmasters and content managers.
Version:     0.0.1
Author:      Christopher Spires
Author URI:  http://cspir.es
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: wpw
*/

/*
 * Plugin activation and deactivation
 */

$plugin_version = '0.0.1';

register_activation_hook(__FILE__, 'wpw_activation');
register_deactivation_hook(__FILE__, 'wpw_deactivation');

function wpw_activation() {
	
}

function wpw_deactivation() {
	
}


/*
 * Enqueue scripts and styles
 */

add_action('admin_enqueue_scripts', 'wpw_admin_enqueue');

function wpw_admin_enqueue() {
	global $plugin_version;
	
	// Custom global admin scripts
	wp_enqueue_script('wpw-admin-scripts', plugins_url('assets/js/global-admin.js', __FILE__), array('jquery'), $plugin_version, true);
	
	// Page review date admin scripts
	wp_enqueue_script('wpw-page-review', plugins_url('assets/js/page-review.js', __FILE__), array('jquery'), $plugin_version, true);
	
	// Font Awesome styles
	wp_register_style('font-awesome', plugins_url('assets/vendor/font-awesome/css/font-awesome.min.css', __FILE__), array(), '4.6.3', 'all');
	wp_enqueue_style('font-awesome');
	
	// Custom admin styles
	wp_register_style('wpw-admin-styles', plugins_url('assets/styles/css/admin.css', __FILE__), array(), $plugin_version, 'all');
	wp_enqueue_style('wpw-admin-styles');
}

foreach (glob(plugin_dir_path(__FILE__) . 'classes/*.class.php') as $filename) {
    include_once $filename;
}

// Going to break this down later to only load classes when needed. Just being lazy right now.
$dashboard = new WP_Watchtower_Dashboard();
$settings_page = new WP_Watchtower_Settings();
$content_alarms = new WP_Watchtower_Alarms();
$page_review = new WP_Watchtower_Page_review();