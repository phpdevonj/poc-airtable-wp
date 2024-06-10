<?php
/*
 * Template Name: Custom Full Width
 * description: >-
  Page template without sidebar
 */
// Set up Airtable API credentials
// The Query
?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
$query = new WP_Query( array(
    'post_type' => 'post', // Specify post type (you can change to 'page', 'custom_post_type', etc.)
    'posts_per_page' => 6, // Number of posts to retrieve (-1 to retrieve all)
));

// The Loop
if ( $query->have_posts() ) {
    echo '<div class="row">';
    while ( $query->have_posts() ) {
        $query->the_post();
        echo '<div class="col-md-4">';
        // Display post content
        echo '<div class="card mb-4">';
        if (has_post_thumbnail()) {
            echo '<img src="' . get_the_post_thumbnail_url(null, 'large') . '" class="card-img-top img-fluid" alt="' . get_the_title() . '" style="height: 300px; width: 100%;">';
        }
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . get_the_title() . '</h5>';
        echo '<p class="card-text">' . get_the_excerpt() . '</p>'; // Display post excerpt

        echo '<p class="card-text">' . wp_trim_words(get_the_content(), 20, '...') . '</p>';
        echo '</div>';
        echo '<div class="card-footer">';
        echo '<small class="text-muted">' . get_the_date() . '</small>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    // No posts found
    echo 'No posts found';
}

// Restore original post data
wp_reset_postdata();
?>

