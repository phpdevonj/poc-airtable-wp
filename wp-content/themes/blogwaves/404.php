<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package blogwaves
 */

get_header();
?>
<div class="error-page-section">
    <div class="container">
        <div class="error-page-inner">
            <h1><?php esc_html_e( '404', 'blogwaves' ); ?></h1>
            <h3><i class="fa fa-exclamation-triangle"></i><?php esc_html_e( ' Oh No! Page Not Found', 'blogwaves' ); ?> </h3>
            <p><?php esc_html_e( 'Sorry but the page you are looking for is not found. Please make sure you have typed the correct keyword.', 'blogwaves' ); ?></p>
            <div class="btn-group">
	            <a href="<?php echo esc_url( home_url() ) ; ?>" class="btn-back">
	                <i class="fa fa-angle-double-left"></i> <?php esc_html_e( 'Go To Home', 'blogwaves' ); ?>  
	            </a>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();