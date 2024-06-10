<?php
/**
 * The template for displaying pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package darkmusic-blog
 */

get_header();
?>

<main id="content" role="main">
	<div class="container">
		<div class="wrapper">
            <div id="content" class="content-area theme-sticky-component">
                <?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
                ?>
            </div><!-- #primary -->
        </div>
	</div>    
</main>


<?php
get_footer();
