<?php
/**
 * @package Restaurant
 * @subpackage Admin
 */

final class RP_Restaurant_Admin {

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function setup() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function admin_menu() {

		add_submenu_page( 
			'edit.php?post_type=restaurant_item',
			__( 'Reviews', 'restaurant' ),
			__( 'Reviews', 'restaurant' ),
			'manage_restaurant',
			'edit-comments.php?comment_type=restaurant_review'
		);

		add_filter( 'parent_file', array( __CLASS__, 'parent_file' ) );

		/* Load post meta boxes on the post editing screen. */
		add_action( 'load-post.php',     array( __CLASS__, 'load_post_meta_boxes' ) );
		add_action( 'load-post-new.php', array( __CLASS__, 'load_post_meta_boxes' ) );

		/* Only run our customization on the 'edit.php' page in the admin. */
		add_action( 'load-edit.php', array( __CLASS__, 'load_edit' ) );

		add_filter( 'manage_edit-restaurant_item_columns', array( __CLASS__, 'edit_restaurant_item_columns' ) );
		add_action( 'manage_restaurant_item_posts_custom_column', array( __CLASS__, 'manage_restaurant_item_columns' ), 10, 2 );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function parent_file( $parent_file ) {
		global $self, $post_id;

		$screen = get_current_screen();

		if ( 'edit-comments' === $screen->base && isset( $_GET['comment_type'] ) && 'restaurant_review' === $_GET['comment_type'] ) {

			$parent_file = 'edit.php?post_type=restaurant_item';
			$self        = 'edit-comments.php?comment_type=restaurant_review';
		}

		elseif ( !empty( $post_id ) && 'restaurant_item' === get_post_type( $post_id ) ) {
			$parent_file = 'edit.php?post_type=restaurant_item';
			$self        = 'edit-comments.php?comment_type=restaurant_review';
		}

		return $parent_file;
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function load_edit() {
		$screen = get_current_screen();

		if ( !empty( $screen->post_type ) && 'restaurant_item' === $screen->post_type )
			add_filter( 'request', array( __CLASS__, 'request' ) );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function request( $vars ) {

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

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function load_post_meta_boxes() {
		require_once( RESTAURANT_DIR . 'admin/meta-box-menu-item-price.php' );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function edit_restaurant_item_columns( $columns ) {

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

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function manage_restaurant_item_columns( $column, $post_id ) {

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
}

RP_Restaurant_Admin::setup();

?>