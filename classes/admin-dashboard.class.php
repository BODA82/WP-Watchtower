<?php
require_once('watchtower.class.php');

class WP_Watchtower_Dashboard extends WP_Watchtower {
	
	/**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
    	add_action('wp_dashboard_setup', array($this, 'dashboard_widgets'));
     	
	}
	
	public function dashboard_widgets() {
		
		// Add our custom dashboard widgets
		wp_add_dashboard_widget('wpw_favorite_pages_widget', 'Favorite Pages', array($this, 'favorite_pages_widget_display'));
		wp_add_dashboard_widget('wpw_recent_updates_widget', 'Recently Updated', array($this, 'recent_updates_widget_display'));
		wp_add_dashboard_widget('wpw_content_review_widget', 'Content Review', array($this, 'content_review_widget_display'));
		
		// Modify the dashboard widget layout
		global $wp_meta_boxes;
		//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		
	}
	
	public function favorite_pages_widget_display() {
		
		echo 'TESTING, TESTING, 1... 2... 3...';
		
	}
	
	public function recent_updates_widget_display() {
		
		echo 'TESTING, TESTING, 1... 2... 3...';
		
	}
	
	public function content_review_widget_display() {
		
		echo 'TESTING, TESTING, 1... 2... 3...';
		
	}
		
}