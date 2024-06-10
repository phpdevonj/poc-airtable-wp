<?php
/**
Template Name: Full Width Page
**/
get_header();
?>
<?php if ( have_posts() ) : ?>
<section class="wp-blog-section ptb-100 bg-color">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'page' ); ?>
						<?php
						if ( comments_open() || '0' != get_comments_number() ) :
						comments_template(); 
						endif;?>
					<?php endwhile; ?>
				</div>
			</div><!-- row -->
		</div><!-- container -->
</section>
<?php endif; 
get_footer(); 
?>