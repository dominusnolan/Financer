<?php
/**
 * Single Company Template 
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/

echo '<article class="post-summary">';

	fs_post_summary_image();

	echo '<div class="post-summary__content">';
		fs_entry_category();
		fs_post_summary_title();
	echo '</div>';

echo '</article>';
