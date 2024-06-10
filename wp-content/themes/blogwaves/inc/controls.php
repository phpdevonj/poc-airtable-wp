<?php

/**
 * excerpt lenth.
 */
if (!function_exists('blogwaves_custom_excerpt_length')) :
    function blogwaves_custom_excerpt_length($length)
    {
        if (is_admin()) {
            return $length;
        }

        $excerpt_length = get_theme_mod('blogwaves_excerpt_length','55');
        if (!empty($excerpt_length)) {
            return $excerpt_length;
        }
        return 55;
    }
endif;
add_filter('excerpt_length', 'blogwaves_custom_excerpt_length');

function blogwaves_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function blogwaves_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

function blogwaves_excerpt_more( $more ) {
	if ( is_admin() ) {
		$more = '...';
   		return $more;
   	}
}
add_filter('excerpt_more', 'blogwaves_excerpt_more');