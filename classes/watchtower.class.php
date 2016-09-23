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