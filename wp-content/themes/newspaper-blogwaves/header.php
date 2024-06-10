<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package masonry-blogwaves
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
} ?>

<div id="page" class="site-wrapper site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'masonry-blogwaves' ); ?></a>
<?php 
$show_topheader = get_theme_mod('blogwaves_top_header_display',true);
$show_topheader_menu = get_theme_mod('blogwaves_top_header_menu_display',true);
$show_topheader_menu_date = get_theme_mod('blogwaves_top_header_menu_date_display',true);
$show_topheader_social_icon = get_theme_mod('blogwaves_top_header_social_icon_display',true);
$facebook_url = get_theme_mod('blogwaves_social_icon_fb_url','');
$twitter_url = get_theme_mod('blogwaves_social_icon_twitter_url','');
$linkedin_url = get_theme_mod('blogwaves_social_icon_linkedin_url','');
$instagram_url = get_theme_mod('blogwaves_social_icon_insta_url','');
$social_icon_target = get_theme_mod('blogwaves_social_icon_target_display',true);
?>
	<header  id="masthead" class="wp-main-header">
        <?php if($show_topheader) { ?>
    		<div class="wp-topbar-menu child-menu">
            	<div class="container">
                	<div class="row justify-content-center">
                    	<div class="col-lg-7 col-md-8 align-self-center">
                        	<div class="topbar-left text-center-md-left text-left">
                                <?php
                                if ($show_topheader_menu && has_nav_menu('top-menu')) : 
                                    wp_nav_menu(array(
                                        "theme_location"  => "top-menu",
                                    ));
                                endif;    
                                ?>
                                <?php if($show_topheader_menu_date) { ?>
                                <ul>
                                    <li><span> <?php echo date(get_option('date_format')); ?> </span></li>
                                </ul>
                            <?php } ?>
                        	</div>
                    	</div>
                    	<div class="col-lg-5 col-md-4 text-md-right text-center">
                        <?php if($show_topheader_social_icon) { ?>
                        	<div class="topbar-right">
                            	<ul class="social-area">
                                    <?php if($facebook_url != "") { ?>
                                	   <li><a href="<?php echo esc_url($facebook_url); ?>" <?php if($social_icon_target) { ?> target="_blank" <?php } ?> ><i class="fa fa-facebook"></i></a></li> 
                                    <?php } ?>
                                    <?php if($twitter_url != "") { ?>
                                	   <li><a href="<?php echo esc_url($twitter_url); ?>" <?php if($social_icon_target) { ?> target="_blank" <?php } ?> ><i class="fa fa-twitter"></i></a></li>
                                    <?php } ?>
                                    <?php if($linkedin_url != "") { ?>
                                	   <li><a href="<?php echo esc_url($linkedin_url); ?>" <?php if($social_icon_target) { ?> target="_blank" <?php } ?> ><i class="fa fa-linkedin"></i></a></li>
                                    <?php } ?>
                                    <?php if($instagram_url != "") { ?>
                                	   <li><a href="<?php echo esc_url($instagram_url); ?>" <?php if($social_icon_target) { ?> target="_blank" <?php } ?> ><i class="fa fa-instagram"></i></a></li>
                                    <?php } ?>
                            	</ul>
                        	</div>
                    <?php } ?>
                    	</div>
                	</div>
            	</div>
        	</div>
        <?php } 
        //header image
        $has_header_image = has_header_image();
        ?>
    	<div class="nav-brand" <?php if (!empty($has_header_image)) { ?> style="background-image: url(<?php echo esc_url(header_image()); ?>);" <?php } ?>>
			<div class="container">
				<div class="row">
                    <?php
                    // Site Naming
                    get_template_part( 'template-parts/site-naming' );
                    ?>
				</div>
			</div>
		</div>

		<!-- Start Navbar Area -->
<div class="container">
<nav id="site-navigation" class="main-navigation menu-bg" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'masonry-blogwaves' ); ?>">
    <button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
      <i class="icon fa fa-bars"></i>
    </button>

    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'top',
            'menu_id'        => 'top-menu',
        )
    );
    ?>


</nav>
</div>
</header>

    <div id="primary" class="site-content">