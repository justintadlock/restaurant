# Restaurant

Let's hope this doesn't break. :)

A plugin for creating various features for restaurant sites.  This plugin should be a simple base for restaurants. Don't think of it as a plugin for the fanciest restaurant in the world with 20 daily specials, 5-course meals, and every other thing under the sun.  Think Mom-and-Pop restaurants, cafes, small diners, and so on.

Use this plugin as a base for the smallest restaurants.  Then, build add-on plugins to extend this for larger-scale restaurants.

## Version 0.1.0 goals

* Create a solid foundation to extend in the future.
* Handle menus:
	* Post type: `restaurant_item` (individual menu items)
	* Taxonomy: `restaurant_tag` (generic taxonomy)
* Set up structure for menus:
	* `/menus` - Menu items archive.
	* `/menus/items/slug` - Single menu item.
	* `/menus/tags/slug` - Single tag archive.

## Future goals

* Build plugins that extend this plugin:
	* Menu item reviews.
	* Meal times taxonomy.
	* Courses taxonomy.

## Template tags

* `rp_is_restaurant()` - Viewing any restaurant page?
* `rp_get_menu_item_price()` - Returns the price of a menu item.
* `rp_menu_item_price()` - Echos the price.
* `rp_get_formatted_menu_item_price()` - Returns the formatted (with dollar sign) menu item price (filterable for other currencies).
* `rp_formatted_menu_item_price()` - Echos the formatted price.

## Themes

* Need to add `add_theme_support( 'restaurant' )` in `functions.php`.
* Templates needed:
	* `archive-restaurant_item.php` - (menu item archive).
	* `single-restaurant_item.php` - (single menu item view).
	* `taxonomy-restaurant_tag.php` - (single tag archive).

## Plugins

* When creating custom post types or taxonomies related to the restaurant menu, make sure to build with the `rp_restaurant_menu_base()` function, which defines the URL base for anything related to the menu.  So, a `course` taxonomy's rewrite slug should be `rp_restaurant_menu_base() . '/course'`.
* Custom taxonomy and post type names should be prefixed with `restaurant_`.  So, `course` becomes `restaurant_course`.