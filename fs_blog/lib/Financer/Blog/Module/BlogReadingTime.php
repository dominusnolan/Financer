<?php


namespace Financer\Blog\Module;


use ComposePress\Core\Abstracts\Component;

/**
 * Class BlogReadingTime
 *
 * @package Financer\Blog\Module
 */
class BlogReadingTime extends Component {

	/**
	 *
	 */
	public function init() {	
		// TODO: Implement init() method.
		$this->fn_estimated_reading_time();
	}

	public function fn_estimated_reading_time(){
		$post = get_post();
	    //$words = str_word_count( strip_tags( $post->post_content ) );
		$words = count(preg_split('~[^\p{L}\p{N}\']+~u',$post->post_content));
	    $minutes = floor( $words / 250 );

	    if ( $minutes >= 1 ) {
	        $estimated_time = sprintf( _n( '%d minute', '%d minutes', $minutes, 'fs' ), $minutes );
	    } else {
	        $estimated_time = __('Less than a minute', 'fs');
	    }
	    return $estimated_time;
	}
}