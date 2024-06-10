<?php 
$show_categories = get_theme_mod('blogwaves_single_co_post_categories',true); 
$show_author = get_theme_mod('blogwaves_single_co_post_author',true); 
$show_date = get_theme_mod('blogwaves_single_co_post_date',true); 
$show_comment = get_theme_mod('blogwaves_single_co_post_comments',true); 
$show_tags = get_theme_mod('blogwaves_single_co_post_tags',true); 
$show_image = get_theme_mod('blogwaves_single_co_featured_image_post',true); 
?>

 <div class="blog-wrap">
    <div class="image-part mb-25">
         <?php
        if($show_image && has_post_thumbnail()){
            the_post_thumbnail(); 
        } ?>
    </div>
    <div class="content-part p-0">
        <?php if($show_categories) { ?> <div class="category-name"> <?php the_category(' '); ?></div> <?php } ?>
        <h3 class="heading-title mb-20"><?php the_title(); ?></h3>
        <ul class="blog-meta mb-20">
            <?php if($show_author) { ?><li><?php echo get_avatar( get_the_author_meta('email'), '30' );?><?php esc_html(blogwaves_posted_by()); ?></li><?php } ?>
            <?php if($show_date) { ?><li><i class="fa fa-calendar-check-o"></i><?php esc_html(blogwaves_posted_on()); ?></li><?php } ?>
            <?php if($show_comment) { ?><li><i class="fa fa-comment"></i> <?php echo esc_html(get_comments_number());  ?></li><?php } ?>
        </ul>                                
        <?php the_content();wp_link_pages(); ?>

        
        <?php if($show_tags) { ?>
            <div class="post-tags">
                <a href="#"><?php the_tags(null, ' ', '<br />'); ?></a>
            </div>
        <?php } ?>
     
        <?php 
        $prevPost = get_previous_post();
        $nextPost = get_next_post();
        if (get_previous_post_link()) { 
            $prevThumbnail = get_the_post_thumbnail( $prevPost->ID ); 
            $previous_post_url = get_permalink( get_adjacent_post(false,'',true)->ID );
        }
        if (get_next_post_link()) { 
            $nextThumbnail = get_the_post_thumbnail( $nextPost->ID );
             $next_post_url = get_permalink( get_adjacent_post(false,'',false)->ID );
        } ?>

        
        <div class="post-navigation">
        <?php if (get_previous_post_link()) {  ?>
            <div class="post-prev">
                <a href="<?php echo esc_url($previous_post_url); ?>">
                    <div class="postnav-image">
                        <i class="fa fa-chevron-left"></i>
                        <div class="overlay"></div> 
                        <div class="navprev">
                            <?php print_r($prevThumbnail); ?>
                        </div>
                    </div>
                    <div class="prev-post-title">
                        <p><?php previous_post_link( '%link', '%title', true ) ?></p>
                    </div>
                </a>
            </div>
        <?php } ?>
        <?php if (get_next_post_link()) {  ?>
            <div class="post-next">
                <a href="<?php echo esc_url($next_post_url); ?>">
                    <div class="postnav-image">
                        <i class="fa fa-chevron-right"></i>
                        <div class="overlay"></div> 
                        <div class="navnext">
                            <?php print_r($nextThumbnail); ?>
                        </div>
                    </div> 
                    <div class="next-post-title">
                        <p><?php esc_html(next_post_link( '%link', '%title', true )); ?></p>
                    </div>               
                </a>
            </div>
        <?php } ?>
        </div>
    </div>
</div>