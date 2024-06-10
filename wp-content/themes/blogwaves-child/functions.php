<?php


function my_custom_scripts()
{
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/custom.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'my_custom_scripts');

// Add custom image size
add_image_size('custom-post-thumbnail', 300, 300, true); // Change dimensions as needed

function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_parent_styles');

// Enqueue Bootstrap CSS
function enqueue_bootstrap() {
    wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap' );
