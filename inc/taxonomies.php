<?php

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

	$meal_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'restaurant_meal',

		/* Only 2 caps are needed: 'manage_restaurant' and 'edit_restaurant_items'. */
		'capabilities' => array(
			'manage_terms' => 'manage_restaurant',
			'edit_terms'   => 'manage_restaurant',
			'delete_terms' => 'manage_restaurant',
			'assign_terms' => 'edit_restaurant_items',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => array(
			'slug'         => 'menu/meals',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Meals',                           'restaurant' ),
			'singular_name'              => __( 'Meal',                            'restaurant' ),
			'menu_name'                  => __( 'Meal Times',                      'restaurant' ),
			'name_admin_bar'             => __( 'Meal Times',                      'restaurant' ),
			'search_items'               => __( 'Search Meals',                    'restaurant' ),
			'popular_items'              => __( 'Popular Meals',                   'restaurant' ),
			'all_items'                  => __( 'All Meals',                       'restaurant' ),
			'edit_item'                  => __( 'Edit Meal',                       'restaurant' ),
			'view_item'                  => __( 'View Meal',                       'restaurant' ),
			'update_item'                => __( 'Update Meal',                     'restaurant' ),
			'add_new_item'               => __( 'Add New Meal',                    'restaurant' ),
			'new_item_name'              => __( 'New Meal Name',                   'restaurant' ),
			'separate_items_with_commas' => __( 'Separate meals with commas',      'restaurant' ),
			'add_or_remove_items'        => __( 'Add or remove meals',             'restaurant' ),
			'choose_from_most_used'      => __( 'Choose from the most used meals', 'restaurant' ),
		)
	);

	$course_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'restaurant_course',

		/* Only 2 caps are needed: 'manage_restaurant' and 'edit_restaurant_items'. */
		'capabilities' => array(
			'manage_terms' => 'manage_restaurant',
			'edit_terms'   => 'manage_restaurant',
			'delete_terms' => 'manage_restaurant',
			'assign_terms' => 'edit_restaurant_items',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => array(
			'slug'         => 'menu/courses',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Courses',                           'restaurant' ),
			'singular_name'              => __( 'Course',                            'restaurant' ),
			'menu_name'                  => __( 'Courses',                           'restaurant' ),
			'name_admin_bar'             => __( 'Course',                            'restaurant' ),
			'search_items'               => __( 'Search Courses',                    'restaurant' ),
			'popular_items'              => __( 'Popular Courses',                   'restaurant' ),
			'all_items'                  => __( 'All Courses',                       'restaurant' ),
			'edit_item'                  => __( 'Edit Course',                       'restaurant' ),
			'view_item'                  => __( 'View Course',                       'restaurant' ),
			'update_item'                => __( 'Update Course',                     'restaurant' ),
			'add_new_item'               => __( 'Add New Course',                    'restaurant' ),
			'new_item_name'              => __( 'New Course Name',                   'restaurant' ),
			'separate_items_with_commas' => __( 'Separate courses with commas',      'restaurant' ),
			'add_or_remove_items'        => __( 'Add or remove courses',             'restaurant' ),
			'choose_from_most_used'      => __( 'Choose from the most used courses', 'restaurant' ),
		)
	);

	register_taxonomy( 'restaurant_meal',   array( 'restaurant_item' ), $meal_args   );
	//register_taxonomy( 'restaurant_course', array( 'restaurant_item' ), $course_args );
}

?>