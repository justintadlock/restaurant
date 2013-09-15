<?php
/**
 * @package Restaurant
 * @subpackage Admin
 */

final class RP_Restaurant_Admin {

	/**
	 * @since 0.1.0
	 */
	private static $instance;

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function admin_menu() {

		add_submenu_page( 
			'edit.php?post_type=restaurant_item',
			__( 'Menu Comments', 'restaurant' ),
			__( 'Menu Comments', 'restaurant' ),
			'manage_restaurant',
			'edit-comments.php?post_type=restaurant_item'
		);

		add_filter( 'parent_file', array( $this, 'parent_file' ) );

		/* Load post meta boxes on the post editing screen. */
		add_action( 'load-post.php',     array( $this, 'load_post_meta_boxes' ) );
		add_action( 'load-post-new.php', array( $this, 'load_post_meta_boxes' ) );

		/* Only run our customization on the 'edit.php' page in the admin. */
		add_action( 'load-edit.php', array( $this, 'load_edit' ) );

		add_action( 'load-edit-comments.php', array( $this, 'load_edit_comments' ) );

		add_filter( 'manage_edit-restaurant_item_columns', array( $this, 'edit_restaurant_item_columns' ) );
		add_action( 'manage_restaurant_item_posts_custom_column', array( $this, 'manage_restaurant_item_columns' ), 10, 2 );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function load_edit_comments() {
		add_action( 'pre_get_comments', array( $this, 'pre_get_comments' ) );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function parent_file( $parent_file ) {
		global $self, $post_id;

		$screen    = get_current_screen();
		$post_type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : '';

		if ( 'edit-comments' === $screen->base ) {

			if ( 'restaurant_item' === $post_type || ( !empty( $post_id ) && 'restaurant_item' === get_post_type( $post_id ) ) ) {

				$parent_file = 'edit.php?post_type=restaurant_item';
				$self        = 'edit-comments.php?post_type=restaurant_item';

				add_filter( 'comment_status_links', array( $this, 'comment_status_links' ) );
			}
		}

		return $parent_file;
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function comment_status_links( $status_links ) {

		$new_status_links = array();

		foreach ( $status_links as $key => $value ) {

			preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', $value, $matches );

			if ( !empty( $matches[1] ) )
				$link = str_replace( $matches[1], add_query_arg( 'post_type', 'restaurant_item', $matches[1] ), $value );
			else
				$link = $value;

			$new_status_links[ $key ] = $link;

		}

		return $new_status_links;
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function pre_get_comments( $query ) {
		global $post_id;

		$screen    = get_current_screen();
		$post_type = isset( $_REQUEST['post_type'] ) ? sanitize_key( $_REQUEST['post_type'] ) : '';

		if ( ( 'restaurant_item' === $post_type ) || ( !empty( $post_id ) && 'restaurant_item' === get_post_type( $post_id ) ) ) {
			$query->query_vars['post_type'] = 'restaurant_item';
		}
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function load_edit() {
		$screen = get_current_screen();

		if ( !empty( $screen->post_type ) && 'restaurant_item' === $screen->post_type )
			add_filter( 'request', array( $this, 'request' ) );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function request( $vars ) {

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
	public function load_post_meta_boxes() {
		require_once( RESTAURANT_DIR . 'admin/meta-box-menu-item-price.php' );
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function edit_restaurant_item_columns( $columns ) {

		$columns['title']     = __( 'Menu Item', 'restaurant' );
		$columns['price']     = __( 'Price', 'restaurant' );
		$columns['thumbnail'] = '';

		$comments = $columns['comments'];

		unset( $columns['comments'] );

		unset( $columns['date'] );

		$columns['comments'] = $comments;


		return $columns;
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public function manage_restaurant_item_columns( $column, $post_id ) {

		switch( $column ) {

			case 'price' :

				$price = rp_get_formatted_menu_item_price( $post_id );

				echo !empty( $price ) ? $price : '&mdash;';

				break;

			case 'thumbnail' :

				the_post_thumbnail( 'restaurant-thumbnail' );
				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}

	/**
	 * @since  0.1.0
	 * @access public
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

RP_Restaurant_Admin::get_instance();

?>