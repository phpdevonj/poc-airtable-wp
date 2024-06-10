<?php
/**
 * Add custom settings and controls to the WordPress Customizer
 */


//---------------------Code to add the Upgrade to Pro button in the Customizer----------

function darkmusic_blog_customize_register_btn( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    get_template_part('inc/customizer-button/sanitize');
    get_template_part('inc/customizer-button/upsell-section');


    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'darkmusic_blog_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'darkmusic_blog_customize_partial_blogdescription',
        ) );
    }

    $wp_customize->register_section_type( 'darkmusic_blog_Customize_Upsell_Section' );

    // Register section.
    $wp_customize->add_section(
        new darkmusic_blog_Customize_Upsell_Section(
            $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Darkmusic Blog Pro', 'darkmusic-blog' ),
                'pro_text' => esc_html__( 'Upgrade To Pro', 'darkmusic-blog' ),
                'pro_url'  => 'https://cawpthemes.com/darkmusic-blog-premium-wordpress-theme/',
                'priority' => 1,
            )
        )
    );
}
add_action( 'customize_register', 'darkmusic_blog_customize_register_btn' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function darkmusic_blog_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function darkmusic_blog_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function darkmusic_blog_customize_preview_js() {
    wp_enqueue_script( 'darkmusic-blog-customizer', get_template_directory_uri() . '/inc/customizer-button/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'darkmusic_blog_customize_preview_js' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.0
 */
function darkmusic_blog_customizer_control_scripts() {

    wp_enqueue_style( 'darkmusic-blog-customize-controls', get_template_directory_uri() . '/inc/customizer-button/customize-controls.css', '', '1.0.0' );

    wp_enqueue_script( 'darkmusic-blog-customize-controls', get_template_directory_uri() . '/inc/customizer-button/customize-controls.js', array( 'customize-controls' ), '1.0.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'darkmusic_blog_customizer_control_scripts', 0 );


//---------------------Code to add the Upgrade to Pro button in the Customizer End----------


//------------------Theme Information--------------------

function darkmusic_blog_customize_register( $wp_customize ) {



      // Add a custom setting for the Site Identity color
  $wp_customize->add_setting( 'darkmusic_blog_site_identity_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'darkmusic_blog_site_identity_color', array(
    'label' => __( 'Site Identity Color', 'darkmusic-blog' ),
    'section' => 'title_tagline',
    'settings' => 'darkmusic_blog_site_identity_color',
  ) ) );


  // Add a custom setting for the Site Identity color
  $wp_customize->add_setting( 'darkmusic_blog_site_identity_tagline_color', array(
    'default' => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'darkmusic_blog_site_identity_tagline_color', array(
    'label' => __( 'Tagline Color', 'darkmusic-blog' ),
    'section' => 'title_tagline',
    'settings' => 'darkmusic_blog_site_identity_tagline_color',
  ) ) );

//------------------Site Identity Ends---------------------


  
  // Add a custom setting for the primary color
  $wp_customize->add_setting( 'darkmusic_blog_primary_color', array(
    'default' => '#d50259',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  // Add a custom control for the primary color
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'darkmusic_blog_primary_color', array(
    'label' => __( 'Primary Color', 'darkmusic-blog' ),
    'section' => 'colors',
    'settings' => 'darkmusic_blog_primary_color',
  ) ) );

  //-----------------------------------Home Front Page-------------------------------

  $wp_customize->add_panel( 'darkmusic_blog_panel', array(
    'title'    => __( 'Front Page Settings', 'darkmusic-blog' ),
    'priority' => 6,
  ) );

  //-----------------------------------------------------------------Section One (Featured Post)------------------------------------------

  $wp_customize->add_section( 'darkmusic_blog_section1', array(
        'title'    => __( 'Latest Post', 'darkmusic-blog' ),
        'priority' => 10,
        'panel'    => 'darkmusic_blog_panel',
    ) );


  //-----------------Enable Option Section One-------------

  $wp_customize->add_setting('darkmusic_blog_section1_enable',array(
      'default' => 'Enable',
      'sanitize_callback' => 'darkmusic_blog_sanitize_choices'
  ));
  $wp_customize->add_control('darkmusic_blog_section1_enable',array(
        'type' => 'radio',
        'label' => __('Do you want this section', 'darkmusic-blog'),
        'section' => 'darkmusic_blog_section1',
        'choices' => array(
            'Enable' => __('Enable', 'darkmusic-blog'),
            'Disable' => __('Disable', 'darkmusic-blog')
  )));

    //--------------Section One Title-----------------------

    $wp_customize->add_setting('darkmusic_blog_section1_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('darkmusic_blog_section1_title',array(
      'label' => __('Section Title','darkmusic-blog'),
      'section' => 'darkmusic_blog_section1',
      'setting' => 'darkmusic_blog_section1_title',
      'type'    => 'text'
    )
  ); 

  //-----------Category One------------

  $categories = get_categories();
  $cats = array();
  $i = 0;
  foreach($categories as $category){
    if($i==0){
      $default = $category->name;
      $i++;
    }
    $cats[$category->name] = $category->name;
  }

  $wp_customize->add_setting('darkmusic_blog_section1_category_one',array(
    'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_one',array(
    'type'    => 'select',
    'choices' => $cats,
    'label' => __('Select Category to display Post on Column One','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
  ));

  $wp_customize->add_setting('darkmusic_blog_section1_category_number_of_posts_setting_one',array(
    'default' => '6',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_number_of_posts_setting_one',array(
    'label' => __('Number of Posts to display Post on Column One','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
    'setting' => 'darkmusic_blog_section1_category_number_of_posts_setting_one',
    'type'    => 'number'
  ));

  //-----------Category two------------

  $categoriestwo = get_categories();
  $catstwo = array();
  $i = 0;
  foreach($categoriestwo as $categorytwo){
    if($i==0){
      $default = $categorytwo->name;
      $i++;
    }
    $catstwo[$categorytwo->name] = $categorytwo->name;
  }

  $wp_customize->add_setting('darkmusic_blog_section1_category_two',array(
    'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_two',array(
    'type'    => 'select',
    'choices' => $catstwo,
    'label' => __('Select Category to display Post on Column Two','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
  ));

  $wp_customize->add_setting('darkmusic_blog_section1_category_number_of_posts_setting_two',array(
    'default' => '6',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_number_of_posts_setting_two',array(
    'label' => __('Number of Posts to display Post on Column Two','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
    'setting' => 'darkmusic_blog_section1_category_number_of_posts_setting_two',
    'type'    => 'number'
  ));

  //-----------Category Three------------

  $categoriesthree = get_categories();
  $catsthree = array();
  $i = 0;
  foreach($categoriesthree as $categorythree){
    if($i==0){
      $default = $categorythree->name;
      $i++;
    }
    $catsthree[$categorythree->name] = $categorythree->name;
  }

  $wp_customize->add_setting('darkmusic_blog_section1_category_three',array(
    'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_three',array(
    'type'    => 'select',
    'choices' => $catsthree,
    'label' => __('Select Category to display Post on Column Three','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
  ));

  $wp_customize->add_setting('darkmusic_blog_section1_category_number_of_posts_setting_three',array(
    'default' => '6',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('darkmusic_blog_section1_category_number_of_posts_setting_three',array(
    'label' => __('Number of Posts to display Post on Column Three','darkmusic-blog'),
    'section' => 'darkmusic_blog_section1',
    'setting' => 'darkmusic_blog_section1_category_number_of_posts_setting_three',
    'type'    => 'number'
  )); 



//------------------------Blog Page Settings--------------------------


  $wp_customize->add_section( 'darkmusic_blog_blogpage_settings', array(
        'title'    => __( 'Blog Page Settings', 'darkmusic-blog' ),
        'priority' => 10,
        'panel'    => 'darkmusic_blog_panel',
    ) );

    //--------------Section One Title-----------------------

    $wp_customize->add_setting('darkmusic_blog_blogpage_title',array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  $wp_customize->add_control('darkmusic_blog_blogpage_title',array(
      'label' => __('Blog Page Title','darkmusic-blog'),
      'section' => 'darkmusic_blog_blogpage_settings',
      'setting' => 'darkmusic_blog_blogpage_title',
      'type'    => 'text'
    )
  ); 

  //-----------Category------------

  $categories = get_categories();
  $cats = array();
  $i = 0;
  foreach($categories as $category){
    if($i==0){
      $default = $category->name;
      $i++;
    }
    $cats[$category->name] = $category->name;
  }

  $wp_customize->add_setting('darkmusic_blog_blogpage_category',array(
  'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('darkmusic_blog_blogpage_category',array(
    'type'    => 'select',
    'choices' => $cats,
    'label' => __('Select Category to Display Post on Blog Page','darkmusic-blog'),
    'section' => 'darkmusic_blog_blogpage_settings',
  ));



    $wp_customize->add_setting('darkmusic_blogblog_page_category_number_of_posts_setting',array(
    'default' => '18',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('darkmusic_blogblog_page_category_number_of_posts_setting',array(
    'label' => __('Number of Posts','darkmusic-blog'),
    'section' => 'darkmusic_blog_blogpage_settings',
    'setting' => 'darkmusic_blogblog_page_category_number_of_posts_setting',
    'type'    => 'number'
  )); 


  //-------------------------Footer Settings------------------------------


    $wp_customize->add_section( 'darkmusic_blog_footer', array(
        'title'    => __( 'Footer Settings', 'darkmusic-blog' ),
        'priority' => 10,
        'panel'    => 'darkmusic_blog_panel',
    ) );


  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'darkmusic_blog_footer_text', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'darkmusic_blog_footer_text', array(
    'label' => __( 'Footer Text', 'darkmusic-blog' ),
    'section' => 'darkmusic_blog_footer',
    'type' => 'text',
  ) );


 //-------------------404 Page-----------

  $wp_customize->add_section( 'darkmusic_blog_404page', array(
    'title'    => __( '404 Page Settings', 'darkmusic-blog' ),
    'priority' => 12,
    'panel'    => 'darkmusic_blog_panel',
    ) );


  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'darkmusic_blog_404page_title', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'darkmusic_blog_404page_title', array(
    'label' => __( 'Page Not Found Title', 'darkmusic-blog' ),
    'section' => 'darkmusic_blog_404page',
    'type' => 'text',
  ) );

  // Add a custom setting for the footer text
  $wp_customize->add_setting( 'darkmusic_blog_404page_text', array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );

  // Add a custom control for the footer text
  $wp_customize->add_control( 'darkmusic_blog_404page_text', array(
    'label' => __( 'Page Not Found Text', 'darkmusic-blog' ),
    'section' => 'darkmusic_blog_404page',
    'type' => 'text',
  ) );

//--------------------------------------General Settings------------------------------------------

  $wp_customize->add_section( 'darkmusic_blog_general', array(
        'title'    => __( 'General Settings', 'darkmusic-blog' ),
        'panel'    => 'darkmusic_blog_panel',
    ) );

    $wp_customize->add_setting( 'darkmusic_blog_post_meta_toggle_switch_control', array(
        'default'   => true,
        'sanitize_callback' => 'sanitize_text_field', // Use a suitable sanitization function based on your needs
        'transport' => 'refresh', // or 'postMessage' for instant preview without page refresh
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'darkmusic_blog_post_meta_toggle_switch_control', array(
        'label'    => __( 'Display Time/Author', 'darkmusic-blog' ),
        'section'  => 'darkmusic_blog_general',
        'settings' => 'darkmusic_blog_post_meta_toggle_switch_control',
        'type'     => 'checkbox',
    ) ) );
    
}
add_action( 'customize_register', 'darkmusic_blog_customize_register' );




