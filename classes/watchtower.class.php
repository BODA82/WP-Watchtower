<?php
class WP_Watchtower {
	
	/**
     * Initializes the class.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
    	
     	
	}
	
	/**
	 * Determines if the main network override is enabled.
	 *
	 * @return boolean              True / False
	 */
	public function main_override_enabled() {
		$options = get_site_option('wpw_options');
		if (is_multisite() && $options['network_main_override'] == 'enabled') {
			if (get_current_blog_id() == 1) {
				return true;	
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Determins if the dashboard override is enabled.
	 *
	 * @param string $type    		"network" or "site"
	 *
	 * @return string               An error message.
	 */
	public function dashboard_override_enabled($type) {
		if ($type == 'network') {
			$options = get_site_option('wpw_options');
			if (is_multisite() && $options['network_dashboard_override'] == 'enabled') {
				return true;
			} else {
				return false;
			}
		}
		
		if ($type == 'site') {
			$options = get_option('wpw_options');
			if ($options['site_dashboard_override'] == 'enabled') {
				return true;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	public function get_error_message($error_code) {
	    switch ($error_code) {
	        // User login errors
	        case 'error_code_example':
	            return __('Example Error Message', 'wpw');
			
	        default:
	            break;
	    }
	     
	    return __('An unknown error occurred. Please try again later.', 'wpw');
	}
	
}