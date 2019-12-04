<?php
/**
 * Template Name: Credit Card
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

// Entry category in header
add_action( 'genesis_entry_header', 'fs_entry_category', 8 );
add_action( 'genesis_entry_header', 'fs_entry_author', 12 );
add_action( 'genesis_entry_header', 'fs_entry_header_share', 13 );

/**
 * Entry header share
 *
 */
function fs_entry_header_share() {
	do_action( 'fs_entry_header_share' );
}

/**
 * After Entry
 *
 */
function fs_single_after_entry() {
	echo '<div class="after-entry">';

	// Breadcrumbs
	genesis_do_breadcrumbs();

	// Publish date
	echo '<p class="publish-date">Published on ' . get_the_date( 'F j, Y' ) . '</p>';

	// Sharing
	do_action( 'fs_entry_footer_share' );

	// Author Box
	genesis_do_author_box_single();

	// Newsletter signup
	$form_id = get_option( 'options_fs_newsletter_form' );
	if( $form_id && function_exists( 'wpforms_display' ) )
		wpforms_display( $form_id, true, true );

	// Related Posts
	$loop = new WP_Query( [
		'posts_per_page'	=> 3,
		'post__not_in'		=> [ get_the_ID() ],
		'category_name'		=> fs_first_term( 'category', 'slug' ),
	] );
	if( $loop->have_posts() ):
		echo '<section class="post-listing-block layout3">';
		while( $loop->have_posts() ):
			$loop->the_post();
			get_template_part( 'partials/creditcard' );
		endwhile;
		echo '</section>';
		wp_reset_postdata();
	endif;
	echo '</div>';
}
add_action( 'genesis_after_entry', 'fs_single_after_entry', 8 );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

genesis();