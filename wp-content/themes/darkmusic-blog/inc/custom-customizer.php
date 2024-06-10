<?php

//--------------------------Theme Information File------------------

if( class_exists( 'WP_Customize_control' ) ){

    class darkmusic_blog_Custom_Text extends WP_Customize_Control
    {
        /**
        * Render the content on the theme customizer page
        */
        public function render_content()
        {
            ?>
            <label>
                <strong class="customize-text_editor"><?php echo wp_kses_post( $this->label ); ?></strong>
                <br />
                <span class="customize-text_editor_desc">
                    <?php echo wp_kses_post( $this->description ); ?>
                </span>
            </label>
            <?php
        }
    }//editor close
    
}//class close


//---------------------Custumizer Code------

add_action( 'customize_register', 'darkmusic_blog_customizer_theme_info' );

function darkmusic_blog_customizer_theme_info( $wp_customize ) {
  
    $wp_customize->add_section( 'darkmusic_blog_theme_info_section' , array(
    'title'       => esc_html__( 'Theme Information' , 'darkmusic-blog' ),
    'priority' => 2
  ) );
    

  $wp_customize->add_setting( 'theme_info', array(
    'default' => '',
    'sanitize_callback' => 'wp_kses_post',
  ) );
    
    $theme_info = '';
  
  $theme_info .= '<span class="sticky_info_row wp-clearfix"><label class="row-element">' . esc_html__( 'Theme Details', 'darkmusic-blog' ) . ': </label><a class="button alignright" href="' . esc_url( 'https://cawpthemes.com/darkmusic-blog-free-wordpress-theme/' ) . '" target="_blank">' . esc_html__( 'Click Here', 'darkmusic-blog' ) . '</a></span><hr>';

  $theme_info .= '<span class="sticky_info_row wp-clearfix"><label class="row-element">' . esc_html__( 'Documentation', 'darkmusic-blog' ) . ': </label><a class="button alignright" href="' . esc_url( 'https://cawpthemes.com/docs/darkmusic-blog-free-documentation/' ) . '" target="_blank">' . esc_html__( 'Click Here', 'darkmusic-blog' ) . '</a></span><hr>';
  $theme_info .= '<span class="sticky_info_row wp-clearfix"><label class="row-element">' . esc_html__( 'Demo', 'darkmusic-blog' ) . ': </label><a class="button alignright" href="' . esc_url('https://demo.cawpthemes.com/darkmusic-pro/' ) . '" target="_blank">' . esc_html__( 'Click Here', 'darkmusic-blog' ) . '</a></span><hr>';
  $theme_info .= '<span class="sticky_info_row wp-clearfix"><label class="row-element">' . esc_html__( 'Need Support', 'darkmusic-blog' ) . ': </label><a class="button alignright" href="' . esc_url( 'https://cawpthemes.com/support/' ) . '" target="_blank">' . esc_html__( 'Click Here', 'darkmusic-blog' ) . '</a></span><hr>';

  $wp_customize->add_control( new darkmusic_blog_Custom_Text( $wp_customize ,'theme_info',array(
    'section' => 'darkmusic_blog_theme_info_section',
    'label' => $theme_info
  ) ) );

}


//-------------------------Premium Information Display Code------

add_action( 'customize_register', 'darkmusic_blog_customizer_premium_features' );

function darkmusic_blog_customizer_premium_features( $wp_customize ) {
    

    $wp_customize->add_setting( 'premium_features', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $premium_features = '<div class="premium-info"><h2>' . esc_html__( 'Premium Version', 'darkmusic-blog' ) . ': </h2>

        <p>' . esc_html__( 'Would you like to enhance the appearance and functionality of your website with an extended range of color options, font styles, and the ability to modify your footer copyright information? Consider upgrading to the pro version of your current theme, which may also include premium support and additional features to further customize your website.', 'darkmusic-blog' ) . '</p>
        <ul>
        <li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Premium Design', 'darkmusic-blog' ) . '</li>
        <li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'More Home Page Section', 'darkmusic-blog' ) . '</li>
        <li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Edit Footer Copyright Information', 'darkmusic-blog' ) . '</li>
        <li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Premium Support', 'darkmusic-blog' ) . '</li>
        <ul>
        <hr>

    <a class="button button-primary" href="' . esc_url( 'https://cawpthemes.com/darkmusic-blog-premium-wordpress-theme/' ) . '" target="_blank">' . esc_html__( 'Upgrade to Premium Version', 'darkmusic-blog' ) . '</a></div>';

    $wp_customize->add_control( new darkmusic_blog_Custom_Text( $wp_customize ,'premium_features',array(
        'section' => 'darkmusic_blog_theme_info_section',
        'label' => $premium_features
    ) ) );

}



// ------------------------Theme More Premium Section Code-------
