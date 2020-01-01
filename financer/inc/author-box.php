<?php
/**
 * Author Box
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

/**
 * Author archive avatar
 * @param $title
 * @param $description
 * @param $context
 */
function fs_author_archive_avatar( $title, $description, $context ) {
	if( ! is_author() || get_query_var( 'paged' ) )
		return;

	echo get_avatar( get_queried_object_id(), 200 );
}
add_filter( 'genesis_archive_title_descriptions', 'fs_author_archive_avatar', 9, 3 );

/**
 * Author archive introduction
 * @param $title
 * @param $description
 * @param $context
 */
function fs_author_intro( $title, $description, $context ) {
	if( ! is_author() || get_query_var( 'paged' ) )
		return;

	$title = get_user_meta( get_queried_object_id(), 'fs_user_title', true );
	if( !empty( $title ) )
		echo '<p class="author-title">' . esc_html( $title ) . '</p>';

	if( empty( $description ) )
		echo apply_filters( 'fs_the_content', get_the_author_meta( 'description' ) );

	echo '<h3 class="has-text-align-center">Recent Articles by ' . get_the_author_meta( 'first_name' ) . '</h3>';
}
add_action( 'genesis_archive_title_descriptions', 'fs_author_intro', 11, 3 );

// Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
add_filter( 'get_the_author_genesis_author_box_archive', '__return_false' );

// Author box, avatar size
add_filter( 'genesis_author_box_gravatar_size', function( $size ) {
	return 100;
});
