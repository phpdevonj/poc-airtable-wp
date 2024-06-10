<?php
/*
Template Name: Custom Category Page
*/

get_header(); ?>
  <main id="content">
    <div class="page-container">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="col-md-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="post-thumbnail">
                      <?php the_post_thumbnail(); ?>
                      </div><!-- .post-thumbnail -->
                      <a href="<?php the_permalink(); ?>"><h5 class="card-title"><?php the_title(); ?></h5>
                      <p class="card-text"><?php the_excerpt(); ?></p>
                      <a href="<?php the_permalink(); ?>" class="btn btn-primary"><span><?php esc_html_e( 'Read More', 'darkmusic-blog' ); ?> </span></a>
                    </div>
                  </div>
                </div>
                <?php endwhile; endif; ?>
              </div>
            </div>
          </div>
        </div>
    </div>
  </main>

<?php get_footer(); ?>
