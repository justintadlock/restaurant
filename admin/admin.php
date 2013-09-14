<?php
/**
 * @package Restaurant
 * @subpackage Admin
 */

add_action( 'admin_menu', 'restaurant_admin_setup' );

function restaurant_admin_setup() {

	add_filter( 'parent_file', 'rp_parent_file' );

	add_submenu_page( 
		'edit.php?post_type=restaurant_item',
		__( 'Reviews', 'restaurant' ),
		__( 'Reviews', 'restaurant' ),
		'manage_restaurant',
		'edit-comments.php?comment_type=restaurant_review'
	);

	/* Load post meta boxes on the post editing screen. */
	add_action( 'load-post.php', 'restaurant_admin_load_post_meta_boxes' );
	add_action( 'load-post-new.php', 'restaurant_admin_load_post_meta_boxes' );

	/* Only run our customization on the 'edit.php' page in the admin. */
	add_action( 'load-edit.php', 'rp_admin_load_edit' );
}

function rp_parent_file( $parent_file ) {
	global $current_screen, $self;

	if ( 'edit-comments' === $current_screen->base && isset( $_GET['comment_type'] ) && 'restaurant_review' === $_GET['comment_type'] ) {

		$parent_file = 'edit.php?post_type=restaurant_item';
		$self        = 'edit-comments.php?comment_type=restaurant_review';
	}

	return $parent_file;
}

function rp_admin_load_edit() {
	$screen = get_current_screen();

	//var_dump( $screen );

	if ( !empty( $screen->post_type ) && 'restaurant_item' === $screen->post_type )
		add_filter( 'request', 'rp_admin_sort_menu_items' );
}

function rp_admin_sort_menu_items( $vars ) {

	if ( !isset( $vars['order'] ) && !isset( $vars['orderby'] ) ) {
		$vars = array_merge(
			$vars,
			array(
				'order'   => 'ASC',
				'orderby' => 'title'
			)
		);
	}

	return $vars;
}

function restaurant_admin_load_post_meta_boxes() {
	require_once( RESTAURANT_DIR . 'admin/meta-box-menu-item-price.php' );
}


add_filter( 'manage_edit-restaurant_item_columns', 'restaurant_edit_restaurant_item_columns' ) ;

function restaurant_edit_restaurant_item_columns( $columns ) {

	$columns['title']     = __( 'Menu Item', 'restaurant' );
	$columns['price']     = __( 'Price', 'restaurant' );
	$columns['thumbnail'] = '';

	$comments = $columns['comments'];

	unset( $columns['comments'] );

	unset( $columns['date'] );

	if ( rp_supports_reviews() )
		$columns['comments'] = $comments;


	return $columns;
}

add_action( 'manage_restaurant_item_posts_custom_column', 'restaurant_manage_restaurant_item_columns', 10, 2 );

function restaurant_manage_restaurant_item_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'price' :

			$price = rp_get_menu_item_price( $post_id );

			if ( !empty( $price ) )
				printf( __( '$%s', 'restaurant' ), $price );
			else
				_e( 'No price set.', 'restaurant' );

			break;

		case 'thumbnail' :

			the_post_thumbnail( 'restaurant-thumbnail' );
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}








?>