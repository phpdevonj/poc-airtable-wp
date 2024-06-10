<?php
/**
 * The template for displaying site branding
 * @package blogwaves
 */
?>

<div class="blogwave-site-naming-wrapper logo-area text-center">

	<?php
	// Site Custom Logo
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
	?>
	<div class="blogwave-site-branding">
		
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		
		
		<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
		?>
		<p class="site-description">
			<?php echo esc_html( $description ); ?>
		</p>
		<?php endif; ?>
		
	</div>
</div>