<?php
/**
 * Template tags to use in themes.
 *
 * @package    Restaurant
 * @subpackage Includes
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to decide if we're viewing a restaurant-related page.
 *
 * @since  0.1.0
 * @access public
 * @return bool
 */
function rp_is_restaurant() {

	if ( is_singular( 'restaurant_item' ) || is_post_type_archive( 'restaurant_item' ) || is_tax( 'restaurant_tag' ) )
		$is_restaurant_page = true;
	else
		$is_restaurant_page = false;

	return apply_filters( 'rp_is_restaurant', $is_restaurant_page );
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

/**
 * Displays the formatted menu item price (i.e., with currency symbol.
 *
 * @since  0.1.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function rp_formatted_menu_item_price( $post_id = '' ) {
	echo rp_get_formatted_menu_item_price( $post_id );
}

/**
 * Gets the formatted menu item price (i.e., with the currency symbol.
 *
 * @since  0.1.0
 * @access public
 * @param  int     $post_id
 * @return string
 */
function rp_get_formatted_menu_item_price( $post_id = '' ) {
	$price = rp_get_menu_item_price( $post_id );

	if ( !empty( $price ) )
		/* Translators: The $ is for the currency symbol. The %s is the number. */
		return sprintf( __( '$%s', 'restaurant' ), number_format( $price, 2, '.', ',' ) );

	return '';
}

?>