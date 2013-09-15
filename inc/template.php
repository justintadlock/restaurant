<?php
/**
 * Template tags to use in themes.
 */

/**
 * Conditional tag to decide if we're viewing a restaurant-related page.
 *
 * @since  0.1.0
 * @access public
 * @return bool
 */
function rp_is_restaurant() {
	$is_restaurant_page = ( rp_is_menu_home() || rp_is_menu_item() || rp_is_menu_tag() ) ? true : false;

	return apply_filters( 'rp_is_restaurant', $is_restaurant_page );
}

/**
 * Conditional tag to see if we're viewing the restaurant menu home page.
 *
 * @since  0.1.0
 * @access public
 * @return bool
 */
function rp_is_menu_home() {
	global $wp;

	$base = rp_restaurant_menu_base();

	return ( $base === $wp->request && $base === $wp->matched_query && '^' . $base . '$' === $wp->matched_rule ) ? true : false;
}

/**
 * Conditional tag to check if we're viewing a single menu item page.
 *
 * @since  0.1.0
 * @access public
 * @return bool
 */
function rp_is_menu_item() {
	return is_singular( 'restaurant_item' );
}

/**
 * Conditional tag to see if we're viewing a restaurant tag page.
 *
 * @since  0.1.0
 * @access public
 * @return bool
 */
function rp_is_menu_tag() {
	return is_tax( 'restaurant_tag' );
}

/**
 * Displays the price of a menu item.
 *
 * @since  0.1.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function rp_menu_item_price( $post_id = '' ) {
	echo rp_get_menu_item_price( $post_id );
}

/**
 * Returns the price of a menu item.
 *
 * @since  0.1.0
 * @access public
 * @param  int     $post_id
 * @return string
 */
function rp_get_menu_item_price( $post_id = '' ) {

	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	$price = apply_filters( 'rp_menu_item_price', get_post_meta( $post_id, '_restaurant_item_price', true ) );

	$price = !empty( $price ) ? floatval( $price ) : '';

	return $price;
}

function rp_formatted_menu_item_price( $post_id = '' ) {
	echo rp_get_formatted_menu_item_price( $post_id );
}

function rp_get_formatted_menu_item_price( $post_id = '' ) {
	$price = rp_get_menu_item_price( $post_id );

	if ( !empty( $price ) ) {
		return sprintf( __( '$%s', 'restaurant' ), number_format( $price, 2, '.', ',' ) );
	}

	return '';
}








?>