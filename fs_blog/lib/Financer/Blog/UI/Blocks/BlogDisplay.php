<?php

namespace Financer\Blog\UI\Pages;

use ComposePress\Settings\UI\Factory;
use ComposePress\Settings\UI\Fields\Image;
use ComposePress\Settings\UI\Fields\Select;
use ComposePress\Settings\UI\Fields\Wysiwyg;

class BlogDisplay extends \ComposePress\Settings\Abstracts\Page {

	public function render() {
		$content = implode( ' ', array_slice( explode( ' ', strip_shortcodes( wp_strip_all_tags( get_the_content() ) ) ), 0, 20 ) );
		$permalink = get_the_permalink();
		$title = get_the_title();
		$title_attribute = the_title_attribute();

		if ( has_post_thumbnail() ) {
			$thumbmnail = the_post_thumbnail('large', ['class' => 'no-wrapper']);
		} else { 
			$thumbmnail = '<img class="no-wrapper" src="<?php bloginfo( 'stylesheet_directory' ) ?>/images/thumbnail-default.png"/>';
		} 
		echo <<<HTML
			 <div class="blog-link">
                <div class="entry-box">
                    <div class="imageWrap">
						{thumbnail}
                    </div>
                    <div class="content-wrap">
                        <h3><a href="{permalink}" rel="bookmark"
                               title="{$title_attribute }">{$title}</a></h3>
                        <p class="textWrap">
							{$content}
                            ..
                        </p>
                    </div>
                </div>
            </div>
HTML;
	}
}