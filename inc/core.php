<?php

/* Not used yet. */
function rp_restaurant_menu_base() {
	return apply_filters( 'rp_restaurant_menu_base', 'menu' );
}

function rp_item_post_type_name() {
	return apply_filters( 'rp_item_post_type_name', 'restaurant_item' );
}

function rp_tag_taxonomy_name() {
	return apply_filters( 'rp_tag_taxonomy_name', 'restaurant_tag' );
}

function rp_review_comment_type_name() {
	return apply_filters( 'rp_review_comment_type_name', 'restaurant_review' );
}

/************************************************/

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
 * Adds a custom image size for viewing in the admin edit posts screen.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function rp_add_image_sizes() {
	add_image_size( 'restaurant-thumbnail', 50, 50, true );
}

/**
 * Process comments left on a single menu item page.  Basically, we're just changing the comment type here 
 * to 'restaurant_review'.
 *
 * @since  0.1.0
 * @access public
 * @param  array   $comment_data
 * @return array
 */
function rp_preprocess_comment( $comment_data ) {

	if ( !empty( $comment_data['comment_post_ID'] ) ) {

		if ( 'restaurant_item' === get_post_type( $comment_data['comment_post_ID'] ) && rp_supports_reviews() && in_array( $comment_data['comment_type'], array( '', 'comment' ) ) )
			$comment_data['comment_type'] = 'restaurant_review';
	}

	return $comment_data;
}

/**
 * Filters the allowed comment types that can have avatars so that the 'restaurant_review' type is included.
 *
 * @since  0.1.0
 * @access public
 * @param  array $types
 * @return array
 */
function rp_avatar_comment_types( $types ) {

	if ( rp_supports_reviews() )
		$types[] = 'restaurant_review';

	return $types;
}

?>