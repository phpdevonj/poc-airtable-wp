<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package darkmusic-blog
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<section class="error-404 not-found">
					<div class="image-404"><img src="<?php echo esc_url(get_template_directory_uri() .'/assets/images/error.jpg'); ?>" alt=""></div>
					<h1 class="page-title"><?php echo esc_html(get_theme_mod('darkmusic_blog_404page_title' , 'Oops! That page can&rsquo;t be found')); ?></h1>

				<div class="page-content-404">
					<p><?php echo esc_html(get_theme_mod('darkmusic_blog_404page_text' , 'It looks like nothing was found at this location. Maybe try one of the links below or a search?')); ?></p>

						<?php
						get_search_form();
						?>
					<div class="go-home">
						<a class="theme-button back-btn-404" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Go to Home','darkmusic-blog'); ?></a>
					</div>
					

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div>
	</main><!-- #main -->

<?php
get_footer(); ?>