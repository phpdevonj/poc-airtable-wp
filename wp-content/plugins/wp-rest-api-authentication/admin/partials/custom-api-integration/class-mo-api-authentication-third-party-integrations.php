<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    Miniorange_Api_Authentication
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [Description Mo_API_Authentication_Third_Party_Integrations]
 */
class Mo_API_Authentication_Third_Party_Integrations {

	/**
	 * Internal redirect to display Third Party Integrations
	 *
	 * @return void
	 */
	public static function mo_api_authentication_thirdpartyintegration() {
		self::thirdparty_integration();
	}

	/**
	 * Display Third Party Integrations
	 *
	 * @return void
	 */
	public static function thirdparty_integration() {

		?>
			<div id="mo_api_authentication_password_setting_layout" class="mo_api_authentication_support_layout">

				<div style="display: flex;">
					<div style="float: left"><h2 class="mo_third_part_intg_heading">Third Party Plugin API Authentication/Integrations</h2></div>
					<div style="float: left;margin: 10px;">
					<div class="mo_api_auth_inner_premium_label"><p>Premium</p></div>
					</div>
				</div>	

				<br>

				<div class="mo_api_authentication_support_layout" style="padding-left: 5px;width: 96%">
					<br>
					<table>	
						<tr>
							<td>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Import Products to WooCommerce from any supplier API Automatically</h4>
									<p class="mo_rest_api_intg_para"> Import and sync product data from Inventories and suppliers into your WooCommerce stores using their API automatically by running the sync manually or scheduling it at your convenience. Also, send the order details back to your inventory in real-time whenever any order is placed in your WooCommerce store.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/woocommerce_third_party_intg.png' ); ?>" class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://plugins.miniorange.com/woocommerce-api-product-sync-with-woocommerce-rest-apis" target="_blank">Learn More</a>
								</div>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Access WP REST API securely from Mobile App</h4>
									<p class="mo_rest_api_intg_para"> If you have a WordPress site and the mobile application for the same and want the ability to post, comment, fetch/update user profiles from the mobile application then you can do it securely using the plugin. Our plugin provides the feature to authenticate any kind of WordPress REST API very securely.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/wordpress-logo.png' ); ?>" width='40px' height='40px' class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://blog.miniorange.com/convert-wordpress-to-android-app" target="_blank">Learn More</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Authenticate WordPress APIs with Firebase Token</h4>
									<p class="mo_rest_api_intg_para"> If you have a WordPress site and mobile app connected to Firebase and now you are using the Firebase for the user authentication and want to access the WordPress REST APIs using the token obtained from Firebase on user authentication, then you can securely access the WordPress/Woocommerce REST APIs using the Firebase id-token.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/firebase.png' ); ?>" width='35px' height='35px' class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://plugins.miniorange.com/firebase-wordpress-woocommerce-mobile-rest-api-access" target="_blank">Learn More</a>
								</div>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Authenticate WordPress APIs with Social Login Token</h4>
									<p class="mo_rest_api_intg_para"> If you have a WordPress site and mobile app in which you provide the users to login using Social login provider's app like Google, Facebook, Apple, LinkedIn etc. and want to use the access-token/id-token(JWT token) obtained from these providers to access the WordPress/Woocommerce REST API securely, then our plugin is a perfect fit for you.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/wordpress-logo.png' ); ?>" width='40px' height='40px' class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://plugins.miniorange.com/integrate-rest-api-mobile-sso-with-social-login" target="_blank">Learn More</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Login/Register users securely via WP APIs</h4>
									<p class="mo_rest_api_intg_para">If you are looking to log in your users on other applications using the credentials of the WordPress site and want the login API endpoint, then it can be achieved using our plugin's login API endpoint. The plugin takes care of registration in WordPress using the REST APIs as well.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/guarantee.png' ); ?>" width='35px' height='35px' class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://developer.wordpress.org/rest-api/reference/users" target="_blank">Learn More</a>
								</div>
								<div class="mo_rest_api_intg_cards">
									<h4 class="mo_rest_api_intg_head">Access WP REST APIs securely for Headless WordPress</h4>
									<p class="mo_rest_api_intg_para"> If you are having a headless WordPress with WordPress as the backend and front-end of React or other JS frameworks and want to access the WordPress REST APIs securely to fetch/update the data in the frontend, then our plugin helps you in achieving that securely.</p>
									<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/wordpress-logo.png' ); ?>" width='40px' height='40px' class="mo_rest_api_intg_logo" alt=" Image">
									<span class="mo_rest_api_intg_rect"></span>
									<span class="mo_rest_api_intg_tri"></span>
									<a class="mo_rest_api_intg_readmore" href="https://plugins.miniorange.com/wp-rest-api-authentication-setup-guide" target="_blank">Learn More</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
						<div class="mo_rest_api_intg_cards">
							<h4 class="mo_rest_api_intg_head">Convert WooCommerce To Mobile App</h4>
							<p class="mo_rest_api_intg_para"> If you have a store on WooCommerce and a mobile app for the same and want to fetch/update the data of Woocommerce on mobile apps via REST API, then our plugin provides the functionalities to access the Woocommerce APIs securely rather than using the Woocommerce default authentication.</p>
							<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../../images/woocommerce_third_party_intg.png' ); ?>" class="mo_rest_api_intg_logo" alt=" Image">
							<span class="mo_rest_api_intg_rect"></span>
							<span class="mo_rest_api_intg_tri"></span>
							<a class="mo_rest_api_intg_readmore" href="https://plugins.miniorange.com/woocommerce-to-mobile-app-with-woocommerce-rest-apis" target="_blank">Learn More</a>
						</div>
	</td>
						</tr>
					</table>
					<br>
				</div>
				<br>
			</div>

		<?php
	}
}
