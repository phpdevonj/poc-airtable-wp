<?php
/**
 * blogwaves Theme Customizer
 *
 * @package blogwaves
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


function blogwaves_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'blogwaves_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'blogwaves_customize_partial_blogdescription',
			)
		);
	}

	/*Blogwaves Option Panel*/
	$wp_customize->add_panel( 'blogwaves_theme_options', array(
	    'title'     => __( 'Blogwaves Theme Options', 'blogwaves' ),
	    'priority'  => 1,
	) );

	/*Top Header Options Section*/
	$wp_customize->add_section( 'blogwaves_top_header_options', array (
		'title'     => __( 'Top Header Options', 'blogwaves' ),
		'panel'     => 'blogwaves_theme_options',
		'priority'  => 10,
		'description' => __( 'Personalize the settings top header.', 'blogwaves' ),
	) );

	// Top Header Display Control
	$wp_customize->add_setting ( 'blogwaves_top_header_display', array (
		'default'           =>  true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_top_header_display', array (
		'label'           => __( 'Display Top Header', 'blogwaves' ),
		'section'         => 'blogwaves_top_header_options',
		'priority'        => 1,
		'type'            => 'checkbox',
	) );

	// Top Header Menu Display Control
	$wp_customize->add_setting ( 'blogwaves_top_header_menu_display', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_top_header_menu_display', array (
		'label'           => __( 'Display Top Header Menu', 'blogwaves' ),
		'section'         => 'blogwaves_top_header_options',
		'priority'        => 2,
		'type'            => 'checkbox',
		'active_callback' => 'blogwaves_header_active_callback'
	) );

	// Top Header Menu Date Display Control
	$wp_customize->add_setting ( 'blogwaves_top_header_menu_date_display', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_top_header_menu_date_display', array (
		'label'           => __( 'Display Top Header Date', 'blogwaves' ),
		'section'         => 'blogwaves_top_header_options',
		'priority'        => 3,
		'type'            => 'checkbox',
		'active_callback' => 'blogwaves_header_active_callback'
	) );

	// Top Header Menu Social Icon Display Control
	$wp_customize->add_setting ( 'blogwaves_top_header_social_icon_display', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_top_header_social_icon_display', array (
		'label'           => __( 'Display Top Header Social Icons', 'blogwaves' ),
		'section'         => 'blogwaves_top_header_options',
		'priority'        => 4,
		'type'            => 'checkbox',
		'active_callback' => 'blogwaves_header_active_callback'
	) );

	// Facebook URL
	$wp_customize->add_setting ( 'blogwaves_social_icon_fb_url', array(
		'default'           => __( '#', 'blogwaves' ),
		'sanitize_callback' => 'esc_url_raw',


	) );

	$wp_customize->add_control ( 'blogwaves_social_icon_fb_url', array(
		'label'    => __( 'Facebook URL', 'blogwaves' ),
		'section'  => 'blogwaves_top_header_options',
		'priority' => 5,
		'type'     => 'url',
		'active_callback' => 'blogwaves_header_social_active_callback'

	) );

	// Twitter URL
	$wp_customize->add_setting ( 'blogwaves_social_icon_twitter_url', array(
		'default'           => __( '#', 'blogwaves' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'blogwaves_social_icon_twitter_url', array(
		'label'    => __( 'Twitter URL', 'blogwaves' ),
		'section'  => 'blogwaves_top_header_options',
		'priority' => 6,
		'type'     => 'url',
		'active_callback' => 'blogwaves_header_social_active_callback'
	) );

	// Linkedin URL
	$wp_customize->add_setting ( 'blogwaves_social_icon_linkedin_url', array(
		'default'           => __( '#', 'blogwaves' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'blogwaves_social_icon_linkedin_url', array(
		'label'    => __( 'Linkedin URL', 'blogwaves' ),
		'section'  => 'blogwaves_top_header_options',
		'priority' => 7,
		'type'     => 'url',
		'active_callback' => 'blogwaves_header_social_active_callback'
	) );

	// Instagram URL
	$wp_customize->add_setting ( 'blogwaves_social_icon_insta_url', array(
		'default'           => __( '#', 'blogwaves' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'blogwaves_social_icon_insta_url', array(
		'label'    => __( 'Instagram URL', 'blogwaves' ),
		'section'  => 'blogwaves_top_header_options',
		'priority' => 8,
		'type'     => 'url',
		'active_callback' => 'blogwaves_header_social_active_callback'
	) );

	// Social URL Target Display Control
	$wp_customize->add_setting ( 'blogwaves_social_icon_target_display', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_social_icon_target_display', array (
		'label'           => __( 'Display Social URL in new Window', 'blogwaves' ),
		'section'         => 'blogwaves_top_header_options',
		'priority'        => 9,
		'type'            => 'checkbox',
		'active_callback' => 'blogwaves_header_social_active_callback'
	) );


	/*General Options Section*/
	$wp_customize->add_section( 'blogwaves_general_options', array (
		'title'     => __( 'General Options', 'blogwaves' ),
		'panel'     => 'blogwaves_theme_options',
		'priority'  => 20,
		'description' => __( 'Personalize the settings of your theme.', 'blogwaves' ),
	) );

	// Read More Label
	$wp_customize->add_setting ( 'blogwaves_read_more_label', array(
		'default'           => __( 'Read More', 'blogwaves' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control ( 'blogwaves_read_more_label', array(
		'label'    => __( 'Read More Label', 'blogwaves' ),
		'section'  => 'blogwaves_general_options',
		'priority' => 1,
		'type'     => 'text',
	) );

	// Excerpt Length
	$wp_customize->add_setting ( 'blogwaves_excerpt_length', array(
		'default'           => __( '55', 'blogwaves' ),
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control ( 'blogwaves_excerpt_length', array(
		'label'    => __( 'Excerpt Length', 'blogwaves' ),
		'description' => __( '0 length will not show the excerpt.', 'blogwaves' ),
		'section'  => 'blogwaves_general_options',
		'priority' => 2,
		'type'     => 'number',
	) );

	/*layout options*/
	$wp_customize->add_section( 'blogwaves_layout_options', array (
		'title'     => __( 'Layout Options', 'blogwaves' ),
		'panel'     => 'blogwaves_theme_options',
		'priority'  => 30,
		'description' => __( 'Personalize the layout settings of your theme.', 'blogwaves' ),
	) );

	// Theme Layout
	$wp_customize->add_setting ( 'blogwaves_theme_layout', array(
		'default'           => __('wide', 'blogwaves' ),
		'sanitize_callback' => 'blogwaves_sanitize_select',
	) );

	$wp_customize->add_control ( 'blogwaves_theme_layout', array(
		'label'    => __( 'Theme Layout', 'blogwaves' ),
		'description' => __( 'Box layout will be visible at minimum 1200px display', 'blogwaves' ),
		'section'  => 'blogwaves_layout_options',
		'priority' => 1,
		'type'     => 'select',
		'choices'  => array(
			'wide' => __( 'Wide', 'blogwaves' ),
			'box'  => __( 'Box',  'blogwaves' ),
		),
	) );

	// Main Sidebar Position
	$wp_customize->add_setting ( 'blogwaves_sidebar_position', array (
		'default'           => __( 'right', 'blogwaves' ),
		'sanitize_callback' => 'blogwaves_sanitize_select',
	) );

	$wp_customize->add_control ( 'blogwaves_sidebar_position', array (
		'label'    => __( 'Sidebar Position', 'blogwaves' ),
		'section'  => 'blogwaves_layout_options',
		'priority' => 2,
		'type'     => 'select',
		'choices'  => array(
			'right' => __( 'Right Sidebar', 'blogwaves'),
			'left'  => __( 'Left Sidebar',  'blogwaves'),
			'no'    => __( 'No Sidebar',  'blogwaves'),
		),
	) );

	/*Blog Post Options*/
	$wp_customize->add_section( 'blogwaves_archive_content_options', array (
		'title'     => __( 'Blog Post Options', 'blogwaves' ),
		'panel'     => 'blogwaves_theme_options',
		'priority'  => 40,
		'description' => __( 'Setting will also apply on archieve and search page.', 'blogwaves' ),
	) );

	// Post Author Display Control
	$wp_customize->add_setting ( 'blogwaves_archive_co_post_author', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_archive_co_post_author', array (
		'label'           => __( 'Display Author', 'blogwaves' ),
		'section'         => 'blogwaves_archive_content_options',
		'priority'        => 2,
		'type'            => 'checkbox',
	) );

	// Post Date Display Control
	$wp_customize->add_setting ( 'blogwaves_archive_co_post_date', array (
		'default'           =>  true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_archive_co_post_date', array (
		'label'           => __( 'Display Date', 'blogwaves' ),
		'section'         => 'blogwaves_archive_content_options',
		'priority'        => 3,
		'type'            => 'checkbox',
	) );

	// Post Comments Display Control
	$wp_customize->add_setting ( 'blogwaves_archive_co_post_comments', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_archive_co_post_comments', array (
		'label'           => __( 'Display Comments Count', 'blogwaves' ),
		'section'         => 'blogwaves_archive_content_options',
		'priority'        => 4,
		'type'            => 'checkbox',
	) );

	// Featured Image Archive Control
	$wp_customize->add_setting ( 'blogwaves_archive_co_featured_image', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_archive_co_featured_image', array (
		'label'           => __( 'Display Featured Image', 'blogwaves' ),
		'section'         => 'blogwaves_archive_content_options',
		'priority'        => 5,
		'type'            => 'checkbox',
	) );

	/*Single Post Options*/
	$wp_customize->add_section( 'blogwaves_single_content_options', array (
		'title'     => __( 'Single Post Options', 'blogwaves' ),
		'panel'     => 'blogwaves_theme_options',
		'priority'  => 50,
		'description' => __( 'Setting will apply on the content of single posts.', 'blogwaves' ),
	) );

	// Post Categories Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_post_categories', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_post_categories', array (
		'label'           => __( 'Display Categories', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 1,
		'type'            => 'checkbox',
	) );

	// Post Author Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_post_author', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_post_author', array (
		'label'           => __( 'Display Author', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 2,
		'type'            => 'checkbox',
	) );

	// Post Date Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_post_date', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_post_date', array (
		'label'           => __( 'Display Date', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 3,
		'type'            => 'checkbox',
	) );

	// Single Post Comments Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_post_comments', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_post_comments', array (
		'label'           => __( 'Display Comments Count', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 4,
		'type'            => 'checkbox',
	) );

	// Single Post Tags Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_post_tags', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_post_tags', array (
		'label'           => __( 'Display Tags', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 5,
		'type'            => 'checkbox',
	) );

	// Featured Image Post Display Control
	$wp_customize->add_setting ( 'blogwaves_single_co_featured_image_post', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_single_co_featured_image_post', array (
		'label'           => __( 'Display Featured Image', 'blogwaves' ),
		'section'         => 'blogwaves_single_content_options',
		'priority'        => 7,
		'type'            => 'checkbox',
	) );

	/*Footer Option*/
	$wp_customize->add_section( 'blogwaves_footer_options', array (
		'title'       => __( 'Footer Options', 'blogwaves' ),
		'panel'       => 'blogwaves_theme_options',
		'priority'    => 60,
		'description' => __( 'Personalize the footer settings of your theme.', 'blogwaves' ),
	) );

	// Top Header Display Control
	$wp_customize->add_setting ( 'blogwaves_footer_copyright_display', array (
		'default'           => true,
		'sanitize_callback' => 'blogwaves_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'blogwaves_footer_copyright_display', array (
		'label'           => __( 'Display Copyright Footer', 'blogwaves' ),
		'section'         => 'blogwaves_footer_options',
		'priority'        => 1,
		'type'            => 'checkbox',
	) );

	// Copyright Control
	$wp_customize->add_setting ( 'blogwaves_copyright', array (
		'default'           => __( 'Copyright 2021 Powered by WordPress', 'blogwaves' ),
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control ( 'blogwaves_copyright', array (
		'label'    => __( 'Copyright', 'blogwaves' ),
		'section'  => 'blogwaves_footer_options',
		'priority' => 2,
		'type'     => 'textarea',
		'active_callback' => 'blogwaves_footer_copyright_callback'
	) );
}
add_action( 'customize_register', 'blogwaves_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogwaves_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogwaves_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogwaves_customize_preview_js() {
	wp_enqueue_script( 'blogwaves-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), BLOGWAVES_VERSION, true );
}
add_action( 'customize_preview_init', 'blogwaves_customize_preview_js' );

/*callback function for top header section*/
if ( !function_exists('blogwaves_header_active_callback') ) :
  function blogwaves_header_active_callback(){
  	  $show_topheader = get_theme_mod('blogwaves_top_header_display',true);
      
      if( true == $show_topheader ){
          return true;
      }
      else{
          return false;
      }
  }
endif;
if ( !function_exists('blogwaves_header_social_active_callback') ) :
  function blogwaves_header_social_active_callback(){
  	  $show_social = get_theme_mod('blogwaves_top_header_social_icon_display',true);
  	  $show_topheader = get_theme_mod('blogwaves_top_header_display',true);
      
      if( $show_social && $show_topheader ){
          return true;
      }
      else{
          return false;
      }
  }
endif;

if ( !function_exists('blogwaves_footer_copyright_callback') ) :
  function blogwaves_footer_copyright_callback(){
  
  	  $show_copyright = get_theme_mod('blogwaves_footer_copyright_display',true);
      
      if( true == $show_copyright ){
          return true;
      }
      else{
          return false;
      }
  }
endif;