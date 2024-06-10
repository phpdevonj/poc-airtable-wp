<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogwaves
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

<section class="wp-blog-section ptb-100 bg-color">
		<div class="container">

			<?php
	            $sidebar_position = get_theme_mod('blogwaves_sidebar_position', 'right');
	            if ($sidebar_position == 'left') {
	                $sidebar_position = 'has-left-sidebar';
	            } elseif ($sidebar_position == 'right') {
	                $sidebar_position = 'has-right-sidebar';
	            } elseif ($sidebar_position == 'no') {
	                $sidebar_position = 'no-sidebar';
	            }
            ?>

			<div class="row <?php echo esc_attr($sidebar_position); ?>">
				<div class="col-lg-8">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'page' ); ?>
						<?php
						// comments are open or have atleast one comment, if any of one condition is true then it load comment template
						if ( comments_open() || '0' != get_comments_number() ) :
						comments_template(); 
						endif;?>
					<?php endwhile; ?>
				</div>
				<?php
                if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
					<div class="col-lg-4">
						
						<?php get_sidebar(); ?>
						
					</div>
				<?php } ?>
			</div><!-- row -->
		</div><!-- container -->
</section>


<?php endif; ?>	

<?php

get_footer(); 
?>