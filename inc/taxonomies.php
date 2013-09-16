<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    Restaurant
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register taxonomies on the 'init' hook. */
add_action( 'init', 'restaurant_register_taxonomies' );

/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void.
 */
function restaurant_register_taxonomies() {

	$tag_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'restaurant_tag',

		/* Only 2 caps are needed: 'manage_restaurant' and 'edit_restaurant_items'. */
		'capabilities' => array(
			'manage_terms' => 'manage_restaurant',
			'edit_terms'   => 'manage_restaurant',
			'delete_terms' => 'manage_restaurant',
			'assign_terms' => 'edit_restaurant_items',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => array(
			'slug'         => rp_restaurant_menu_base() . '/tags',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Tags',                           'restaurant' ),
			'singular_name'              => __( 'Tag',                            'restaurant' ),
			'menu_name'                  => __( 'Restaurant Tags',                      'restaurant' ),
			'name_admin_bar'             => __( 'Tags',                           'restaurant' ),
			'search_items'               => __( 'Search Tags',                    'restaurant' ),
			'popular_items'              => __( 'Popular Tags',                   'restaurant' ),
			'all_items'                  => __( 'All Tags',                       'restaurant' ),
			'edit_item'                  => __( 'Edit Tag',                       'restaurant' ),
			'view_item'                  => __( 'View Tag',                       'restaurant' ),
			'update_item'                => __( 'Update Tag',                     'restaurant' ),
			'add_new_item'               => __( 'Add New Tag',                    'restaurant' ),
			'new_item_name'              => __( 'New Tag Name',                   'restaurant' ),
			'separate_items_with_commas' => __( 'Separate tags with commas',      'restaurant' ),
			'add_or_remove_items'        => __( 'Add or remove tags',             'restaurant' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags', 'restaurant' ),
		)
	);

	register_taxonomy( 'restaurant_tag', array( 'restaurant_item' ), $tag_args );
}

?>