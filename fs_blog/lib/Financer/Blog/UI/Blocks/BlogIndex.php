<?php

namespace Financer\Blog\UI\Pages;

use ComposePress\Settings\UI\Factory;
use ComposePress\Settings\UI\Fields\Image;
use ComposePress\Settings\UI\Fields\Select;
use ComposePress\Settings\UI\Fields\Wysiwyg;

class BlogIndex extends \ComposePress\Settings\Abstracts\Page {
	public function render() {
		$content = implode( ' ', array_slice( explode( ' ', strip_shortcodes( wp_strip_all_tags( get_the_content() ) ) ), 0, 20 ) );
		$category = get_the_term_list( $post->ID, 'category');
		$permalink = get_the_permalink();
		$title = get_the_title();
		$estimated_time = fn_estimated_reading_time();
		$title_attribute = the_title_attribute();
		if ( has_post_thumbnail() ) {
			$thumbmnail = the_post_thumbnail('large', ['class' => 'no-wrapper']);
		} else { 
			$thumbmnail = '<img class="no-wrapper" src="<?php bloginfo( 'stylesheet_directory' ) ?>/images/thumbnail-default.png"/>';
		} 
		echo <<<HTML
			<section class="blog-link">
				<div class="entry-box">
					<div class="imageWrap">
			<div class="post-categories">
			{$category}
			</div>
					{$thumbmnail}
				</div>
				<div class="content-wrap">
					<h3><a href="{$permalink}" rel="bookmark"
						   title="{$title_attribute }">{$title}</a></h3>
					<div class="read-time" title="Reading Time" >{$estimated_time}</div>
					<p class="textWrap">
						{$content}
						&hellip;
					</p>
				</div>
			</div>
		</section>

HTML;
	}
}