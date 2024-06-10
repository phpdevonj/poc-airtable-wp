<?php


//-----------------------------Site Identity Color----------------

	$darkmusic_blog_site_identity_color = get_theme_mod('darkmusic_blog_site_identity_color');
	$darkmusic_blog_site_identity_tagline_color = get_theme_mod('darkmusic_blog_site_identity_tagline_color');

// -------------------Primary Color-------------

	$darkmusic_blog_primary_color = get_theme_mod('darkmusic_blog_primary_color');

//=====================Whole CSS===================================


	$custom_css ='.display_only h1 a,.display_only p{';
	
	$custom_css .='}';


//==============Main Setting Section===========================================


// ----------------Site Identity Color--------------------

	if($darkmusic_blog_site_identity_color != false){
		$custom_css .='.display_only h1 a{';
			if($darkmusic_blog_site_identity_color != false)
		    	$custom_css .='color: '.esc_html($darkmusic_blog_site_identity_color).'!important;';
		$custom_css .='}';
	}

	if($darkmusic_blog_site_identity_tagline_color != false){
		$custom_css .='.display_only p{';
			if($darkmusic_blog_site_identity_tagline_color != false)
		    	$custom_css .='color: '.esc_html($darkmusic_blog_site_identity_tagline_color).'!important;';
		$custom_css .='}';
	}


// ----------------Primary Color--------------------

	if($darkmusic_blog_primary_color != false){
		$custom_css .='#sidebar .widget-title,div#sidebar h2,h2.post-title a:hover, .display_only a:hover,#sidebar a:hover , h2.post-title:hover,.sec2-meta span,.nav-previous a:hover, .nav-next a:hover,.about-text-box h3,footer a:hover{';
			if($darkmusic_blog_primary_color != false)
		    	$custom_css .='color: '.esc_html($darkmusic_blog_primary_color).'!important;';
		$custom_css .='}';
	}

	if($darkmusic_blog_primary_color != false){
		$custom_css .='.wp-block-calendar table th,.button:hover,.read-more-link:hover,.singlepost-category a,.card-body a,.card-body a,.sec2-cat a,.about-box-1{';
			if($darkmusic_blog_primary_color != false)
		    	$custom_css .='background-color: '.esc_html($darkmusic_blog_primary_color).'!important;';
		$custom_css .='}';
	}


?>