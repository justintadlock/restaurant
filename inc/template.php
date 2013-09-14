<?php

/* Are we viewing a restaurant page? */
function rp_is_restaurant_page() {
	return ( rp_is_menu_home() || rp_is_menu_item() || rp_is_menu_meal() || rp_is_menu_course() ) ? true : false;
}

/* Is menu home page? */
function rp_is_menu_home() {
	global $wp;

	return ( 'menu' === $wp->request && 'menu' === $wp->matched_query && '^menu$' === $wp->matched_rule ) ? true : false;
}

/* Is singular menu item? */
function rp_is_menu_item() {
	return is_singular( 'restaurant_item' );
}

/* Is menu meal archive? */
function rp_is_menu_meal() {
	return is_tax( 'restaurant_meal' );
}

/* Is menu course archive? */
function rp_is_menu_course() {
	return is_tax( 'restaurant_course' );
}

/* Do menu items support reviews (comments)? */
function rp_supports_reviews() {
	return apply_filters( 'rp_supports_reviews', true );
}

/* Echo the price of a menu item. */
function rp_menu_item_price( $post_id = '' ) {
	echo rp_get_menu_item_price( $post_id );
}

	/* Return the price of a menu item. */
	function rp_get_menu_item_price( $post_id = '' ) {

		if ( empty( $post_id ) )
			$post_id = get_the_ID();

		$price = get_post_meta( $post_id, '_restaurant_item_price', true );

		$price = ( !empty( $price ) ? intval( $price ) : '' );

		return $price;
	}

?>