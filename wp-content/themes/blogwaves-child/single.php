<?php
/**
 * The template for displaying all single posts
 *
 * @package blogwaves
 */

get_header();
?>

<?php if (have_posts()) : ?>

    <section class="wp-blog-section ptb-100 bg-color single-post-content">
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
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content" style="margin-top: 20px; margin-bottom: 20px;">
                                <?php the_content(); ?>
                            </div><!-- .entry-content -->
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'blogwaves'),
                                'after'  => '</div>',
                            ));
                            ?>
                            <?php
                            if (comments_open() || '0' != get_comments_number()) :
                                comments_template();
                            endif;
                            ?>
                        </article><!-- #post-## -->
                    <?php endwhile; ?>
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


<?php endif; ?>

<?php
get_footer();
?>
