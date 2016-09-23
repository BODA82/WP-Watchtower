<?php
/*
Plugin Name: WP Overseer
Plugin URI:  http://www.elon.edu
Description: Custom WordPress tools for webmasters and content managers.
Version:     0.0.1
Author:      Elon University
Author URI:  http://www.elon.edu
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: ovr
*/

/*
 * Plugin activation and deactivation
 */
 
register_activation_hook(__FILE__, 'ovr_activation');
register_deactivation_hook(__FILE__, 'ovr_deactivation');

function ovr_activation() {
	
}

function ovr_deactivation() {
	
}


/*
 * Enqueue scripts and styles
 */

add_action('admin_enqueue_scripts', 'ovr_admin_enqueue');

function ovr_admin_enqueue() {
	//wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
	
	wp_register_style('font-awesome', plugins_url('assets/vendor/font-awesome/css/font-awesome.min.css', __FILE__), array(), '4.6.3', 'all');
	wp_enqueue_style('font-awesome');
}