<?php
/**
 * Functions
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/


/**
 * Set up the content width value based on the theme's design. (not sure with the UI design yet)
 *
 */
if ( ! isset( $content_width ) )
    $content_width = 960;

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function fs_global_enqueues() {

	// javascript
	if( ! fs_is_amp() ) {
		wp_enqueue_script( 'fs-global', get_stylesheet_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/global-min.js' ), true );

		// Move jQuery to footer
		if( ! is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
			wp_enqueue_script( 'jquery' );
		}

	}

	// css
	wp_dequeue_style( 'child-theme' );
	wp_register_style( 'fs-fonts', fs_theme_fonts_url() );
	wp_register_style( 'fs-critical', get_stylesheet_directory_uri() . '/assets/css/critical.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/critical.css' ) );
	wp_register_style( 'fs-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

	if( $using_critical_css = true ) {
		wp_enqueue_style( 'fs-critical' );
		wp_dequeue_style( 'wp-block-library' );
		add_action( 'wp_footer', 'fs_enqueue_noncritical_css', 1 );
	} else {
		fs_enqueue_noncritical_css();
	}

}
add_action( 'wp_enqueue_scripts', 'fs_global_enqueues' );

/**
 * Enqueue Non-Critical CSS
 *
 */
function fs_enqueue_noncritical_css() {
	wp_enqueue_style( 'wp-block-library' );
	wp_enqueue_style( 'fs-critical' );
	wp_enqueue_style( 'fs-style' );
	wp_enqueue_style( 'fs-fonts' );
}

/**
 * Gutenberg scripts and styles
 *
 */
function fs_gutenberg_scripts() {
	wp_enqueue_style( 'fs-fonts', fs_theme_fonts_url() );
	wp_enqueue_script( 'fs-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'fs_gutenberg_scripts' );

/**
 * Theme Fonts URL
 *
 */
function fs_theme_fonts_url() {
	return false;
}

/**
 * Theme Setup
 *
 * Site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function fs_child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

	// General cleanup
	include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );

	// Theme
	include_once( get_stylesheet_directory() . '/inc/markup.php' );
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );
	include_once( get_stylesheet_directory() . '/inc/layouts.php' );
	include_once( get_stylesheet_directory() . '/inc/navigation.php' );
	include_once( get_stylesheet_directory() . '/inc/loop.php' );
	include_once( get_stylesheet_directory() . '/inc/author-box.php' );
	include_once( get_stylesheet_directory() . '/inc/template-tags.php' );
	include_once( get_stylesheet_directory() . '/inc/site-footer.php' );

	// Editor
	include_once( get_stylesheet_directory() . '/inc/disable-editor.php' );

	// Functionality
	include_once( get_stylesheet_directory() . '/inc/block-area.php' );
	include_once( get_stylesheet_directory() . '/inc/social-links.php' );

	// Plugin Support
	include_once( get_stylesheet_directory() . '/inc/amp.php' ); // in case we support amp

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Image Sizes
	// add_image_size( 'fs_featured', 400, 100, true );

	/***** Gutenberg *****/

	// -- Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Disable custom font sizes
	add_theme_support( 'disable-custom-font-sizes' );

	// -- Editor Font Styles
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'Small', 'fs' ),
			'shortName' => __( 'S', 'fs' ),
			'size'      => 14,
			'slug'      => 'small'
		),
		array(
			'name'      => __( 'Normal', 'fs' ),
			'shortName' => __( 'M', 'fs' ),
			'size'      => 20,
			'slug'      => 'normal'
		),
		array(
			'name'      => __( 'Large', 'fs' ),
			'shortName' => __( 'L', 'fs' ),
			'size'      => 24,
			'slug'      => 'large'
		),
	) );

	// -- Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );

}
add_action( 'genesis_setup', 'fs_child_theme_setup', 15 );


/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {
	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );


/**
 * Template Hierarchy
 *
 */
function fs_template_hierarchy( $template ) {
	if( is_home() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'fs_template_hierarchy' );
