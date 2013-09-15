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
 * Removes sticky posts from the query when viewing menu home page.  Otherwise, we get an array_splice 
 * error from WP because we're disabling the posts request altogether.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $query
 * @return void
 */
function rp_pre_get_posts( $query ) {

	if ( $query->is_main_query() && rp_is_menu_home() )
		$query->set( 'ignore_sticky_posts', true );
}

/**
 * Don't request any posts from the DB when viewing the menu home page.
 *
 * @since  0.1.0
 * @access public
 * @param  string       $request
 * @param  object       $query
 * @return string|bool
 */
function rp_posts_request( $request, $query ) {

	if ( $query->is_main_query() && rp_is_menu_home() )
		return false;

	return $request;
}

/**
 * Filters the 'template_include' hook so that WordPress will recognize the 'restaurant-menu.php' 
 * template when viewing the '/menu' page.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $template
 * @return string
 */
function rp_template_include( $template ) {

	if ( rp_is_menu_home() ) {
		$has_template = locate_template( array( 'restaurant-menu.php' ) );

		if ( $has_template )
			$template = $has_template;
	}

	return $template;
}

/**
 * Filters 'wp_title' to display a title when viewing the menu home page.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $title
 * @return string
 */
function rp_wp_title( $title ) {
	return rp_is_menu_home() ? __( 'Menu', 'restaurant' ) : $title;
}

/**
 * Filters 'body_class' to display a custom class when viewing the menu home page.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function rp_body_class( $classes ) {

	if ( rp_is_menu_home() ) {
		if ( false !== ( $key = array_search( 'home', $classes ) ) )
			unset( $classes[ $key ] );

		if ( false !== ( $key = array_search( 'blog', $classes ) ) )
			unset( $classes[ $key ] );

		$classes[] = 'restaurant-menu-home';
	}

	return $classes;
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