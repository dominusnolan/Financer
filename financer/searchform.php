<?php
/**
 * Search form
 *
 * @package      Financer
 * @author       Financer Team
 * @since        1.0.0
**/
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for</span>
		<input type="search" class="search-field" placeholder="Search&hellip;" value="<?php echo get_search_query(); ?>" name="s" title="Search for" />
	</label>
	<button type="submit" class="search-submit"><?php echo fs_icon( array( 'icon' => 'search', 'title' => 'Submit' ) );?></button>
</form>
