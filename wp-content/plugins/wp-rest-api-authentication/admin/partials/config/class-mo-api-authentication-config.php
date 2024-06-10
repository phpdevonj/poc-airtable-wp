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
 * Adding required files.
 */
require 'output/class-mo-api-authentication-basic-oauth-config.php';
require 'output/class-mo-api-authentication-tokenapi-config.php';
require 'output/class-mo-api-authentication-jwt-auth-config.php';
require 'output/class-mo-api-authentication-oauth-client-config.php';
require 'output/class-mo-api-authentication-third-party-provider-config.php';

/**
 * [API authentication methods configuration]
 */
class Mo_API_Authentication_Config {

	/**
	 * API authentication methods configuration panel
	 *
	 * @return void
	 */
	public static function mo_api_authentication_config_panel() {
		?>
		<div id='mo_api_section_method'>
		<div class="mo_api_authentication_support_layout">
			<span>
				<p style="font-size: 20px;font-weight: 900">API Authentication Methods Configuration</p>
				<?php
				if ( get_option( 'mo_api_authentication_selected_authentication_method' ) ) {
					?>
						<button disabled><i class="fa fa-plus"></i> Add Application</button>
					<?php
				}
				?>
			</span>
			<?php
			if ( get_option( 'mo_api_authentication_selected_authentication_method' ) ) {
				?>
					<div id="mo_api_auth_add_app_message">
						<p class="mo_api_auth_note"><strong><i>Note: </i></strong>You can only configure one authentication method at a time with the free version. Please <strong><a href="admin.php?page=mo_api_authentication_settings&tab=licensing">Upgrade to All-Inclusive Plan Package</a></strong> to configure multiple authentication applications.</p>
					</div>
				<?php
			} else {
				?>
					<p style="font-size: 15px;font-weight: 500">Select any of the below authentication methods to get started - </p>
				<?php
			}
			?>
			<div class="mo_api_authentication_card_layout">
				<div class="mo_api_flex_child" id='mo_api_config_bauth' onclick="api_ajax_redir('basic auth')" style="<?php echo get_option( 'mo_api_authentication_selected_authentication_method' ) === 'basic_auth' ? 'box-shadow: 4px 4px 4px 2px rgba(0,0,0,0.1);border: 3px solid #473970' : ''; ?>" >
					<div class="mo_api_auth_method_img">
					<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ); ?>/images/basic-key.png" height="55em" width="55em"></div>
					<div class="mo_api_auth_div_internal">
					<p class="mo_api_auth_div_nested_internal">BASIC AUTHENTICATION</p></div>

				</div>
				<div class="mo_api_flex_child" onclick="api_ajax_redir('jwt auth')" style="
				<?php
				if ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'jwt_auth' ) {
					echo 'box-shadow: 4px 4px 4px 2px rgba(0,0,0,0.1);border: 3px solid #473970';}
				?>
				">
					<div class="mo_api_auth_method_img">
					<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ); ?>/images/jwt_authentication.png" height="55em" width="55em"></div>
					<div class="mo_api_auth_div_internal">
					<p class="mo_api_auth_div_nested_internal">JWT AUTHENTICATION</p></div>

				</div>
			</div>
			<br>
			<div class="mo_api_authentication_card_layout">

				<div class="mo_api_flex_child" onclick="api_ajax_redir('apikey auth')" style="
				<?php
				if ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'tokenapi' ) {
					echo 'box-shadow: 4px 4px 4px 2px rgba(0,0,0,0.1);border: 3px solid #473970';}
				?>
				">
					<div class="mo_api_auth_method_img">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ); ?>/images/api-key.png" height="55em" width="55em">
					</div>
					<div class="mo_api_auth_div_internal">
						<p class="mo_api_auth_div_nested_internal">API KEY AUTHENTICATION</p>
					</div>
					<div class="mo_api_auth_premium_label_main">
						<div class="mo_api_auth_premium_label_internal">
							<div class="mo_api_auth_premium_label_text">Premium</div>
						</div>
					</div>
				</div>
				<div class="mo_api_flex_child" onclick="api_ajax_redir('oauth2 auth')">
					<div class="mo_api_auth_method_img">
					<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ); ?>/images/oauth_2.png" height="55em" width="55em"></div>
					<div class="mo_api_auth_div_internal">
					<p class="mo_api_auth_div_nested_internal">OAUTH 2.0 AUTHENTICATION</p></div>
					<div class="mo_api_auth_premium_label_main" style='margin-left:-85px'>
						<div class="mo_api_auth_premium_label_internal">
							<div class="mo_api_auth_premium_label_text" >Premium</div>
						</div>
					</div>
					<div class="mo_api_auth_premium_label_main" >
						<div class="mo_api_auth_premium_label_internal">
							<div class="mo_api_auth_premium_label_text" style='margin-left:-16px; background-color: #ffa033'>Most Secure</div>
						</div>
					</div>

				</div>
			</div>
			<br>
			<div class="mo_api_authentication_card_layout" onclick="api_ajax_redir('thirdparty auth')">

				<div class="mo_api_flex_child">
					<div class="mo_api_auth_method_img">
					<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( __FILE__ ) ) ) ); ?>/images/third_party.png" height="55em" width="55em"></div>
					<div class="mo_api_auth_div_internal">
					<p class="mo_api_auth_div_nested_internal">THIRD-PARTY AUTHENTICATION</p></div>
					<div class="mo_api_auth_premium_label_main">
						<div class="mo_api_auth_premium_label_internal">
							<div class="mo_api_auth_premium_label_text">Premium</div>
						</div>
					</div>
				</div>
				<div class="mo_api_flex_child" style="border: 0px">

				</div>

			</div>
			<br>
		</div>
		</div>

		<div id='mo_api_section_basicauth_method' style="display: none">
			<?php
			Mo_API_Authentication_Basic_Oauth_Config::mo_api_auth_configuration_output();
			?>
		</div>
		<div id='mo_api_section_jwtauth_method' style="display: none">
			<?php
			Mo_API_Authentication_Jwt_Auth_Config::mo_api_auth_configuration_output();
			?>
		</div>
		<div id='mo_api_section_apikeyauth_method' style="display: none">
			<?php
			Mo_API_Authentication_TokenAPI_Config::mo_api_auth_configuration_output();
			?>
		</div>
		<div id='mo_api_section_oauth2auth_method' style="display: none">
			<?php
			Mo_API_Authentication_OAuth_Client_Config::mo_api_auth_configuration_output();
			?>
		</div>
		<div id='mo_api_section_thirdpartyauth_method' style="display: none">
			<?php
			Mo_API_Authentication_Third_Party_Provider_Config::mo_api_auth_configuration_output();
			?>
		</div>
		<div id="mo_api_auth_step_container" style="display: none;padding-top: 200px;">
			<h2 style="text-align: center;color: white;padding-top: 25px;font-size: 20px"><span>&#9751;</span> Configuration Tracker</h2>
			<div class="mo_step_container" style="padding-top: 25px;">
			<div class="step completed">
				<div class="v-stepper">
				<div class="circle"></div>
				<div class="line"></div>
				</div>

				<div class="content">
				Configure Authentication Method
				</div>
		</div>
		<div class="step active" id="basic_authentication_finish_stepper">
			<div class="v-stepper">
			<div class="circle"></div>
			<div class="line"></div>
			</div>

			<div id="mo_api_auth_flow_method_name" class="content">
			Basic Authentication Method Configurations (Pre-Configured)
			</div>
		</div>
		<div class="step active">
		<div class="v-stepper">
			<div class="circle"></div> 
		</div>

		<div class="content">
			Save Configuration and get started
		</div>
		</div>

		</div>
		</div>	

		<script>

			function api_ajax_redir(auth_method){

				div = document.getElementById('mo_api_section_method');
				div.style.display = "none";
				if(auth_method == "basic auth"){
					handle_auth_display('mo_api_section_basicauth_method', 'Basic Authentication Method Configurations (Pre-Configured)');
				}
				else if(auth_method == "jwt auth"){
					handle_auth_display('mo_api_section_jwtauth_method', 'JWT Authentication Method Configurations (Pre-Configured)');
				}
				else if(auth_method == "apikey auth"){
					handle_auth_display('mo_api_section_apikeyauth_method', 'API Key Authentication Method Configurations (Pre-Configured)');
				}
				else if(auth_method == "oauth2 auth"){
					handle_auth_display('mo_api_section_oauth2auth_method', 'OAuth 2.0 Authentication Method Configurations (Pre-Configured)');
				}
				else if(auth_method == "thirdparty auth"){
					handle_auth_display('mo_api_section_thirdpartyauth_method', '3rd Party Authentication Method Configurations (Pre-Configured)');
				}
			}

			function handle_auth_display(section, display_text) {
				div2 = document.getElementById(section);
				div2.style.display = "block";
				close_success_message('mo_api_auth_admin_custom_notice_success');
				close_success_message('mo_api_auth_admin_custom_notice_alert');
				document.getElementById('mo_api_side_bar_content').innerHTML = document.getElementById('mo_api_auth_step_container').innerHTML;
				document.getElementById('mo_api_auth_flow_method_name').innerHTML = display_text;
			}

			function close_success_message(classname) {
				if(document.getElementsByClassName(classname)[0] != undefined) {
					document.getElementsByClassName(classname)[0].style.display = "none";
				}
			}

		</script>

		<?php
	}

}
