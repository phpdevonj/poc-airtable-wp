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

/**
 * [Third Party Authentication configuration.]
 */
class Mo_API_Authentication_Third_Party_Provider_Config {

	/**
	 * Third Party Provider Authentication Configuration output
	 *
	 * @return void
	 */
	public static function mo_api_auth_configuration_output() {

		?>
		<div id="mo_api_basic_authentication_support_layout" class="mo_api_authentication_support_layout">

		<form method="post" id="mo-thirdparty-authentication-method-form" action="">				
		<input type="hidden" name="action" id="mo_api_thirdpartyauth_save_config_input" value="Save Third-party Auth">
		<?php wp_nonce_field( 'mo_api_third_authentication_method_config', 'mo_api_third_authentication_method_config_fields' ); ?>	
		<div id="mo_api_authentication_support_basicoauth" class="mo_api_authentication_common_div_css">

			<button type="button" style="width:70px;float: right;background: linear-gradient(45deg, #54B6F6, #B608D8)" disabled class="button button-primary button-large">Next</button>
			<a href="admin.php?page=mo_api_authentication_settings"><button type="button" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;margin-right: 15px;">Back</button></a>
			<h4><a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration: none">Configure Methods</a> > Third-party provider Authentication Method</h4>

			<div style="display: flex;">
				<div style="float: left"><h2 class="mo_api_authentication_method_head">Third-party provider Authentication Method</h2></div>
				<div class="mo_api_authentication_premium_methods">
				<div class="mo_api_auth_inner_premium_label"><p>Premium</p></div>
			</div>
			</div>	
			<p class="mo_api_authentication_method_description">WordPress REST API Third-party provider Authentication Method involves the REST APIs access on validation against the token provided by Third-party providers like OAuth 2.0, OpenIDConnect, SAML 2.0 etc. The plugin directly validates the token with these providers and based on the response, APIs are allowed to access.</p>
			<br>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/user-guide.png" height="25px" width="25px"></div>
				<a href="https://plugins.miniorange.com/wordpress-rest-api-authentication-using-third-party-provider#step_1" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Setup Guide</p></div></a>
			</div>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/document.png" height="25px" width="25px"></div>
				<a href="https://developers.miniorange.com/docs/rest-api-authentication/wordpress/third-party-provider-authentication" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Developer Doc</b></p></div></a>
			</div>

			<br><br>
			<div class="mo_api_authentication_support_layout" style="border-width: 0px;padding-left: 2px">
				<br>
				<h3 style="margin-top: 40px">Select Third-party provider / Federated Identity -</h3>
				<br>
				<div class="mo_api_authentication_card_layout_internal" style="width: 100%">

					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/oauth.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">OAuth 2.0 Provider</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/oidc.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">OpenID Connect Provider</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/saml.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">SAML 2.0 Provider</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/api.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Token via Custom API</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/wordpress-logo.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">WordPress</p></div>
					</div>
				</div>
				<div class="mo_api_authentication_card_layout_internal" style="width: 100%; margin-top: 2rem">
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/firebase.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Firebase</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/cognito.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">AWS Cognito</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/azure.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Azure AD</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/azure.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Azure B2C</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/office365.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Office 365</p></div>
					</div>
				</div>
				<div class="mo_api_authentication_card_layout_internal" style="width: 100%; margin-top: 2rem">

					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/google.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Google</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/facebook.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Facebook</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/apple.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Apple</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/linkedin.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">LinkedIn</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/twitter.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Twitter</p></div>
					</div>
				</div>
				<div class="mo_api_authentication_card_layout_internal" style="width: 100%; margin-top: 2rem">

					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/okta.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Okta</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/keycloak.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Keycloak</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/onelogin.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">OneLogin</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/shopify.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Shopify</p></div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor mo_rest_third_party_provider">
						<div class="mo_rest_tpp_auth_box">	
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/images/auth0.png' ); ?>" height="40px" width="40px">
						</div>
						<div class="mo_rest_tpp_auth_text">
							<p class="mo_rest_tpp_auth_text_p">Auth0</p></div>
					</div>
				</div>
				<br>

			</div>
			<br>
		</div>
	</form>
</div>
		<?php
	}
}
