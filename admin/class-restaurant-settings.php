<?php
/**
 * Handles custom post meta boxes for the 'restaurant_item' post type.
 *
 * @package    Restaurant
 * @subpackage Admin
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class RP_Restaurant_Settings {

	/**
	 * Holds the instances of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Settings page name.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    string
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function admin_menu() {

		$this->settings_page = add_submenu_page( 
			'edit.php?post_type=restaurant_item',
			__( 'Settings', 'restaurant' ),
			__( 'Settings', 'restaurant' ),
			apply_filters( 'restaurant_settings_capability', 'manage_options' ),
			'restaurant-settings',
			array( $this, 'settings_page' )
		);

		if ( !empty( $this->settings_page ) ) {

			/* Register the plugin settings. */
			add_action( 'admin_init', array( $this, 'register_settings' ) );

			/* Add media for the settings page. */
			add_action( 'admin_enqueue_scripts',             array( $this, 'enqueue_scripts' ) );
			add_action( "admin_head-{$this->settings_page}", array( $this, 'print_scripts'   ) );

			/* Load the meta boxes. */
			add_action( 'add_meta_boxes_restaurant', array( $this, 'add_meta_boxes' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function register_settings() {
		register_setting( 'restaurant_settings', 'restaurant_settings', array( $this, 'validate_settings' ) );
	}

	/**
	 * Adds the plugin settings meta boxes.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function add_meta_boxes() {

		/* Add the 'About' meta box. */
		add_meta_box( 'restaurant-about', _x( 'About', 'meta box', 'restaurant' ), array( $this, 'meta_box_about' ), 'restaurant-settings', 'side', 'high' );

		/* Add the 'Donate' meta box. */
		add_meta_box( 'restaurant-donate', _x( 'Like this plugin?', 'meta box', 'restaurant' ), array( $this, 'meta_box_donate' ), 'restaurant-settings', 'side', 'default' );

		/* Add the 'Support' meta box. */
		add_meta_box( 'restaurant-support', _x( 'Support', 'meta box', 'restaurant' ), array( $this, 'meta_box_support' ), 'restaurant-settings', 'side', 'low' );

		/* Add the 'Menu Settings' meta box. */
		add_meta_box( 'restaurant-menu', _x( 'Menu Settings', 'meta box', 'restaurant' ), array( $this, 'meta_box_menu' ), 'restaurant-settings', 'normal', 'high' );

	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function validate_settings( $settings ) {

		$settings['restaurant_item_archive_title'] = strip_tags( $settings['restaurant_item_archive_title'] );

		/* Kill evil scripts. */
		if ( !current_user_can( 'unfiltered_html' ) )
			$settings['restaurant_item_archive_title'] = stripslashes( wp_filter_post_kses( addslashes( $settings['restaurant_item_archive_title'] ) ) );

		/* Return the validated/sanitized settings. */
		return $settings;
	}

	/**
	 * Renders the settings page.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function settings_page() {

		$plugin_data = get_plugin_data( RESTAURANT_DIR . 'restaurant.php' );

		do_action( 'add_meta_boxes',            'restaurant-settings', $plugin_data );
		do_action( 'add_meta_boxes_restaurant', 'restaurant-settings', $plugin_data );

		?>
		<div class="wrap">

			<?php screen_icon(); ?>

			<h2><?php _e( 'Restaurant Settings', 'restaurant' ); ?></h2>

			<?php settings_errors(); ?>

			<div id="poststuff">

				<form method="post" action="options.php">

					<?php settings_fields( 'restaurant_settings'                            ); ?>
					<?php wp_nonce_field(  'closedpostboxes', 'closedpostboxesnonce', false ); ?>
					<?php wp_nonce_field(  'meta-box-order',  'meta-box-order-nonce', false ); ?>

					<div class="metabox-holder">

						<div class="post-box-container column-1 normal">
							<?php do_meta_boxes( 'restaurant-settings', 'normal', $plugin_data ); ?>
						</div><!-- .post-box-container -->

						<div class="post-box-container column-2 side">
							<?php do_meta_boxes( 'restaurant-settings', 'side', $plugin_data ); ?>
						</div><!-- .post-box-container -->

					</div><!-- metabox-holder -->

					<?php submit_button( esc_attr__( 'Update Settings', 'restaurant' ) ); ?>

				</form>

			</div><!-- #poststuff -->

		</div><!-- .wrap --><?php
	}

	/**
	 * Loads scripts and styles.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string  $hook_suffix
	 * @return void
	 */
	function enqueue_scripts( $hook_suffix ) {

		if ( $hook_suffix == $this->settings_page ) {
			wp_enqueue_script( 'common' );
			wp_enqueue_script( 'wp-lists' );
			wp_enqueue_script( 'postbox' );

			wp_enqueue_style( 'restaurant-admin', RESTAURANT_URI . 'css/admin.css', false, '20130916', 'screen' );
		}
	}

	/**
	 * Prints scripts for the settings page meta boxes.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function print_scripts() { ?>
		<script type="text/javascript">
		jQuery(document).ready( 
			function() {
				jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );
				postboxes.add_postbox_toggles( 'restaurant-settings' );
			}
		);
		</script>
	<?php }

	/**
	 * Settings about meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $object
	 * @param  array   $box
	 * @return void
	 */
	function meta_box_about( $object, $box ) {

		$plugin_data = $object; ?>

		<p>
			<strong><?php _e( 'Version:', 'restaurant' ); ?></strong> 
			<?php echo $plugin_data['Version']; ?>
		</p>
		<p>
			<strong><?php _e( 'Description:', 'restaurant' ); ?></strong> 
			<?php echo $plugin_data['Description']; ?>
		</p>
	<?php }

	/**
	 * Settings donate meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $object
	 * @param  array   $box
	 * @return void
	 */
	function meta_box_donate( $object, $box ) { ?>

		<p><?php _e( "Here's how you can give back:", 'restaurant' ); ?></p>

		<ul>
			<li><a href="http://wordpress.org/extend/plugins/restaurant" title="<?php esc_attr_e( 'Members on the WordPress plugin repository', 'restaurant' ); ?>"><?php _e( 'Give the plugin a good rating.', 'restaurant' ); ?></a></li>
			<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=3687060" title="<?php esc_attr_e( 'Donate via PayPal', 'restaurant' ); ?>"><?php _e( 'Donate a few dollars.', 'restaurant' ); ?></a></li>
			<li><a href="http://amzn.com/w/31ZQROTXPR9IS" title="<?php esc_attr_e( "Justin Tadlock's Amazon Wish List", 'restaurant' ); ?>"><?php _e( 'Get me something from my wish list.', 'restaurant' ); ?></a></li>
		</ul>
	<?php
	}

	/**
	 * Settings support meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $object
	 * @param  array   $box
	 * @return void
	 */
	function meta_box_support( $object, $box ) { ?>
		<p>
			<?php printf( __( 'Support for this plugin is provided via the support forums at %s. If you need any help using it, please ask your support questions there.', 'restaurant' ), '<a href="http://themehybrid.com/support" title="' . esc_attr__( 'Theme Hybrid Support Forums', 'restaurant' ) . '">' . __( 'Theme Hybrid', 'restaurant' ) . '</a>' ); ?>
		</p>
	<?php }

	/**
	 * Settings menu meta box.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $object
	 * @param  array   $box
	 * @return void
	 */
	public function meta_box_menu( $object, $box ) { 

		$settings = get_option( 'restaurant_settings', rp_get_default_settings() ); ?>

		<p>
			<?php printf( __( "Your restaurant's menu is locted at %s.", 'restaurant' ), '<a href="' . get_post_type_archive_link( 'restaurant_item' ) . '"><code>' . get_post_type_archive_link( 'restaurant_item' ) . '</code></a>' ); ?>
		</p>

		</p>

		<p>
			<label for="restaurant_settings-restaurant_item_archive_title"><?Php _e( 'Menu archive title:', 'restaurant' ); ?></label>
			<input type="text" class="widefat" name="restaurant_settings[restaurant_item_archive_title]" id="restaurant_settings-restaurant_item_archive_title" value="<?php echo esc_attr( $settings['restaurant_item_archive_title'] ); ?>" />
		</p>

		<p>
			<label for="restaurant_settings-restaurant_item_description"><?Php _e( 'Menu items description:', 'restaurant' ); ?></label>
			<textarea class="widefat" name="restaurant_settings[restaurant_item_description]" id="restaurant_settings-restaurant_item_description" rows="4"><?php echo esc_textarea( $settings['restaurant_item_description'] ); ?></textarea>
			<label for="restaurant_settings-restaurant_item_description"><?php _e( "Custom description for your restaurant's menu.  You may use <abbr title='Hypertext Markup Language'>HTML</abbr>. Your theme may or may not display this description.", 'restaurant' ); ?></label>
		</p>

	<?php }

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

RP_Restaurant_Settings::get_instance();

?>