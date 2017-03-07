<?php
/**
 * WP Bootstrap Navlist Walker
 *
 * @package WP-Bootstrap-Navlist Walker
 */

	/**
	 * Class Name: WP Bootstrap Navlist Walker
	 * Plugin Name: WP Bootstrap Navlist Walker
	 * Plugin URI: https://github.com/wp-bootstrap/wp-bootstrap-navlist-walker
	 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
	 * Version: 1.0.0
	 * Author: WP-Bootstrap
	 * Author URI: https://github.com/wp-bootstrap
	 * GitHub URI: https://github.com/wp-bootstrap/wp-bootstrap-navlist-walker
	 * GitHub Plugin URI: https://github.com/wp-bootstrap/wp-bootstrap-navlist-walker
	 * GitHub Branch: master
	 * License: GPL-3.0+
	 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
	 */

/**
 * WP Bootstrap Navlist Walker.
 *
 * @extends Walker_Nav_Menu
 */
class WP_Bootstrap_Navlist_Walker extends Walker_Nav_Menu {

	/**
	 * See Walker: start_lvl function.
	 *
	 * @since 3.0.0
	 * @access public
	 * @param mixed $output  Passed by reference. Used to append additional content.
	 * @param int   $depth (default: 0) Depth of page. Used for padding.
	 * @param array $args (default: array()) An array of arguments. See wp_nav_menu.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<div id=\"nav-sublist\"><ul role=\"menu\" class=\"nav nav-sublist\">\n";
	}

	/**
	 * See Walker: end_lvl function.
	 *
	 * @access public
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param int   $depth (default: 0) Depth of menu item. Used for padding.
	 * @param array $args (default: array()) An array of arguments. See wp_nav_menu.
	 * @return void
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= 0 === $depth ? "$indent</ul>\n" : "$indent</div></ul>\n";
	}

	/**
	 * See Walker: start_el() function.
	 *
	 * @access public
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param mixed $item Menu item data object.
	 * @param int   $depth (default: 0) Depth of menu item. Used for padding.
	 * @param array $args (default: array()) Default Arguments.
	 * @param int   $id (default: 0) Menu item ID.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		// Check if the link it disables Disabled, Active or regular menu item.
		if ( stristr( $item->attr_title, 'disabled' ) ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a name="' . esc_attr( $item->title ) . '">' . esc_attr( $item->title ) . '</a>';
		} else { $output .= $item->current ? $indent . '<li class="active">' : $indent . '<li>';
		}

		$atts = array();
		$atts['title']  = ! empty( $item->title )	? $item->title	: '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
		$atts['href'] 	= ! empty( $item->url ) 	? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/*
		 * Glyphicons
		 * ===========
		 * We check to see there is a value in the attr_title property. If the attr_title
		 * property is NOT null or divider we apply it as the class name for the glyphicon.
		 */
		$item_output = '';

		if ( ! empty( $item->attr_title ) ) {
			$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
		} else { $item_output .= '<a'. $attributes .'>';
		}

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * @access public
	 * @since 2.5.0
	 * @param mixed $element Data object.
	 * @param mixed $children_elements List of elements to continue traversing.
	 * @param mixed $max_depth Max depth to traverse.
	 * @param mixed $depth Depth of current element.
	 * @param mixed $args Arguments.
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		// If parent is not current item, don't output children.
		if ( ! $element->current ) {
			parent::unset_children( $element, $children_elements );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

				/* Get Arguments. */
				$container = $args['container'];
				$container_id = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class = $args['menu_class'];
				$menu_id = $args['menu_id'];
			if ( $container ) {
				echo '<' . esc_attr( $container );
				if ( $container_id ) {
					echo ' id="' . esc_attr( $container_id ) . '"';
				}
				if ( $container_class ) {
					echo ' class="' . sanitize_html_class( $container_class ) . '"'; }
				echo '>';
			}
				echo '<ul';
			if ( $menu_id ) {
				echo ' id="' . esc_attr( $menu_id ) . '"'; }
			if ( $menu_class ) {
				echo ' class="' . esc_attr( $menu_class ) . '"'; }
				echo '>';
				echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_attr( 'Add a menu', '' ) . '</a></li>';
				echo '</ul>';
			if ( $container ) {
				echo '</' . esc_attr( $container ) . '>';
			}
		}
	}
}
