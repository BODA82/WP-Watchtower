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
		add_action('admin_init', array($this, 'network_settings_init'), 0);
		
		// Register our network_options_page to the network_admin_menu action hook
		add_action('network_admin_menu', array($this, 'network_options_page'), 0);
		
		add_action('network_admin_edit_wpw_options', array($this, 'network_save_option'), 0);
		
		// Register our settings_init to the admin_init action hook
		add_action('admin_init', array($this, 'site_settings_init'), 0);
		
		// Register our options_page to the admin_menu action hook
		add_action('admin_menu', array($this, 'site_options_page'), 0);
     	
	}
	 
	/**
	 * Network Settings Init
	 * 
	 * Register settings for the WordPress Network if Multisite is enabled.
	 */
	public function network_settings_init() {
	    register_setting('wpw_network', 'wpw_options');
	 
	    add_settings_section(
	        'wpw_network_override',
	        __('Network Override', 'wpw'),
	        array($this, 'network_dashboard_cb'),
	        'wpw_network'
	    );
		
		add_settings_field(
	        'network_main_override', 
	        __('Override All Sites', 'wpw'),
	        array($this, 'network_main_override_cb'),
	        'wpw_network',
	        'wpw_network_override',
	        [
	            'label_for' => 'network_main_override',
	            'class' => 'wpw_row',
	        ]
	    );
		
	    add_settings_field(
	        'network_dashboard_override', 
	        __('Override Default WordPress Dashboard', 'wpw'),
	        array($this, 'network_dashboard_override_cb'),
	        'wpw_network',
	        'wpw_network_override',
	        [
	            'label_for' => 'network_dashboard_override',
	            'class' => 'wpw_row',
	        ]
	    );
	    
	    add_settings_field(
		    'network_alarms_override',
		    __('Override Site Content Alarms', 'wpw'),
		    array($this, 'network_alarms_override_cb'),
		    'wpw_network',
		    'wpw_network_override',
		    [
			    'label_for' => 'network_alarms_override',
			    'class' => 'wpw_row'
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
	
	/**
	 * Network Main Override Field Callback
	 *
	 * Call back to display the network main override setting HTML.
	 */
	public function network_main_override_cb($args) {
	    $options = get_site_option('wpw_options');
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
	        <?php echo esc_html('Enabling this option will override all sites in your Network and only allow control to WP Watchtower through both the Network admin and the site with blog_id "1".', 'wpw'); ?>
	    </p>
	    <?php
	}
	 
	/**
	 * Network Dashboard Override Field Callback
	 *
	 * Call back to display the network dashboard override setting HTML.
	 */
	public function network_dashboard_override_cb($args) {
	    $options = get_site_option('wpw_options');
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
	 * Network Content Alarms Override Field Callback
	 *
	 * Call back to display the network content alarms override setting HTML.
	 */
	public function network_alarms_override_cb($args) {
	    $options = get_site_option('wpw_options');
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
	        <?php echo esc_html('Enabling this option will force all content alarms to be controlled through the site with blog_id "1". If disabled, individual sites will be able to setup their own content alarms.', 'wpw'); ?>
	    </p>
	    <?php
	}
	
	/**
	 * Network Save Option
	 *
	 * Callback to save the network options.
	 */
	public function network_save_option() {
		update_site_option('wpw_options', $_POST['wpw_options']);
		wp_redirect(
		    add_query_arg(
		        array('page' => 'wpw_network', 'settings-updated' => 'true'),
		        (is_multisite() ? network_admin_url('admin.php') : admin_url('admin.php'))
		    )
		);
		exit;
	}
	 
	/**
	 * Network Options Page
	 *
	 * Register the top level menu item on the Network admin page.
	 */
	public function network_options_page() {
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
	        add_settings_error('wpw_messages', 'wpw_message', __('Settings Saved', 'wpw'), 'updated');
	    }
	 
	    // show error/update messages
	    settings_errors('wpw_messages');
	    ?>
	    <div class="wrap">
	        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	        <form action="edit.php?action=wpw_options" method="post">
	            <?php
	            settings_fields('wpw_network');
	            do_settings_sections('wpw_network');
	            submit_button('Save Settings');
	            ?>
	        </form>
	    </div>
	    <?php
	}
	
	/**
	 * Site Settings Init
	 * 
	 * Register settings for individual sites.
	 */
	public function site_settings_init() {
	    register_setting('wpw_site', 'wpw_options');
	 
	    add_settings_section(
	        'wpw_site_override',
	        __('Site Override', 'wpw'),
	        array($this, 'site_dashboard_cb'),
	        'wpw_site'
	    );
		
	    add_settings_field(
	        'site_dashboard_override', 
	        __('Override Default WordPress Dashboard', 'wpw'),
	        array($this, 'site_dashboard_override_cb'),
	        'wpw_site',
	        'wpw_site_override',
	        [
	            'label_for' => 'site_dashboard_override',
	            'class' => 'wpw_row',
	        ]
	    );
	}
	
	/**
	 * Site Dashboard Section Callback
	 *
	 * Callback to display the section for replacing the default WordPress Dashboard widgets.
	 */
	public function site_dashboard_cb($args) {
	    ?>
	    <p id="<?php echo esc_attr($args['id']); ?>"><?php echo esc_html__('The following settings will apply override default WordPress settings.', 'wpw'); ?></p>
	    <?php
	}
	
	/**
	 * Site Dashboard Override Field Callback
	 *
	 * Call back to display the network dashboard override setting HTML.
	 */
	public function site_dashboard_override_cb($args) {
	    $options = get_option('wpw_options');
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
	 * Site Options Page
	 *
	 * Register the top level menu item on individual site admin pages. If this is a multisite and
	 * the main override option is enabled, only show the options page for blog_id "1".
	 */
	public function site_options_page() {	
		if ($this->main_override_enabled()) {
				add_menu_page(
				    'WP Watchtower',
			        'WP Watchtower',
			        'manage_options',
			        'wpw',
			        array($this, 'site_options_page_html')
			    );
		} else {
			add_menu_page(
			    'WP Watchtower',
		        'WP Watchtower',
		        'manage_options',
		        'wpw',
		        array($this, 'site_options_page_html')
		    );
		}
	   
	}
	
	/**
	 * Network Options Page HTML
	 *
	 * Callback to build the HTML for our Network admin page.
	 */
	public function site_options_page_html() {
		
	    // check user capabilities
	    if (!current_user_can('manage_options')) {
	        return;
	    }
	 
	    // add error/update messages
	    if (isset($_GET['settings-updated'])) {
	        add_settings_error('wpw_messages', 'wpw_message', __('Settings Saved', 'wpw'), 'updated');
	    }
	 
	    // show error/update messages
	    settings_errors('wpw_messages');
	    ?>
	    <div class="wrap">
	        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	        <form action="options.php" method="post">
				<?php
	            settings_fields('wpw_site');
	            do_settings_sections('wpw_site');
	            submit_button('Save Settings');
	            ?>
	        </form>
	    </div>
	    <?php
	}
		
}