<?php
/**
 * The template for displaying archive pages
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
						<?php
						if ( have_posts() ) :
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						else :
							printf( '<h1 class="page-title">%1$s</h1>', esc_html__( 'Nothing Found', 'blogwaves' ) );
						endif;
						?>
					</header><!-- .page-header -->

					<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php endwhile; ?>
						<div class="pagination">
							<nav class="Page navigation">
								<ul class="page-numbers">
									<?php echo paginate_links(); ?>
								</ul>
							</nav>
						</div>	
					<?php else : ?>
						<div class="post-wrapper post-wrapper-single post-wrapper-single-notfound">
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						</div><!-- .post-wrapper -->

					<?php endif; ?>
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

<?php
get_footer(); 
?>