<?php
/*
Template Name: Custom Blog Template
*/

get_header(); ?>

<section id="section1" class="featured-posts">
  <div class="container">
    <div class="section-heading-main">
      <?php if(get_theme_mod('darkmusic_blog_blogpage_title',true) != ''){?>
    <h3><?php echo esc_html(get_theme_mod('darkmusic_blog_blogpage_title')); ?></h3>
    <?php }?>
    </div>
    <div class="row">
    
      <?php
        // Define the query to get the latest posts from the "Features" category
        $args = array(
          'category_name' =>  get_theme_mod('darkmusic_blog_blogpage_category'),
          'posts_per_page' => get_theme_mod('darkmusic_blogblog_page_category_number_of_posts_setting'),
          'order' => 'DESC'
        );
        
        $query = new WP_Query( $args );
        
        // Loop through the posts
        while ( $query->have_posts() ) : $query->the_post();
      ?>
      
      <div class="col-lg-6 col-md-4 col-sm-12">
        <div class="post">
        
          <?php if ( has_post_thumbnail() ) : ?>
          <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>
          </div>
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
      
    </div>
</div>
</section>

<?php
get_footer();
?>
