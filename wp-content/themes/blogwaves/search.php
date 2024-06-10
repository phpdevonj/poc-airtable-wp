<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package blogwaves
 */

get_header();
?>

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

					<header class="page-header">
						<h1 class="page-title">
							<?php
							printf( esc_html__( 'Search Results for: %s', 'blogwaves' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
					</header> 
					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php endwhile; ?>
						

					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif;?>

				</div>
				<?php
                if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
					<div class="col-lg-4">
						
						<?php get_sidebar(); ?>
						
					</div>
				<?php } ?>
			</div> 
		</div> 
	</section>

<?php
get_footer();