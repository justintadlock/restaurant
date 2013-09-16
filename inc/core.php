<?php

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