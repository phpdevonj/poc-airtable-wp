<?php
/**
 * Template part for displaying results in search pages
 *
 * @package blogwaves
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			blogwaves_posted_on();
			blogwaves_posted_by();
			?>
		</div>< 
		<?php endif; ?>
	</header> 
    <?php blogwaves_post_thumbnail(); ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div> 
	<footer class="entry-footer">
		<?php blogwaves_entry_footer(); ?>
	</footer> 
</article><!-- #post-<?php the_ID(); ?> -->
