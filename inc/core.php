<?php

/* Not used yet. */
function rp_menu_item_post_type_name() {
	return 'restaurant_item';
}

function rp_menu_course_taxonomy_name() {
	return 'restaurant_course';
}

function rp_menu_item_review_comment_type_name() {
	return 'restaurant_review';
}
/************************************************/

add_filter( 'template_include', 'rp_template_include', 15 );

function rp_template_include( $template ) {

	if ( rp_is_menu_home() ) {
		$has_template = locate_template( array( 'restaurant-menu.php' ) );

		if ( $has_template )
			$template = $has_template;
	}

	return $template;
}

add_action( 'init', 'rp_add_image_sizes' );

function rp_add_image_sizes() {
	add_image_size( 'restaurant-thumbnail', 50, 50, true );
}


add_filter( 'preprocess_comment', 'rp_preprocess_comment' );

function rp_preprocess_comment( $comment_data ) {

	if ( !empty( $comment_data['comment_post_ID'] ) ) {

		if ( in_array( $comment_data['comment_type'], array( '', 'comment' ) ) && 'restaurant_item' === get_post_type( $comment_data['comment_post_ID'] ) )
			$comment_data['comment_type'] = 'restaurant_review';
	}

	return $comment_data;
}

?>