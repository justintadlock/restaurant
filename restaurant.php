<?php
/**
 * Plugin Name: Restaurant
 * Plugin URI: http://themehybrid.com/plugins/restaurant
 * Description: A base plugin for building restaurant Web sites. This plugin allows you to manage a basic food and beverage menu. The purpose of it is to handle small restaurant sites while allowing for extension plugins to add more complex features.
 * Version: 1.0.0-beta-1
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * A plugin for setting up small restaurant sites.  This plugin was created as a simple base for theme 
 * authors to build custom restaurant themes.  It also serves as a foundation for other plugins to 
 * build from and add restaurant-related features.  This plugin merely handles a restaurant "menu".  In 
 * particular, it creates a 'restaurant_item' post type and 'restaurant_tag' taxonomy.  Other plugins 
 * should be created to extend the menu functionality.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Restaurant
 * @version    1.0.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2014, Justin Tadlock
 * @link       http://themehybrid.com/plugins/restaurant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Sets up and initializes the Restaurant plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
final class RP_Restaurant {

	/**
	 * Holds the instances of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Sets up needed actions/filters for the plugin to initialize.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
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

		/* Register activation hook. */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Defines constants for the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'RESTAURANT_VERSION', '1.0.0' );

		/* Set the database version number of the plugin. */
		define( 'RESTAURANT_DB_VERSION', 1 );

		/* Set constant path to the plugin directory. */
		define( 'RESTAURANT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set constant path to the plugin URI. */
		define( 'RESTAURANT_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}

	/**
	 * Loads files from the '/inc' folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
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
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function i18n() {
		load_plugin_textdomain( 'restaurant', false, 'restaurant/languages' );
	}

	/**
	 * Loads admin files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function admin() {

		if ( is_admin() ) {
			require_once( RESTAURANT_DIR . 'admin/class-restaurant-admin.php'    );
			require_once( RESTAURANT_DIR . 'admin/class-restaurant-settings.php' );
		}
	}

	/**
	 * On plugin activation, add custom capabilities to the 'administrator' role.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
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
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

RP_Restaurant::get_instance();
