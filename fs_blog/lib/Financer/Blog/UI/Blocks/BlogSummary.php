<?php

namespace Financer\Blog\UI\Pages;

use ComposePress\Settings\UI\Factory;
use ComposePress\Settings\UI\Fields\Image;
use ComposePress\Settings\UI\Fields\Select;
use ComposePress\Settings\UI\Fields\Wysiwyg;

class BlogSummary extends \ComposePress\Settings\Abstracts\Page {

	public function render() {
		if ( have_posts() ): 
			echo '<div class="related-box">';

				while ( have_posts() ) : the_post();

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
			        <aside class="articleArchive related-articles">
			            <div class="entry-box">
			                <div class="imageWrap">
								{thumbnail}
			                </div>
			                <div class="content-wrap">
			                    <h3><a href="{$permalink}" rel="bookmark">{title}</a></h3>
			                    <p class="textWrap">
									$content
			                        ..
			                    </p>
			                    <a href="{$permalink}"
			                       class="button small darkGrey saButton">Read article &rarr;</a>
			                </div>
			            </div>
			        </aside>
HTML;
				endwhile;

			echo '</div>';

			else:

		endif;
	}
}