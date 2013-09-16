<?php

/* Filter the post type archive title. */
add_filter( 'post_type_archive_title', 'rp_post_type_archive_title' );

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
	add_image_size( 'restaurant-thumbnail', 50, 50, true );
}

?>