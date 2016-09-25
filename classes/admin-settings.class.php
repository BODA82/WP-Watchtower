<?php
require_once('watchtower.class.php');

class WP_Watchtower_Settings extends WP_Watchtower {
	
	/**
     * Initializes the plugins settings class
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
		// Register our network_settings_init to the admin_init action hook
		add_action('admin_init', array($this, 'network_settings_init'));
		
		// Register our network_options_page to the network_admin_menu action hook
		add_action('network_admin_menu', array($this, 'network_options_page'));
     	
	}
	 
	/**
	 * Network Settings Init
	 * 
	 * Register settings for the WordPress Network if Multisite is enabled.
	 */
	public function network_settings_init() {
	    register_setting('wpw_network', 'wpw_options');
	 
	    add_settings_section(
	        'wpw_section_override',
	        __('Network Override', 'wpw'),
	        array($this, 'network_dashboard_cb'),
	        'wpw_network'
	    );
	 
	    add_settings_field(
	        'wpw_field_network_dashboard_override', 
	        __('Override Default WordPress Dashboard', 'wpw'),
	        array($this, 'field_dashboard_override_cb'),
	        'wpw_network',
	        'wpw_section_override',
	        [
	            'label_for' => 'wpw_field_network_dashboard_override',
	            'class' => 'wpw_row',
	        ]
	    );
	}
	 
	 
	/**
	 * Network Dashboard Section Callback
	 *
	 * Callback to display the section for network orverrides and replacing the default WordPress Dashboard widgets.
	 */
	public function network_dashboard_cb($args) {
	    ?>
	    <p id="<?php echo esc_attr($args['id']); ?>"><?php echo esc_html__('The following settings will apply to all sites in your network and override the identical option on each individual site.', 'wpw'); ?></p>
	    <?php
	}
	 
	// pill field cb
	public function field_dashboard_override_cb($args) {
	    // get the value of the setting we've registered with register_setting()
	    $options = get_option('wpw_options');
	    // output the field
	    ?>
	    <select id="<?= esc_attr($args['label_for']); ?>" name="wpw_options[<?php echo esc_attr($args['label_for']); ?>]">
	        <option value="enabled" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'enabled', false)) : (''); ?>>
	            <?php echo esc_html('Enable', 'wpw'); ?>
	        </option>
	        <option value="disabled" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'disabled', false)) : (''); ?>>
	            <?php echo esc_html('Disable', 'wpw'); ?>
	        </option>
	    </select>
	    <p class="description">
	        <?php echo esc_html('Enabling this option will override the default WordPress dashboard widgets and replace it with a WP Watchtower default set.', 'wpw'); ?>
	    </p>
	    <?php
	}
	 
	/**
	 * Network Options Page
	 *
	 * Register the top level menu item on the Network admin page.
	 */
	public function network_options_page() {
	    // add top level menu page
	    add_menu_page(
	        'WP Watchtower',
	        'WP Watchtower',
	        'manage_network',
	        'wpw_network',
	        array($this, 'network_options_page_html')
	    );
	}
	 

	 
	/**
	 * Network Options Page HTML
	 *
	 * Callback to build the HTML for our Network admin page.
	 */
	public function network_options_page_html() {
	    // check user capabilities
	    if (!current_user_can('manage_network')) {
	        return;
	    }
	 
	    // add error/update messages
	    if (isset($_GET['settings-updated'])) {
	        // add settings saved message with the class of "updated"
	        add_settings_error('wpw_messages', 'wpw_message', __('Settings Saved', 'wpw'), 'updated');
	    }
	 
	    // show error/update messages
	    settings_errors('wpw_messages');
	    ?>
	    <div class="wrap">
	        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	        <form action="options.php" method="post">
	            <?php
	            settings_fields('wpw_network');
	            do_settings_sections('wpw_network');
	            submit_button('Save Settings');
	            ?>
	        </form>
	    </div>
	    <?php
	}
		
		
}