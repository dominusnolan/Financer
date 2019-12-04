<?php
namespace Financer\Blog;


use ComposePress\Core\Abstracts\Component;

/**
 * Class BlogComponent
 *
 * @package Financer\Blog
 * @property \Financer\Blog\Plugin $plugin
 */
class BlogComponent extends Component {

	/**
	 *
	 */
	public function init() {
		// TODO: Implement init() method.	
		function custom_excerpt_length( $length ) {
		    return 20;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

		function custom_excerpt_more( $more ) {
		    global $post;
		    $more_text = '...';
		    return '… ';
		}
		add_filter( 'excerpt_more', 'custom_excerpt_more' );

	}
}