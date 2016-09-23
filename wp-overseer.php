<?php
/*
Plugin Name: WP Watchtower
Plugin URI:  http://www.elon.edu/e/university-communications/wordpress/plugins/wp-watchtower.html
Description: Custom WordPress tools for webmasters and content managers.
Version:     0.0.1
Author:      Elon University
Author URI:  http://www.elon.edu
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: wpw
*/

/*
 * Plugin activation and deactivation
 */
 
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
	//wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
	
	wp_register_style('font-awesome', plugins_url('assets/vendor/font-awesome/css/font-awesome.min.css', __FILE__), array(), '4.6.3', 'all');
	wp_enqueue_style('font-awesome');
}

require_once('classes/admin-dashboard.class.php');
$test = new WP_Watchtower_Dashboard();

require_once('classes/admin-settings.class.php');
$settings_page = new WP_Watchtower_Settings();