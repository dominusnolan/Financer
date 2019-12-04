<?php


namespace Financer\Blog\Module;


use ComposePress\Core\Abstracts\Component;

/**
 * Class BlogShortcodes
 *
 * @package Financer\Blog\Module
 */
class BlogShortcodes extends Component {

	/**
	 *
	 */
	public function init() {
		// TODO: Implement init() method.

		add_shortcode( 'show_posts', function ( $atts ) {
		    if ( isset( $atts['tags'] ) ) {
		        $atts['tag'] = $atts['tags'];
		        unset( $atts['tags'] );
		    }
		    if ( isset( $atts['post_category'] ) ) {
		        $atts['category_name'] = $atts['post_category'];
		        unset( $atts['post_category'] );
		    }
		    if ( isset( $atts['post_title'] ) ) {
		        $atts['title'] = $atts['post_title'];
		        unset( $atts['post_title'] );
		    }
			$args = array_merge( [
						'post_type'		=> 'post',
						'posts_per_page'=> 1,
						'orderby'		=> 'date',
						'order'			=> 'DESC'
					], $atts );
			$the_query = new WP_Query( $args );
		    ob_start();
				if ( $the_query->have_posts() ):
					echo '<div class="related-box">';
						while ( $the_query->have_posts() ) : $the_query->the_post();
							get_template_part( 'content', 'small-summary' );
						endwhile;
					echo '</div>';
				else:
				endif;
		    return ob_get_clean();
		} );

		add_shortcode( 'show_most_read', function ( $atts ) {
		    $title = '';
		    if ( isset( $atts['tags'] ) ) {
		        $atts['tag'] = $atts['tags'];
		        unset( $atts['tags'] );
		    }
		    if ( isset( $atts['post_category'] ) ) {
		        $atts['category_name'] = $atts['post_category'];
		        unset( $atts['post_category'] );
		    }
		    if ( isset( $atts['title'] ) ) {
		        $title = $atts['title'];
		        unset( $atts['title'] );
		    }
		    if ( isset( $atts['post_title'] ) ) {
		        $atts['title'] = $atts['post_title'];
		        unset( $atts['post_title'] );
		    }
		    query_posts(
		        array_merge( [
		            'post_type'      => 'post',
		            'posts_per_page' => - 1,
		            'meta_key'       => 'wpb_post_views_count',
		            'orderby'        => 'meta_value_num',
		            'order'          => 'DESC'
		        ], $atts )
		    );
		    ob_start();
		    ?>
		    <h2 class="h2"><?= $title; ?></h2>
		    <?php get_template_part( 'content', 'blog-summary' ); ?>

		    <?php
		    wp_reset_query();

		    return ob_get_clean();
		} );

		
		add_shortcode( 'show_most_read_list', function ( $atts ) {
		    $title = '';
		    if ( isset( $atts['tags'] ) ) {
		        $atts['tag'] = $atts['tags'];
		        unset( $atts['tags'] );
		    }
		    if ( isset( $atts['post_category'] ) ) {
		        $atts['category_name'] = $atts['post_category'];
		        unset( $atts['post_category'] );
		    }
		    if ( isset( $atts['title'] ) ) {
		        $title = $atts['title'];
		        unset( $atts['title'] );
		    }
		    if ( isset( $atts['post_title'] ) ) {
		        $atts['title'] = $atts['post_title'];
		        unset( $atts['post_title'] );
		    }
		    query_posts(
		        array_merge( [
		            'post_type'      => 'post',
		            'posts_per_page' => - 1,
		            'meta_key'       => 'wpb_post_views_count',
		            'orderby'        => 'meta_value_num',
		            'order'          => 'DESC'
		        ], $atts )
		    );
		    ob_start();
		    ?>
		    <?php get_template_part( 'content', 'popular-list' ); ?>

		    <?php
		    wp_reset_query();

		    return ob_get_clean();
		} );

		add_shortcode( 'show_recent', function ( $atts ) {
		    $title = '';
		    if ( isset( $atts['tags'] ) ) {
		        $atts['tag'] = $atts['tags'];
		        unset( $atts['tags'] );
		    }
		    if ( isset( $atts['post_category'] ) ) {
		        $atts['category_name'] = $atts['post_category'];
		        unset( $atts['post_category'] );
		    }
		    if ( isset( $atts['title'] ) ) {
		        $title = $atts['title'];
		        unset( $atts['title'] );
		    }
		    if ( isset( $atts['post_title'] ) ) {
		        $atts['title'] = $atts['post_title'];
		        unset( $atts['post_title'] );
		    }
		    query_posts(
		        array_merge( [
		            'post_type'      => 'post',
		            'posts_per_page' => - 1,
		        ], $atts )
		    );
		    ob_start();
		    ?>
		    <h2 class="h2"><?= $title; ?></h2>
		    <?php get_template_part( 'content', 'blog-summary' ); ?>

		    <?php
		    wp_reset_query();

		    return ob_get_clean();
		} );

		add_shortcode( 'show_pages', function ( $atts ) {
		    $title = '';
		    if ( isset( $atts['tags'] ) ) {
		        $atts['tag'] = $atts['tags'];
		        unset( $atts['tags'] );
		    }
		    if ( isset( $atts['title'] ) ) {
		        $title = $atts['title'];
		        unset( $atts['title'] );
		    }
		    if ( isset( $atts['post_title'] ) ) {
		        $atts['title'] = $atts['post_title'];
		        unset( $atts['post_title'] );
		    }
		    query_posts(
		        array_merge( [
		            'post_type'      => 'page',
		            'posts_per_page' => - 1,
		            'post__not_in' => array(get_the_ID())
		        ], $atts )
		    );
		    ob_start();
		    echo '<div class="msg page-list">';
		    if ( $title ) {
		        ?>
		        <h2><?= $title; ?></h2>
		        <?php
		    }
		    get_template_part( 'content', 'page-list' );
		    ?>
		    </div>
		    <?php
		    wp_reset_query();

		    return ob_get_clean();
		} );

		function child_pages() {
		    $args = array(
		        'post_type'      => 'page',
		        'posts_per_page' => - 1,
		        'post_parent'    => get_the_ID(),
		        'order'          => 'DESC',
		        'orderby'        => 'date'
		    );

		    query_posts( $args );
		    ob_start();
		    if ( have_posts() ) : ?>
		        <div class="msg page-list">
		            <h2><?php _e( 'More about', 'fs' ); ?> <?php the_title(); ?></h2>
		            <?php get_template_part( 'content', 'page-list' ); ?>
		        </div>
		    <?php endif; ?>
		    <?php
		    wp_reset_query();
		    return ob_get_clean();
		}

		add_shortcode( 'show_children', 'child_pages' );

	}
}