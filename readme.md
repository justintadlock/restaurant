# Restaurant

Let's hope this doesn't break. :)

A plugin for creating various features for restaurant sites.

## Version 0.1.0 goals

* Create a solid foundation to extend in the future.
* Handle menus:
	* Post type: `restaurant_item` (individual menu items)
	* Comment type: `restaurant_review` (reviews on menu items)
	* Taxonomy: `restaurant_meal` (meal times like breakfast, lunch, dinner, etc.)
* Set up structure for menus:
	* `/menus` - Home page (theme must have custom template named `restaurant-menu.php` for this).
	* `/menus/items` - Menu items archive.
	* `/menus/items/slug` - Single menu item
	* `/menus/meals` - Page for listing meal times (may or may not include this in first go).
	* `/menus/meals/slug` - Meal time archives.

## Template tags

* `rp_is_restaurant_page()` - Viewing any restaurant page?
* `rp_is_menu_home()` - Viewing the menu root/home page?
* `rp_is_menu_item()` - Viewing a single menu item?
* `rp_is_menu_meal()` - Viewing a meal archive?
* `rp_supports_reviews()` - Does the site support reviews on its menu items?
* `rp_get_menu_item_price()` - Returns the price of a menu item.

## Themes

* Need to add `add_theme_support( 'restaurant' )` in `functions.php`.
* Templates needed:
	* `restaurant-menu.php` - (treat as if it were a custom page template).
	* `archive-restaurant_item.php` - (menu item archive).
	* `single-restaurant_item.php` - (single menu item view).
	* `taxonomy-restaurant_meal.php` - (meal time archives).