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
     	
     	// Add our dashboard widgets
    	add_action('wp_dashboard_setup', array($this, 'dashboard_widgets'));
     	
	}
	
	public function dashboard_widgets() {
		// Register our dashbaord widgets
		wp_add_dashboard_widget('wpw_favorite_pages_widget', 'Favorite Pages', array($this, 'favorite_pages_widget_display'));
		wp_add_dashboard_widget('wpw_recent_updates_widget', 'Recently Updated', array($this, 'recent_updates_widget_display'));
		wp_add_dashboard_widget('wpw_content_review_widget', 'Content Review', array($this, 'content_review_widget_display'));
		
		// Determine if the widgets are added normally, or if they are overriding the default WordPress widgets.
		if ($this->main_override_enabled()) {
			if ($this->dashboard_override_enabled('network')) {
				$this->widgets_override();
			}
		} else {
			if ($this->dashboard_override_enabled('site')) {
				$this->widgets_override();
			}
		}
	}
	
	public function widgets_override() {
		global $wp_meta_boxes;
		
		// Remove default dashboard widgets.
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		
		// Make backups of our custom widgets.
		$favorite_pages_widget = $wp_meta_boxes['dashboard']['normal']['core']['wpw_favorite_pages_widget'];
		$recent_updates_widget = $wp_meta_boxes['dashboard']['normal']['core']['wpw_recent_updates_widget'];
		$content_review_widget = $wp_meta_boxes['dashboard']['normal']['core']['wpw_content_review_widget'];
		
		// Unset our custom widgets so we can rearrange them.
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpw_favorite_pages_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpw_recent_updates_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpw_content_review_widget']);
		
		// Add them back in the desired order.
		$wp_meta_boxes['dashboard']['normal']['core']['wpw_favorite_pages_widget'] = $favorite_pages_widget;
		$wp_meta_boxes['dashboard']['normal']['core']['wpw_recent_updates_widget'] = $recent_updates_widget;
		$wp_meta_boxes['dashboard']['side']['core']['wpw_content_review_widget'] = $content_review_widget;
		
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