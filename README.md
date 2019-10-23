# wp-bootstrap-navlist-walker

[![Code Climate](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker/badges/gpa.svg)](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker)
[![Test Coverage](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker/badges/coverage.svg)](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker/coverage)
[![Issue Count](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker/badges/issue_count.svg)](https://codeclimate.com/github/wp-bootstrap/wp-bootstrap-navlist-walker)

**Custom list navigation for WordPress themes utilizing the Bootstrap framework. The package includes a custom walker class & Less file with mixins.**


**Walker Class Features**
+ Structures menu HTML in a Bootstrap format
+ Standard WordPress classes removed
+ Child items are only rendered when parent is active
+ Structured to support  Bootstrap Affix & Scroll Spy

**LESS Features**
+ Custom list menu style
+ Support for light and dark menus
+ 12 Included color schemes
+ Mixin to quickly create custom color schemes

** This is a utility class that is intended to format your WordPress theme menu with the correct syntax and classes to utilize the Bootstrap navigation, and does not include the required Bootstrap JS files. You will have to include them manually. **

## Installation

Place **wp_bootstrap_navlist_walker.php** in your WordPress theme folder `/wp-content/theme/your-theme/`

Open your WordPress themes **functions.php** file  `/wp-content/theme/your-theme/functions.php` and add the following code:

```php
// Register Custom Navigation Walker
require_once('wp_bootstrap_navlist_walker.php');
```

## Usage

Update your `wp_nav_menu()` function in `header.php` to use the new walker by adding a "walker" item to the wp_nav_menu array.

```php
<?php
	wp_nav_menu( array(
		'menu'              => 'primary',
		'theme_location'    => 'primary',
		'depth'             => 2,
		'container'         => 'false',
		'menu_class'        => 'nav nav-list',
		'fallback_cb'       => 'wp_bootstrap_navlist_walker::fallback',
		'walker'			=> new wp_bootstrap_navlist_walker())
	);
?>
```

Your menu will now be formatted with the correct syntax and classes to implement Bootstrap dropdown navigation. 

You will also want to declare your new menu in your `functions.php` file.

```php
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'THEMENAME' ),
) );
```

## Displaying the Menu 

To display the menu you must associate your menu with your theme location. You can do this by selecting your theme location in the *Theme Locations* list wile editing a menu in the WordPress menu manager.

## Glyphicons

To add an Icon to your link simple place the Glyphicon class name in the links **Title Attribute** field and the class will do the rest. IE `glyphicon-bullhorn`


## Disabled Links

To set a disabled link simply set the **Title Attribute** to `disabled` and the class will do the rest. 


## LESS Style

The included nav-list.less comes with 12 menus styles, and a bunch of handy custom LESS mixins to make generating your own styles quick and easy. 

### Included Styles

To switch out styles simply add the desired css classes to you `wp_nav_menu` declarations `menu_class` variable.

`'menu_class' => 'nav nav-list-inverse nav-list-info'`

**.nav-list**    


**.nav-list-primary**    


**.nav-list-success**    


**.nav-list-warning**    


**.nav-list-info**    


**.nav-list-danger**    


**.nav-list-inverse**    


**.nav-list-inverse .nav-list-primary**    


**.nav-list-inverse .nav-list-success**    

**.nav-list-inverse .nav-list-warning**    

**.nav-list-inverse .nav-list-info**    

**.nav-list-inverse .nav-list-danger**    

### Custom Styles

The included LESS file includes some powerful mixins that make creating a custom style incredibly simple. At it's simplest you can create a custom style by using the `.generate-nav-list` mixin and passing a single color.

```css
.nav-list-peach {
	.generate-nav-list( #ffbf6d );
}
```
When you call the `.generate-nav-list()` mixin it compares your @primary & @secondary colors luminance values, then based on the luminance difference generates text, border, and highlight colors.

Here is a rundown of all of the `.generate-nav-list()` variables. 

`.generate-nav-list (@primary, @secondary, @border-width, @border-radius);`

**@primary** - *Required* - Your menus foreground color for highlighted menu items. On a light colored menu this color is also use to generate accent colors. 

**@secondary** - *Default: #fff;* - Your menus background color. On a dark colored menu this color is also use to generate accent colors.

**@border-width** - *Default: 1px;* - The border width around the menu in pixels.

**@border-radius** - *Default: @border-radius-base* - The menus border radius in pixels.


## Affix & Scrollspy

wp-bootstrap-navlist-walker is setup to support Bootstrap's Affix & Scrollspy javascript. 

If you have the Bootstrap Affix javascript loaded you can affix the menu by wrapping it in a `<div>` in including the appropriate data attributes. Visit http://getbootstrap.com/javascript/#affix for more info.

```php
<div data-spy="affix" data-offset-top="200">
	<?php
		wp_nav_menu( array(
			'menu'              => 'primary',
			'theme_location'    => 'primary',
			'depth'             => 2,
			'container'         => 'false',
			'menu_class'        => 'nav nav-list-inverse nav-list-info',
			'fallback_cb'       => 'wp_bootstrap_sidenav_walker::fallback',
			'walker'			=> new wp_bootstrap_sidenav_walker())
		);
	?>
</div>
```

If you have the Bootstrap Scrollspy javascript loaded you can Scrollspy the sub menu items by following the steps at http://getbootstrap.com/javascript/#scrollspy and spying the `#nav-sublist` ID.

## Changelog

**1.0**
+ Initial Class


