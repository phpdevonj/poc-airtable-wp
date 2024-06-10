<?php
/**
 * Template Name: Home Page Template
 */
?>

<?php get_header(); ?>


<main id="content">
    

    <div id="content" class="page-container">
        <?php do_action( 'darkmusic_blog_before_section1' ); ?>

        <?php get_template_part( 'template-parts/home-sections/section1' ); ?>

    </div>

</main>

<?php get_footer(); ?>
