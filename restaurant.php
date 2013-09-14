<?php
/**
 * Plugin Name: Restaurant
 * Plugin URI: https://github.com/justintadlock/restaurant
 * Description: Plugin for restaurants.
 * Version: 0.1.0-alpha-1
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 */

final class Restaurant_Loader {

	public $restaurant_base = 'menu';

	public $is_menu_home  = false;

	/**
	 * @since 0.1.0
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );

		/* Load the admin files. */
		add_action( 'plugins_loaded', array( $this, 'admin' ), 4 );

		add_action( 'init', array( $this, 'rewrite' ) );

		add_action( 'parse_request', array( $this, 'parse_request' ) );

		/* Register activation hook. */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * @since 0.1.0
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'RESTAURANT_VERSION', '0.1.0' );

		/* Set the database version number of the plugin. */
		define( 'RESTAURANT_DB_VERSION', 1 );

		/* Set constant path to the plugin directory. */
		define( 'RESTAURANT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set constant path to the plugin URI. */
		define( 'RESTAURANT_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}

	/**
	 * Include needed files.
	 *
	 * @since 0.1.0
	 */
	function includes() {

		require_once( RESTAURANT_DIR . 'inc/core.php'       );
		require_once( RESTAURANT_DIR . 'inc/post-types.php' );
		require_once( RESTAURANT_DIR . 'inc/taxonomies.php' );
		require_once( RESTAURANT_DIR . 'inc/template.php'   );
	}

	/**
	 * Loads the translation files.
	 *
	 * @since 0.1.0
	 */
	function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'restaurant', false, 'restaurant/languages' );
	}

	/**
	 * Loads the admin file.
	 *
	 * @since 0.1.0
	 */
	function admin() {

		if ( is_admin() ) {
			require_once( RESTAURANT_DIR . 'admin/admin.php' );
	//		require_once( RESTAURANT_ADMIN . 'settings.php' );
		}
	}

	/**
	 * @since  0.1.0
	 */
	public function rewrite() {
		add_rewrite_rule( '^' . $this->restaurant_base . '$', 'index.php?' . $this->restaurant_base, 'top' );
	}

	/**
	 * @since  0.1.0
	 */
	public function parse_request( $wp ) {

		if ( isset( $wp->query_vars[ $this->restaurant_base ] ) )
			$this->is_menu_home = true;
	}

	/**
	 * @since 0.1.0
	 */
	function activation() {

		/* Get the administrator and add required capabilities if it exists. */
		$role = get_role( 'administrator' );

		if ( !empty( $role ) ) {

			/* Add capabilities for the menu item post type. */
			$role->add_cap( 'manage_restaurant' );
			$role->add_cap( 'create_restaurant_items' );
			$role->add_cap( 'edit_restaurant_items' );
		}
	}
}

global $restaurant;
$restaurant = new Restaurant_Loader();

?>