<?php
/**
 * The main template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package darkmusic-blog
 */

get_header();
?>
  <main id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="main-post-content-box">
              <?php if ( get_theme_mod( 'darkmusic_blog_post_meta_toggle_switch_control', true ) ) : ?>
                <div class="sec2-meta">
                    <span><?php echo get_the_date(); ?></span>
                    <span><?php echo get_the_author(); ?></span>
                </div>
              <?php else : ?>
                  <!-- Content to display when the toggle switch is OFF -->
              <?php endif; ?>
              <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
            </div>
          <?php endwhile; ?>
            <?php the_posts_pagination( array(
              'prev_text' => __( 'Previous page', 'darkmusic-blog' ),
              'next_text' => __( 'Next page', 'darkmusic-blog' ),
              'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'darkmusic-blog' ) . ' </span>',
            ) ); ?>
          <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
          <?php endif; ?>
    </div>
    <div class="col-md-4">
      <?php get_sidebar(); ?>
    </div>
  </div>
    <!-- tags -->
    <?php if (has_tag()) { ?>
      <div class="post-tags">
          <span><?php esc_html_e('Tags:', 'darkmusic-blog'); ?></span>
          <?php the_tags('', ' '); ?>
      </div>
    <?php } ?>
  <?php
      // If comments are open or there is at least one comment, show the comment template.
      if ( comments_open() || get_comments_number() ) {
        comments_template();
      }

    ?>

</div>
</main>

<?php
get_footer(); ?>
