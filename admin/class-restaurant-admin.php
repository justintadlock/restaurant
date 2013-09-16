<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package    Restaurant
 * @subpackage Admin
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class RP_Restaurant_Admin {

	/**
	 * Holds the instances of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Sets up needed actions/filters for the admin to initialize.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Load post meta boxes on the post editing screen. */
		add_action( 'load-post.php',     array( $this, 'load_post_meta_boxes' ) );
		add_action( 'load-post-new.php', array( $this, 'load_post_meta_boxes' ) );

		/* Only run our customization on the 'edit.php' page in the admin. */
		add_action( 'load-edit.php', array( $this, 'load_edit' ) );

		/* Modify the columns on the "menu items" screen. */
		add_filter( 'manage_edit-restaurant_item_columns', array( $this, 'edit_restaurant_item_columns' ) );
		add_action( 'manage_restaurant_item_posts_custom_column', array( $this, 'manage_restaurant_item_columns' ), 10, 2 );
	}

	/**
	 * Adds a custom filter on 'request' when viewing the edit menu items screen in the admin.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function load_edit() {
		$screen = get_current_screen();

		if ( !empty( $screen->post_type ) && 'restaurant_item' === $screen->post_type ) {
			add_filter( 'request', array( $this, 'request' ) );
			add_action( 'restrict_manage_posts', array( $this, 'tags_dropdown' ) );
		}
	}

	/**
	 * Filter on the 'request' hook to change the 'order' and 'orderby' query variables when 
	 * viewing the "edit menu items" screen in the admin.  This is to order the menu items 
	 * alphabetically.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $vars
	 * @return array
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
	 * Loads custom meta boxes on the "add new menu item" and "edit menu item" screens.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function load_post_meta_boxes() {
		require_once( RESTAURANT_DIR . 'admin/class-restaurant-post-meta-boxes.php' );
	}

	/**
	 * Renders a restaurant tags dropdown on the "menu items" screen table nav.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function tags_dropdown() {

		$tag   = isset( $_GET['restaurant_tag'] ) ? esc_attr( $_GET['restaurant_tag'] ) : '';
		$terms = get_terms( 'restaurant_tag' );

		if ( !empty( $terms ) ) {
			echo '<select name="restaurant_tag" class="postform">';

			echo '<option value="' . selected( '', $tag, false ) . '">' . __( 'View all tags', 'restaurant' ) . '</option>';

			foreach ( $terms as $term )
				printf( '<option value="%s"%s>%s (%s)</option>', esc_attr( $term->slug ), selected( $term->slug, $tag, false ), esc_html( $term->name ), esc_html( $term->count ) );

			echo '</select>';
		}
	}

	/**
	 * Filters the columns on the "menu items" screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $columns
	 * @return array
	 */
	public function edit_restaurant_item_columns( $columns ) {

		/* Add custom columns and overwrite the 'title' column. */
		$columns['title']     = __( 'Menu Item',      'restaurant' );
		$columns['price']     = __( 'Price',          'restaurant' );
		$columns['thumbnail'] = __( 'Featured Image', 'restaurant' );

		/* Get the 'comments' and 'taxonomy-restaurant_tag' column values and unset them. */
		$comments = $columns['comments'];
		unset( $columns['comments'] );

		$tags = $columns['taxonomy-restaurant_tag'];
		unset( $columns['taxonomy-restaurant_tag'] );

		/* Unset the 'date' column. */
		unset( $columns['date'] );

		/* Append the 'taxonomy-restaurant_tag' and 'comments' columns to the end. */
		$columns['taxonomy-restaurant_tag'] = $tags;
		$columns['comments'] = $comments;

		/* Return the columns. */
		return $columns;
	}

	/**
	 * Add output for custom columns on the "menu items" screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $column
	 * @param  int     $post_id
	 * @return void
	 */
	public function manage_restaurant_item_columns( $column, $post_id ) {

		switch( $column ) {

			case 'price' :

				$price = rp_get_formatted_menu_item_price( $post_id );

				echo !empty( $price ) ? $price : '&mdash;';

				break;

			case 'thumbnail' :

				$thumb = get_the_post_thumbnail( $post_id, 'restaurant-thumbnail' );

				echo !empty( $thumb ) ? $thumb : '&mdash;';

				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

RP_Restaurant_Admin::get_instance();

?>