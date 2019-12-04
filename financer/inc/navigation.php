<?php
/**
 * Navigation
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

// Don't let Genesis load menus
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/**
 * Mobile Menu
 *
 */
function fs_site_header() {
	echo fs_mobile_menu_toggle();
	echo fs_search_toggle();

	echo '<nav' . fs_amp_class( 'nav-menu', 'active', 'menuActive' ) . ' role="navigation">';
	if( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'nav-primary' ) );
	}
	if( has_nav_menu( 'secondary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'container_class' => 'nav-secondary' ) );
	}
	echo '</nav>';

	echo '<div' . fs_amp_class( 'header-search', 'active', 'searchActive' ) . '>' . get_search_form( array( 'echo' => false ) ) . '</div>';
}
add_action( 'genesis_header', 'fs_site_header', 11 );

/**
 * Nav Extras
 *
 */
function fs_nav_extras( $menu, $args ) {

	if( 'primary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . fs_search_toggle() . '</li>';
	}

	if( 'secondary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . get_search_form( false ) . '</li>';
	}

	return $menu;
}
add_filter( 'wp_nav_menu_items', 'fs_nav_extras', 10, 2 );

/**
 * Search toggle
 *
 */
function fs_search_toggle() {
	$output = '<button' . fs_amp_class( 'search-toggle', 'active', 'searchActive' ) . fs_amp_toggle( 'searchActive', array( 'menuActive', 'mobileFollow' ) ) . '>';
		$output .= fs_icon( array( 'icon' => 'search', 'size' => 24, 'class' => 'open' ) );
		$output .= fs_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Search</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Mobile menu toggle
 *
 */
function fs_mobile_menu_toggle() {
	$output = '<button' . fs_amp_class( 'menu-toggle', 'active', 'menuActive' ) . fs_amp_toggle( 'menuActive', array( 'searchActive', 'mobileFollow' ) ) . '>';
		$output .= fs_icon( array( 'icon' => 'menu', 'size' => 24, 'class' => 'open' ) );
		$output .= fs_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Menu</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function fs_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = fs_icon( array( 'icon' => 'navigate-down', 'size' => 8, 'title' => 'Submenu Dropdown' ) );

		$output .= sprintf(
			'<button' . fs_amp_nav_dropdown( $args->theme_location, $depth ) . ' tabindex="-1">%s</button>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'fs_nav_add_dropdown_icons', 10, 4 );
