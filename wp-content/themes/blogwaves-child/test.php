<?php
/*
 * Template Name: Custom Full Width
 * Description: Page template without sidebar
 */
get_header();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title(); ?></title>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>

<body <?php body_class(); ?>>
    <div id="page" class="site">
        <div id="content" class="site-content">
            <main id="main" class="site-main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sidebar">
                                <h3>Search</h3>
                                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                                    <label>
                                        <span class="screen-reader-text"><?php echo _x('Search for:', 'label'); ?></span>
                                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder'); ?>" value="<?php echo get_search_query(); ?>" name="s" required>
                                    </label>
                                    <button type="submit" class="search-submit"><?php echo _x('Search', 'submit button'); ?></button>
                                </form>

                                <h3>Recent Posts</h3>
                                <ul>
                                    <?php
                                    $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
                                    foreach ($recent_posts as $post) {
                                        echo '<li><a href="' . get_permalink($post['ID']) . '">' . $post['post_title'] . '</a></li>';
                                    }
                                    ?>
                                </ul>

                                <h3>Categories</h3>
                                <ul>
                                    <?php wp_list_categories(array('title_li' => '')); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row shadow p-3 mb-5 bg-white rounded">
                                <?php
                                $query = new WP_Query(array(
                                    'post_type'      => 'post',
                                    'posts_per_page' => 4,
                                ));

                                if ($query->have_posts()) {
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        $excerpt = get_the_excerpt(); // Assuming get_the_excerpt() retrieves the excerpt
                                        $youtube_url = '';

                                        // Regular expression to find YouTube URLs in the excerpt
                                        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

                                        // Check if there's a YouTube URL in the excerpt
                                        if (preg_match($pattern, $excerpt, $matches)) {
                                            // Construct the YouTube URL
                                            $youtube_url = 'https://www.youtube.com/watch?v=' . $matches[1];
                                        }
                                        echo '<div class="col-md-4">';
                                        echo '<div class="card mb-4">';
                                        echo '<div class="card-body">';
                                        // Display post thumbnail
                                        if (has_post_thumbnail()) {
                                            echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'card-img-top img-fluid', 'style' => 'height: 300px; width: 100%;')) . '</a>';
                                        }
                                        // Anchor tag with post permalink
                                        echo '<a href="' . get_permalink() . '"><h5 class="card-title">' . get_the_title() . '</h5></a>';
                                        if (!empty($youtube_url)) {
                                            echo '<a href="' . $youtube_url . '">Watch Video</a>';
                                        }
                                        echo '<p class="card-text">' . wp_trim_words(get_the_content(), 20, '...') . '</p>';
                                        echo '</div>';
                                        echo '<div class="card-footer">';
                                        echo '<small class="text-muted">' . get_the_date() . '</small>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    // No posts found
                                    echo 'No posts found';
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main><!-- #main -->
        </div><!-- #content -->
    </div><!-- #page -->
    <iframe class="airtable-embed" src="https://airtable.com/embed/appqoCpjGWk1V4UiV/pagF7DwmsoGFAKIVu/form" frameborder="0" onmousewheel="" width="100%" height="533" style="background: transparent; border: 1px solid #ccc;"></iframe>
    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>