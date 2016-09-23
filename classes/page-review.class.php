<?php
class WP_Overseer_Page_Review_Metabox {
	
	adfasdfasdfasdfasd
	
	/**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
    	add_action('wp_dashboard_setup', array($this, 'ovr_dashboard_widgets'));
     	
	}
	
	public function ovr_dashboard_widgets() {
		
		wp_add_dashboard_widget('ovr_favorite_pages_widget', 'My Favorite Pages', array($this, 'ovr_favorite_pages_widget_display'));
		
	}
	
	public function ovr_favorite_pages_widget_display() {
		echo 'TESTING, TESTING, 1... 2... 3...';
	}
	
	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	private function get_error_message($error_code) {
	    switch ($error_code) {
	        // User login errors
	        case 'error_code_example':
	            return __('Example Error Message', 'ovr');
			
	        default:
	            break;
	    }
	     
	    return __('An unknown error occurred. Please try again later.', 'ovr');
	}
	
}