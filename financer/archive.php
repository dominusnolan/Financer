<?php
/**
 * Archive
 *
 * @package      Financer
 * @author       Financer Team
**/

// Full Width
add_filter( 'genesis_pre_get_option_sie_layout', '__genesis_return_full_width_content' );

/**
 * Blog Archive Body Class
 * @param $classes
 * @return array
 */
function fs_blog_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'fs_blog_archive_body_class' );

// Move breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_archive_title_descriptions', 'genesis_do_breadcrumbs', 8 );


/**
 * Remove actions on before entry and setup the portfolio entry actions
 */
function genesis_portfolio_setup_loop()
{
    $hooks = array(
    'genesis_before_entry',
    'genesis_entry_header',
    'genesis_before_entry_content',
    'genesis_entry_content',
    'genesis_after_entry_content',
    'genesis_entry_footer',
    'genesis_after_entry',
    );
    foreach ( $hooks as $hook ) {
        remove_all_actions($hook);
    }
    add_action('genesis_entry_content', 'genesis_portfolio_grid');
    add_action('genesis_after_entry_content', 'genesis_entry_header_markup_open', 5);
    add_action('genesis_after_entry_content', 'genesis_entry_header_markup_close', 15);
    add_action('genesis_after_entry_content', 'genesis_do_post_title');
}


// Remove description on paginated archives
if( get_query_var( 'paged' ) ) {
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_intro_text', 12, 3 );
}

genesis();
