<?php
//about theme info
add_action( 'admin_menu', 'darkmusic_blog_gettingstarted_page' );
function darkmusic_blog_gettingstarted_page() {      
    add_theme_page( esc_html__('Darkmusic Blog', 'darkmusic-blog'), esc_html__('All About Darkmusic Blog', 'darkmusic-blog'), 'edit_theme_options', 'darkmusic_blog_mainpage', 'darkmusic_blog_mostrar_guide');   
}



function darkmusic_blog_notice()
{
    global $pagenow;
    if (is_admin() && ('themes.php' == $pagenow) && isset($_GET['activated'])) {
        ?>
        <div class="notice notice-success is-dismissible getting_started">
            <div class="notice-content">
                <p><?php esc_html_e('Thank You For Choosing CA WP Themes', 'darkmusic-blog'); ?></p>
                <h2><?php esc_html_e('Thank You for installing Darkmusic Blog Free Theme!', 'darkmusic-blog') ?> </h2>
                <p><?php esc_html_e("Please Click on the link below to Check The Full Theme Edit Documentation", 'darkmusic-blog') ?></p>
                <div class="info-link">
                    <a href="<?php echo esc_url(darkmusic_blog_PRO_DOCUMENTATION); ?>" target="_blank"> <?php esc_html_e('Documentation', 'darkmusic-blog'); ?></a>
                </div>
                <h2><?php esc_html_e( 'Now the Premium Version is only at $39 with Lifetime Access!Grab the deal now!', 'darkmusic-blog' ) ?> </h2>
                <h2><?php esc_html_e('Check The Pro Version: Darkmusic Blog Premium for Amazing Features for Unlimited Site', 'darkmusic-blog'); ?></h2>
                <div class="info-link">
                    <a href="<?php echo esc_url(darkmusic_blog_PRO_URL); ?>" target="_blank"> <?php esc_html_e('Upgrade to Pro', 'darkmusic-blog'); ?></a>
                </div>
                <div class="info-link">
                    <a href="<?php echo esc_url(darkmusic_blog_PRO_DEMO); ?>" target="_blank"> <?php esc_html_e('Premium Demo', 'darkmusic-blog'); ?></a>
                </div>
            </div>
        </div>
    <?php }
}
add_action('admin_notices', 'darkmusic_blog_notice');

// Add a Custom CSS file to WP Admin Area
function darkmusic_blog_admin_page_theme_style() {
   wp_enqueue_style('darkmusic-blog-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstarted/getstarted.css');
   wp_enqueue_script('darkmusic-blog-tabs', esc_url(get_template_directory_uri()) . '/inc/getstarted/tabs.js');
}
add_action('admin_enqueue_scripts', 'darkmusic_blog_admin_page_theme_style');

//About Theme Info
function darkmusic_blog_mostrar_guide() { 

    //custom function about theme customizer

    $return = add_query_arg( array()) ;
    $theme = wp_get_theme( 'darkmusic-blog' );
?>

<div class="wrapper-info">
    <div class="col-left">
        <h2><?php esc_html_e( 'Welcome to Darkmusic Blog', 'darkmusic-blog' ); ?> <span class="version">Version: 1.0</span></h2>
        <p><?php esc_html_e('CA WP Themes is a premium WordPress theme development company that provides high-quality themes for various types of websites. They specialize in creating themes for businesses, eCommerce, portfolios, blogs, and many more. Their themes are easy to use and customize, making them perfect for those who want to create a professional-looking website without any coding skills.','darkmusic-blog'); ?></p>
        <p><?php esc_html_e('CA WP Themes offers a wide range of themes that are designed to be responsive and compatible with the latest versions of WordPress. Our themes are also SEO optimized, ensuring that your website will rank well on search engines. They come with a variety of features such as customizable widgets, social media integration, and custom page templates.','darkmusic-blog'); ?></p>
        <p><?php esc_html_e('One of the unique things about CA WP Themes is their focus on providing excellent customer support. They have a dedicated team of support staff who are available 24/7 to help customers with any issues they may encounter. Their support team is knowledgeable and friendly, ensuring that customers receive the best possible experience.','darkmusic-blog'); ?></p>
    </div>
    <div class="col-right">
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Buy Darkmusic Blog Premium Theme','darkmusic-blog'); ?></h4>
            <p><?php esc_html_e('Now the Premium Version is only at $39 with Lifetime Access!Grab the deal now!', 'darkmusic-blog'); ?></p>
            <div class="info-link">
                <a href="<?php echo esc_url( darkmusic_blog_PRO_URL ); ?>" target="_blank"> <?php esc_html_e( 'Upgrade to Pro', 'darkmusic-blog' ); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Premium Theme Demo','darkmusic-blog'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( darkmusic_blog_PRO_DEMO ); ?>" target="_blank"> <?php esc_html_e( 'Demo', 'darkmusic-blog' ); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Need Support? / Contact Us','darkmusic-blog'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( darkmusic_blog_PRO_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Contact Us', 'darkmusic-blog' ); ?></a>
            </div>
        </div>
        <hr>
        <div class="admin_text-btn">
            <h4><?php esc_html_e('Documentation','darkmusic-blog'); ?></h4>
            <div class="info-link">
                <a href="<?php echo esc_url( darkmusic_blog_PRO_DOCUMENTATION ); ?>" target="_blank"> <?php esc_html_e( 'Docs', 'darkmusic-blog' ); ?></a>
            </div>
        </div>
    </div>
</div>


<div class="new_box">
     <div class="featurebox">
        <h3><?php esc_html_e( 'Theme Information', 'darkmusic-blog' ); ?></h3>
        <div class="table-image">
            <table class="tablebox">
                <thead>
                    <tr>
                        <th></th>
                        <th><?php esc_html_e('Free Themes', 'darkmusic-blog'); ?></th>
                        <th><?php esc_html_e('Premium Themes', 'darkmusic-blog'); ?></th>
                    </tr>   
                </thead>
                <tbody>
                    <tr>
                        <td><?php esc_html_e('Theme Edit Options', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Responsive Design', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Logo Upload', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Social Media Links', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Slider Settings', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('About Us Page', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Template Pages', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('2', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('5', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Home Page Template', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('1', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('1', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Home Page sections', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('2', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><?php esc_html_e('10 to 15', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Contact us Page Template', 'darkmusic-blog'); ?></td>
                        <td class="table-img">0</td>
                        <td class="table-img"><?php esc_html_e('1', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Blog Templates & Layout', 'darkmusic-blog'); ?></td>
                        <td class="table-img">0</td>
                        <td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Page Templates & Layout', 'darkmusic-blog'); ?></td>
                        <td class="table-img">0</td>
                        <td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'darkmusic-blog'); ?></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Global Color Option', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Inbuild Demo Content', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Full Documentation Available', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Latest WordPress Compatibility', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Woo-Commerce Compatibility', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Support 3rd Party Plugins', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Secure and Optimized Code', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Exclusive Premium Functionalities', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Section Enable / Disable options', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Gallery Section', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Support to Provide Additional Required Custom CSS / JS', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Shortcodes Available', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Premium Membership', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Budget Friendly Value', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('Priority Error Fixing', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Custom Feature Addition', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr class="odd">
                        <td><?php esc_html_e('All Access Theme Pass', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e('Seamless Customer Support', 'darkmusic-blog'); ?></td>
                        <td class="table-img"><span class="dashicons dashicons-no"></span></td>
                        <td class="table-img"><span class="dashicons dashicons-saved"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="table-img"></td>
                        <td class="update-link"><a href="<?php echo esc_url( ca_charity_hope_PRO_URL ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'darkmusic-blog'); ?></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>    
</div>
<?php } ?>