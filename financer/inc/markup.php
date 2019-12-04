<?php
/**
 * Markup
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

/**
 * Add '.nav-menu' class to nav menus
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function fs_nav_menu_class( $open, $args ) {
	$open = str_replace( $args['context'], $args['context'] . ' nav-menu', $open );
	return $open;
}
add_filter( 'genesis_markup_nav-primary_open', 'fs_nav_menu_class', 10, 2 );
add_filter( 'genesis_markup_nav-secondary_open', 'fs_nav_menu_class', 10, 2 );

/**
 * Change '.content-sidebar-wrap' to '.content-area'
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function fs_change_content_sidebar_wrap( $attributes ) {
	$attributes['class'] = 'content-area';
	return $attributes;
}
add_filter( 'genesis_attr_content-sidebar-wrap', 'fs_change_content_sidebar_wrap' );

/**
 * Change '.content' to '.site-main'
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function fs_change_content( $attributes ) {
	$attributes['class'] = 'site-main';
	return $attributes;
}
add_filter( 'genesis_attr_content', 'fs_change_content' );

/**
 * Add #main-content to .site-inner
 *
 */
function fs_site_inner_id( $attributes ) {
	$attributes['id'] = 'main-content';
	return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'fs_site_inner_id' );

/**
 * Remove padding from .site-inner
 *
 */
function fs_site_inner_no_padding( $attributes ) {
	$attributes['class'] .= ' full';
	return $attributes;
}
//add_filter( 'genesis_attr_site-inner', 'fs_site_inner_no_padding' );

/**
 * Change skip link to #main-content
 *
 */
function fs_main_content_skip_link( $skip_links ) {

	$old = $skip_links;
	$skip_links = array();

	foreach( $old as $id => $label ) {
		if( 'genesis-content' == $id )
			$id = 'main-content';
		$skip_links[ $id ] = $label;
	}

	return $skip_links;
}
add_filter( 'genesis_skip_links_output', 'fs_main_content_skip_link' );

/**
 * Archive Description markup
 *
 */
function fs_archive_description_markup( $markup ) {
	return str_replace( array( '<div', '</div' ), array( '<header', '</header' ), $markup );
}
add_filter( 'genesis_markup_posts-page-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_posts-page-description_close', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_taxonomy-archive-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_taxonomy-archive-description_close', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_author-archive-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_author-archive-description_close', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_cpt-archive-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_cpt-archive-description_close', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_date-archive-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_date-archive-description_close', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_search-description_open', 'fs_archive_description_markup' );
add_filter( 'genesis_markup_search-description_close', 'fs_archive_description_markup' );

/**
 * Archive Pagination markup
 *
 */
function fs_archive_pagination_markup( $markup ) {
	return str_replace( array( '<div', '</div' ), array( '<nav', '</nav' ), $markup );
}
add_filter( 'genesis_markup_archive-pagination_open', 'fs_archive_pagination_markup' );
add_filter( 'genesis_markup_archive-pagination_close', 'fs_archive_pagination_markup' );

add_filter( 'genesis_attr_cpt-archive-description', 'genesis_attributes_cpt_archive_description' );

/**
 * Search Header Classes
 *
 */
function fs_search_header_classes( $attributes ) {
	$attributes['class'] = 'archive-description search-description';
	return $attributes;
}
add_filter( 'genesis_attr_search-description', 'fs_search_header_classes' );
