<?php

/* Register custom post types on the 'init' hook. */
add_action( 'init', 'restaurant_register_post_types' );

/**
 * Registers post types needed by the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function restaurant_register_post_types() {

	/* Set up the arguments for the post type. */
	$args = array(
		'description'         => __( 'Delicious food.', 'restaurant' ),
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
		'has_archive'         => 'menu',
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
			'slug'       => 'menu/items',
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		'supports' => array(
			'title',
			'editor',
			'excerpt',
		//	'author',
			'thumbnail',
			'comments',
		//	'trackbacks',
		//	'custom-fields',
			'revisions',
		//	'page-attributes',
		//	'post-formats',
		),

		'labels' => array(
			'name'               => __( 'Menu Items',                   'restaurant' ),
			'singular_name'      => __( 'Menu Item',                    'restaurant' ),
			'menu_name'          => __( 'Restaurant',                   'restaurant' ),
			'name_admin_bar'     => __( 'Menu Items',                   'restaurant' ),
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
			'archive_title'      => __( 'Menu',                         'restaurant' ),
		)
	);

	/* Register the post type. */
	register_post_type( 'restaurant_item', $args );
}

?>