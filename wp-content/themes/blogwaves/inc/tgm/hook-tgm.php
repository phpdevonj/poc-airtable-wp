<?php
/**
 * Recommended plugins
 *
 * @package Blogwaves
 */

if ( ! function_exists( 'blogwaves_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function blogwaves_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'Accordion Slider Gallery', 'blogwaves' ),
                'slug'     => 'accordion-slider-gallery',
                'required' => false,
            ),
			
			 array(
                'name'     => esc_html__( 'Timeline', 'blogwaves' ),
                'slug'     => 'timeline-event-history',
                'required' => false,
            ),
          
             array(
                'name'     => esc_html__( 'Photo Gallery', 'blogwaves' ),
                'slug'     => 'photo-gallery-builder',
                'required' => false,
            ),
			 array(
                'name'     => esc_html__( 'Blog Manager', 'blogwaves' ),
                'slug'     => 'blog-manager-wp',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'blogwaves_recommended_plugins' );
