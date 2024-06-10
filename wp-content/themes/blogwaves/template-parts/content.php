<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogwaves
 */
?>
<?php 
$show_date = get_theme_mod('blogwaves_archive_co_post_date',true); 
$show_author = get_theme_mod('blogwaves_archive_co_post_author',true);
$show_comment = get_theme_mod('blogwaves_archive_co_post_comments',true); 
$show_image = get_theme_mod('blogwaves_archive_co_featured_image',true); 
?>

<div class="blog-wrap" id="post-<?php the_ID(); ?>">
    <div class="image-part mb-25">
        <?php
        if($show_image && has_post_thumbnail()){
         	the_post_thumbnail(); 
        } ?>
    </div>
    
   	<div class="content-part content">
        <h3 class="title mb-20"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <ul class="blog-meta mb-20">
            <?php if($show_author) { ?><li><?php echo get_avatar( get_the_author_meta('email'), '30' );?><?php blogwaves_posted_by(); ?></li><?php } ?>
           
            <?php if($show_date) { ?><li><i class="fa fa-calendar-check-o"></i><?php blogwaves_posted_on(); ?></li><?php } ?>

            <?php if($show_comment) { ?><li><i class="fa fa-comment"></i> <?php echo esc_html(get_comments_number());  ?> </li><?php } ?>
        </ul>
        <?php the_excerpt(); ?>
        <a class="read-more" href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('blogwaves_read_more_label', 'Read More')); ?> <i class="fa fa-arrow-right"></i></a>
    </div>
</div>