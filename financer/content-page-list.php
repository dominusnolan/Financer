<?php
/*
YARPP Template: Thumbnails
Description: Requires a theme which supports post thumbnails
Author: mitcho (Michael Yoshitaka Erlewine)
*/ 
?>

<?php if ( have_posts() ): ?>
		<?php while ( have_posts() ) : the_post();
		        $page = pods(get_post_type(), get_the_ID());
		        if( !empty($page) ){
		        ?>
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                       		<?php if ( !empty($page->field('header_title') ) ) : ?>
							<?php
								if ( !empty($page->display('header_title')) ) {
									echo $page->display('header_title');
								}
							?>
							<?php else: ?>
							<?php echo get_the_title(); ?>
							<?php endif ?>
                        </a>
                <?php } ?>
		<?php endwhile; ?>

<?php else: ?>

<?php endif; 

genesis();
?>