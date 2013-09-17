<?php
/**
 * Core functions file for the plugin.  This file sets up default actions/filters and defines other functions 
 * needed within the plugin.
 *
 * @package    Restaurant
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Filter the post type archive title. */
add_filter( 'post_type_archive_title', 'rp_post_type_archive_title' );

/* Add custom image sizes (for menu listing in admin). */
add_action( 'init', 'rp_add_image_sizes' );

/**
 * Returns the default plugin settings.
 *
 * @since  0.1.0
 * @access public
 * @return array
 */
function rp_get_default_settings() {

	$settings = array(
		'restaurant_item_archive_title' => __( 'Menu',            'restaurant' ),
		'restaurant_item_description'   => __( 'Delicious food.', 'restaurant' )
	);

	return $settings;
}

/**
 * Defines the base URL slug for the "menu" section of the Web site.
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function rp_restaurant_menu_base() {
	return apply_filters( 'rp_restaurant_menu_base', 'menu' );
}

/**
 * Filters 'post_type_archive_title' to use our custom 'archive_title' label.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $title
 * @return string
 */
function rp_post_type_archive_title( $title ) {

	if ( is_post_type_archive( 'restaurant_item' ) ) {
		$post_type = get_post_type_object( 'restaurant_item' );
		$title     = isset( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $title;
	}

	return $title;
}

/**
 * Adds a custom image size for viewing in the admin edit posts screen.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function rp_add_image_sizes() {
	add_image_size( 'restaurant-thumbnail', 100, 75, true );
}

?>