<?php
require_once('watchtower.class.php');

class WP_Watchtower_Settings extends WP_Watchtower {
	
	/**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
    	add_filter('admin_menu', array($this, 'settings_menu'));
     	
	}
	
	
	public function settings_menu() {
		
		add_options_page('Watchtower Settings', 'Watchtower Settings', 'manage_options', 'watchtower-settings', array($this, 'settings_page'));
		
	}
	
	public function settings_page() {
		
		
		
	}
	
		
}