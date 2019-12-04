<?php
/**
 * WordPress Cleanup
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

/**
 * Dequeue jQuery Migrate
 *
 */
function fs_dequeue_jquery_migrate( &$scripts ){
	if( !is_admin() ) {
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'fs_dequeue_jquery_migrate' );

/**
 * Singular body class
 *
 */
function fs_singular_body_class( $classes ) {
	if( is_singular() )
		$classes[] = 'singular';
	return $classes;
}
add_filter( 'body_class', 'fs_singular_body_class' );

/**
 * Clean body classes
 *
 */
function fs_clean_body_classes( $classes ) {

	$allowed_classes = [
		'singular',
		'single',
		'page',
		'archive',
		'admin-bar',
		'full-width-content',
		'content-sidebar',
		'content',
	];

	return array_intersect( $classes, $allowed_classes );

}
add_filter( 'body_class', 'fs_clean_body_classes', 20 );

/**
 * Clean Nav Menu Classes
 *
 */
function fs_clean_nav_menu_classes( $classes ) {
	if( ! is_array( $classes ) )
		return $classes;

	foreach( $classes as $i => $class ) {

		// Remove class with menu item id
		$id = strtok( $class, 'menu-item-' );
		if( 0 < intval( $id ) )
			unset( $classes[ $i ] );

		// Remove menu-item-type-*
		if( false !== strpos( $class, 'menu-item-type-' ) )
			unset( $classes[ $i ] );

		// Remove menu-item-object-*
		if( false !== strpos( $class, 'menu-item-object-' ) )
			unset( $classes[ $i ] );

		// Change page ancestor to menu ancestor
		if( 'current-page-ancestor' == $class ) {
			$classes[] = 'current-menu-ancestor';
			unset( $classes[ $i ] );
		}
	}

	// Remove submenu class if depth is limited
	if( isset( $args->depth ) && 1 === $args->depth ) {
		$classes = array_diff( $classes, array( 'menu-item-has-children' ) );
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'fs_clean_nav_menu_classes', 5 );

/**
 * Clean Post Classes
 *
 */
function fs_clean_post_classes( $classes ) {

	if( ! is_array( $classes ) )
		return $classes;

	$allowed_classes = array(
  		'hentry',
  		'type-' . get_post_type(),
   	);

	return array_intersect( $classes, $allowed_classes );
}
add_filter( 'post_class', 'fs_clean_post_classes', 5 );

/**
 * Archive Title, remove prefix
 *
 */
function fs_archive_title_remove_prefix( $title ) {
	$title_pieces = explode( ': ', $title );
	if( count( $title_pieces ) > 1 ) {
		unset( $title_pieces[0] );
		$title = join( ': ', $title_pieces );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'fs_archive_title_remove_prefix' );

/**
 * Staff comment class
 *
 */
function fs_staff_comment_class( $classes, $class, $comment_id, $comment, $post_id ) {
	if( empty( $comment->user_id ) )
		return $classes;
	$staff_roles = array( 'comment_manager', 'author', 'editor', 'administrator' );
	$staff_roles = apply_filters( 'fs_staff_roles', $staff_roles );
	$user = get_userdata( $comment->user_id );
	if( !empty( array_intersect( $user->roles, $staff_roles ) ) )
		$classes[] = 'staff';
	return $classes;
}
add_filter( 'comment_class', 'fs_staff_comment_class', 10, 5 );

/**
 * Remove avatars from comment list
 *
 */
function fs_remove_avatars_from_comments( $avatar ) {
	global $in_comment_loop;
	return $in_comment_loop ? '' : $avatar;
}
add_filter( 'get_avatar', 'fs_remove_avatars_from_comments' );

/**
 * Comment form, button class
 *
 */
function fs_comment_form_button_class( $args ) {
	$args['class_submit'] = 'submit wp-block-button__link';
	return $args;
}
add_filter( 'comment_form_defaults', 'fs_comment_form_button_class' );

/**
 * Excerpt More
 *
 */
function fs_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'fs_excerpt_more' );

// Remove inline CSS for emoji
remove_action( 'wp_print_styles', 'print_emoji_styles' );
