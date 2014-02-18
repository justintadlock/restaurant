=== Restaurant ===

Contributors: greenshady
Donate link: http://themehybrid.com/donate
Tags: custom post type, taxonomy, restaurant
Requires at least: 3.7
Tested up to: 3.8.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A restaurant and menu item manager for small restaurant sites, which can be extended for larger sites.

== Description ==

A plugin for setting up small restaurant sites.  This plugin was created as a simple base for theme authors to build custom restaurant themes.  It also serves as a foundation for other plugins to build from and add restaurant-related features.  This plugin merely handles a restaurant "menu".  In particular, it creates a 'restaurant_item' post type and 'restaurant_tag' taxonomy.  Other plugins should be created to extend the menu functionality.

### Themes

Currently, the following themes integrate with the Restaurant plugin:

* [Ravintola](http://devpress.com/themes/ravintola/)

### Professional Support

If you need professional plugin support from me, the plugin author, you can access the support forums at [Theme Hybrid](http://themehybrid.com/support), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 40,000+ users (and growing).

### Plugin Development

If you're a theme author, plugin author, or just a code hobbyist, you can follow the development of this plugin on it's [GitHub repository](https://github.com/justintadlock/restaurant). 

### Donations

Yes, I do accept donations.  If you want to buy me a beer or whatever, you can do so from my [donations page](http://themehybrid.com/donate).  I appreciate all donations, no matter the size.  Further development of this plugin is not contingent on donations, but they are always a nice incentive.

== Installation ==

1. Uzip the `restaurant.zip` folder.
2. Upload the `restaurant` folder to your `/wp-content/plugins` directory.
3. In your WordPress dashboard, head over to the *Plugins* section.
4. Activate *Restaurant*.

== Frequently Asked Questions ==

### Why was this plugin created?

The purpose of the Restaurant plugin is to create a base for building restaurant Web sites.  At its core, it's a plugin for mom-and-pop restaurants to handle basic functionality like putting their menu online.  However, it should serve as a base for more advanced functionality.

### How do I use the plugin?

The restaurant menu functionality works just like posts and pages in WordPress.  You'll get a new "Restaurant" menu in the admin.  From there, you can manage your restaurant.  Add-on plugins may also add new items to this menu.

### I'm getting a 404 when viewing menu items.

This can happen, but don't worry.  Simply visit the "Settings > Permalinks" page in your WordPress admin.  This will flush the rewrite rules and correct the problem.  Just visit that admin screen.  There's no need to save.

### What post type and taxonomy names are used?

* `restaurant_item` - Post type name for menu items.
* `restaurant_tag` - Taxonomy name for tags.

### Can I create custom templates for this in my theme?

Yes.  Absolutely.  The following templates are useful:

* `single-restaurant_item.php` - Single post view of a restaurant item.
* `archive-restaurant_item.php` - Archive view of all restaurant items.
* `taxonomy-restaurant_tag.php` - Restaurant tag archive view.

### How do I show the menu title in my theme?

This is a basic WordPress function.  You simply need to use this code in your template:

	<?php post_type_archive_title(); ?>

### How do I show the menu description in my theme?

This is also basic WordPress functionality. Simply add this code to your template:

	<?php echo get_post_type_object( get_query_var( 'post_type' ) )->description; ?>

### Will you add feature X?

I highly encourage feedback on all features. The purpose of this plugin is to be extremely lightweight and have minimal features.  However, more advanced features will be added in the form of add-on plugins.  I already have several in mind, but I'd really love to hear from you.

### Can I create an add-on plugin?

Certainly.  If you're a plugin developer, please get in touch with me.  I want to build a robust developer and user community around this plugin.  It has a ton of potential, especially when we start talking about all the cool features that we can add onto this and make for a great restaurant experience.

== Screenshots ==

1. Restaurant menu admin screen
2. Ravintola theme using the plugin

== Changelog ==

### Version 1.0.0

* Everything is new!