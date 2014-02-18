<?php
/**
 * File for registering custom post types.
 *
 * @package    Restaurant
 * @subpackage Includes
 * @since      1.0.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2014, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom post types on the 'init' hook. */
add_action( 'init', 'restaurant_register_post_types' );

/* Filter post updated messages for custom post types. */
add_filter( 'post_updated_messages', 'rp_post_updated_messages' );

/* Filter the "enter title here" text. */
add_filter( 'enter_title_here', 'rp_enter_title_here', 10, 2 );

/**
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function restaurant_register_post_types() {

	/* Get plugin settings. */
	$settings = get_option( 'restaurant_settings', rp_get_default_settings() );

	/* Set up the arguments for the post type. */
	$args = array(
		'description'         => $settings['restaurant_item_description'],
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => rp_restaurant_menu_base(),
		'query_var'           => 'restaurant_item',
		'capability_type'     => 'restaurant_item',
		'map_meta_cap'        => true,

		'capabilities' => array(

			// meta caps (don't assign these to roles)
			'edit_post'              => 'edit_restaurant_item',
			'read_post'              => 'read_restaurant_item',
			'delete_post'            => 'delete_restaurant_item',

			// primitive/meta caps
			'create_posts'           => 'create_restaurant_items',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_restaurant_items',
			'edit_others_posts'      => 'manage_restaurant',
			'publish_posts'          => 'manage_restaurant',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_restaurant',
			'delete_private_posts'   => 'manage_restaurant',
			'delete_published_posts' => 'manage_restaurant',
			'delete_others_posts'    => 'manage_restaurant',
			'edit_private_posts'     => 'edit_restaurant_items',
			'edit_published_posts'   => 'edit_restaurant_items'
		),

		'rewrite' => array(
			'slug'       => rp_restaurant_menu_base() . '/items',
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'comments',
			'revisions',
		),

		'labels' => array(
			'name'               => __( 'Menu Items',                   'restaurant' ),
			'singular_name'      => __( 'Menu Item',                    'restaurant' ),
			'menu_name'          => __( 'Restaurant',                   'restaurant' ),
			'name_admin_bar'     => __( 'Restaurant Menu Item',         'restaurant' ),
			'all_items'          => __( 'Menu Items',                   'restaurant' ),
			'add_new'            => __( 'Add Menu Item',                'restaurant' ),
			'add_new_item'       => __( 'Add New Menu Item',            'restaurant' ),
			'edit_item'          => __( 'Edit Menu Item',               'restaurant' ),
			'new_item'           => __( 'New Menu Item',                'restaurant' ),
			'view_item'          => __( 'View Menu Item',               'restaurant' ),
			'search_items'       => __( 'Search Menu Items',            'restaurant' ),
			'not_found'          => __( 'No menu items found',          'restaurant' ),
			'not_found_in_trash' => __( 'No menu items found in trash', 'restaurant' ),

			/* Custom archive label.  Must filter 'post_type_archive_title' to use. */
			'archive_title'      => $settings['restaurant_item_archive_title'],
		)
	);

	/* Register the post type. */
	register_post_type( 'restaurant_item', $args );
}

/**
 * Custom "enter title here" text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  object  $post
 * @return string
 */
function rp_enter_title_here( $title, $post ) {

	if ( 'restaurant_item' === $post->post_type )
		$title = __( 'Enter menu item name', 'restaurant' );

	return $title;
}

/**
 * @since  1.0.0
 * @access public
 * @return void
 */
function rp_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['restaurant_item'] = array(
		 0 => '', // Unused. Messages start at index 1.
		 1 => sprintf( __( 'Menu item updated. <a href="%s">View menu item</a>', 'restaurant' ), esc_url( get_permalink( $post_ID ) ) ),
		 2 => '',
		 3 => '',
		 4 => __( 'Menu item updated.', 'restaurant' ),
		 5 => isset( $_GET['revision'] ) ? sprintf( __( 'Menu item restored to revision from %s', 'restaurant' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => sprintf( __( 'Menu item published. <a href="%s">View menu item</a>', 'restaurant' ), esc_url( get_permalink( $post_ID ) ) ),
		 7 => __( 'Menu item saved.', 'restaurant' ),
		 8 => sprintf( __( 'Menu item submitted. <a target="_blank" href="%s">Preview menu item</a>', 'restaurant' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		 9 => sprintf( __( 'Menu item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview menu item</a>', 'restaurant' ), date_i18n( __( 'M j, Y @ G:i', 'restaurant' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( __( 'Menu item draft updated. <a target="_blank" href="%s">Preview menu item</a>', 'restaurant' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}
