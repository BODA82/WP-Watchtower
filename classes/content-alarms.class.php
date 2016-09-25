<?php
require_once('watchtower.class.php');

class WP_Watchtower_Alarms extends WP_Watchtower {
	
	/**
     * Initializes the plugins content alarms class
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {
     	
		add_action('init', array($this, 'register_content_alarms_cpt'), 99);
     	
	}

	// Register Custom Post Type
	public function register_content_alarms_cpt() {
	
		$labels = array(
			'name'                  => _x('Content Alarms', 'Post Type General Name', 'wpw'),
			'singular_name'         => _x('Content Alarm', 'Post Type Singular Name', 'wpw'),
			'menu_name'             => __('Content Alarms', 'wpw'),
			'name_admin_bar'        => __('Content Alarms', 'wpw'),
			'archives'              => __('Content Alarm Archives', 'wpw'),
			'parent_item_colon'     => __('Parent Content Alarm', 'wpw'),
			'all_items'             => __('Content Alarms', 'wpw'),
			'add_new_item'          => __('Add New Content Alarm', 'wpw'),
			'add_new'               => __('Add New', 'wpw'),
			'new_item'              => __('New Content Alarm', 'wpw'),
			'edit_item'             => __('Edit Content Alarm', 'wpw'),
			'update_item'           => __('Update Content Alarm', 'wpw'),
			'view_item'             => __('View Content Alarm', 'wpw'),
			'search_items'          => __('Search Content Alarm', 'wpw'),
			'not_found'             => __('Not found', 'wpw'),
			'not_found_in_trash'    => __('Not found in Trash', 'wpw'),
			'featured_image'        => __('Featured Image', 'wpw'),
			'set_featured_image'    => __('Set featured image', 'wpw'),
			'remove_featured_image' => __('Remove featured image', 'wpw'),
			'use_featured_image'    => __('Use as featured image', 'wpw'),
			'insert_into_item'      => __('Insert into Content Alarm', 'wpw'),
			'uploaded_to_this_item' => __('Uploaded to this Content Alarm', 'wpw'),
			'items_list'            => __('Content Alarms list', 'wpw'),
			'items_list_navigation' => __('Content Alarms list navigation', 'wpw'),
			'filter_items_list'     => __('Filter Content Alarms list', 'wpw')
		);
		$capabilities = array(
			'edit_post'             => 'manage_options',
			'read_post'             => 'manage_options',
			'delete_post'           => 'manage_options',
			'edit_posts'            => 'manage_options',
			'edit_others_posts'     => 'manage_options',
			'publish_posts'         => 'manage_options',
			'read_private_posts'    => 'manage_options'
		);
		$args = array(
			'label'                 => __('Content Alarm', 'wpw'),
			'description'           => __('WP Watchtower Content Alarms', 'wpw'),
			'labels'                => $labels,
			'supports'              => array('title', 'revisions', 'custom-fields'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => 'wpw',
			'menu_position'         => 25,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capabilities'          => $capabilities
		);
		
		if ($this->main_override_enabled()) {
			register_post_type('wpw_content_alarms', $args);
		} else {
			register_post_type('wpw_content_alarms', $args);
		}
	}
}