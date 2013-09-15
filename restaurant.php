<?php
/**
 * Plugin Name: Restaurant
 * Plugin URI: https://github.com/justintadlock/restaurant
 * Description: Plugin for restaurants.
 * Version: 0.1.0-alpha-1
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 */

final class RP_Restaurant {

	/**
	 * @since 0.1.0
	 */
	private static $instance;

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

		/* Add custom rewrite rules. */
		add_action( 'init', array( $this, 'rewrite' ) );

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
		require_once( RESTAURANT_DIR . 'inc/default-filters.php' );
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
		load_plugin_textdomain( 'restaurant', false, 'restaurant/languages' );
	}

	/**
	 * Loads the admin file.
	 *
	 * @since 0.1.0
	 */
	function admin() {

		if ( is_admin() )
			require_once( RESTAURANT_DIR . 'admin/admin.php' );
	}

	/**
	 * @since  0.1.0
	 */
	public function rewrite() {
		add_rewrite_rule( '^' . rp_restaurant_menu_base() . '$', 'index.php?' . rp_restaurant_menu_base(), 'top' );
	}

	/**
	 * @since 0.1.0
	 */
	function activation() {

		$role = get_role( 'administrator' );

		if ( !empty( $role ) ) {
			$role->add_cap( 'manage_restaurant'       );
			$role->add_cap( 'create_restaurant_items' );
			$role->add_cap( 'edit_restaurant_items'   );
		}
	}

	/**
	 * @since 0.1.0
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

RP_Restaurant::get_instance();

?>