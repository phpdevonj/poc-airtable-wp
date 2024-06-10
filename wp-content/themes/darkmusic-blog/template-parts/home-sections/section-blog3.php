<?php
  // Define the query to get the latest posts from the "Features" category
  $args = array(
  'category_name' =>  get_theme_mod('darkmusic_blog_section1_category_three'),
  'posts_per_page' => get_theme_mod('darkmusic_blog_section1_category_number_of_posts_setting_three'),
  'order' => 'DESC'
);

$query = new WP_Query( $args );

// Loop through the posts
while ( $query->have_posts() ) : $query->the_post();
?>


  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="post">

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
          <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail(); ?>
          </a>
        </div>
      <?php endif; ?>
      <?php if ( get_theme_mod( 'darkmusic_blog_post_meta_toggle_switch_control', true ) ) : ?>
        <div class="sec2-meta">
          <span><?php echo get_the_date(); ?></span>
          <span><?php echo get_the_author(); ?></span>
        </div>
      <?php else : ?>
      <!-- Content to display when the toggle switch is OFF -->
      <?php endif; ?>
      <h2 class="post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
      <div class="latest-content">
        <?php the_content(); ?>
      </div>
      <div class="readmore-latest"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'darkmusic-blog'); ?></a></div>

    </div>
  </div>
<?php endwhile; wp_reset_postdata(); ?>