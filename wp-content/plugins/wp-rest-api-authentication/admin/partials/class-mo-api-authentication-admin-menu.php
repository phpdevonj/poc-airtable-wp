<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Adding required files.
 */
require 'support/class-mo-api-authentication-support.php';
require 'support/class-mo-api-authentication-faq.php';
require 'config/class-mo-api-authentication-config.php';
require 'license/class-mo-api-authentication-license.php';
require 'account/class-mo-api-authentication-account.php';
require 'demo/class-mo-api-authentication-demo.php';
require 'postman/class-mo-api-authentication-postman.php';
require 'advanced/class-mo-api-authentication-advancedsettings.php';
require 'advanced/class-mo-api-authentication-protectedrestapis.php';
require 'custom-api-integration/class-mo-api-authentication-custom-api-integration.php';
require 'custom-api-integration/class-mo-api-authentication-third-party-integrations.php';

/**
 * Main menu
 *
 * @return void
 */
function mo_api_authentication_main_menu() {

	$currenttab = '';
	if ( isset( $_GET['tab'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are directly fetching value from URL and not form submission.
		$currenttab = sanitize_text_field( wp_unslash( $_GET['tab'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are directly fetching value from URL and not form submission.
	}

	if ( ! get_option( 'mo_save_settings' ) ) {
		update_option( 'mo_save_settings', 0 );
	}
	?>

	<div>

	<div style="margin-left: -1.8%">
		<?php if ( ! isset( $_GET['tab'] ) || ( isset( $_GET['tab'] ) && sanitize_text_field( wp_unslash( $_GET['tab'] ) ) !== 'licensing' ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are directly fetching value from URL and not form submission. ?>
		<div class="mo_api_top_menu">
			<a href="https://plugins.miniorange.com/wordpress-rest-api-authentication" target="_blank" ><img style="float:left;width: 13.75em;height: 6em; margin-top: -10px;margin-left: -225px;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/miniorange-full-logo.png"></a>
			<a href="https://faq.miniorange.com/" target="_blank"><h2 class="mo_api_top_menu_h2"><img class="mo_api_top_menu_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/faq.png">&nbsp;FAQ</h2></a>
			<a href="https://plugins.miniorange.com/wordpress-rest-api-authentication#rest-api-methods" target="_blank"><h2 class="mo_api_top_menu_h2"><img class="mo_api_top_menu_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/know-how.png">&nbsp;Learn-More</h2></a>
			<a href="admin.php?page=mo_api_authentication_settings&tab=postman"><h2 class="mo_api_top_menu_h2"><img class="mo_api_top_menu_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/postman.png">&nbsp;Postman-Samples</h2></a>
			<a href="https://wordpress.org/support/plugin/wp-rest-api-authentication/" target="_blank"><h2 class="mo_api_top_menu_h2"><img class="mo_api_top_menu_img" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/wordpress-logo.png">&nbsp;WordPress Forum</h2></a>
		</div>
	</div>
		<div class="mo_api_side_bar">
			<div id="mo_api_side_bar_content" style="padding-top: 3.5em;">
				<div class="<?php echo ( '' === $currenttab || 'config' === $currenttab ) ? 'mo_api_side_bar_select' : ''; ?> " >
				<a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 2em;height: 2em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/setting.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Configure Methods</p>
					</div>
				</a>
			</div>
				<div class="
				<?php
				if ( 'protectedrestapis' === $currenttab ) {
					echo 'mo_api_side_bar_select';}
				?>
					" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=protectedrestapis" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 1.8em;height: 1.8em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/shield.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Protected REST APIs</p>
					</div>
				</a>
			</div>
				<div class="
				<?php
				if ( 'advancedsettings' === $currenttab ) {
					echo 'mo_api_side_bar_select';}
				?>
					" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=advancedsettings" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 1.8em;height: 1.8em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/settings.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Advanced Settings</p>
					</div>
				</a>
			</div>

				<div class="
				<?php
				if ( 'custom-integration' === $currenttab ) {
					echo 'mo_api_side_bar_select';}
				?>
					" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=custom-integration" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 1.8em;height: 1.8em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/controller.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Custom APIs Auth</p>
					</div>
				</a>				
			</div>
			<div class="
			<?php
			if ( 'third-party-integration' === $currenttab ) {
				echo 'mo_api_side_bar_select';}
			?>
				" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=third-party-integration" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 1.8em;height: 1.8em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/controller.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Third Party Integrations</p>
					</div>
				</a>				
			</div>
				<div class="
				<?php
				if ( 'requestfordemo' === $currenttab ) {
					echo 'mo_api_side_bar_select';}
				?>
					" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=requestfordemo" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 2em;height: 2em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/trial.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Premium Trials</p>
					</div>
				</a>
			</div>
			<div class="
			<?php
			if ( 'account' === $currenttab ) {
				echo 'mo_api_side_bar_select';}
			?>
				" >
				<a href="admin.php?page=mo_api_authentication_settings&tab=account" style="text-decoration:none">
					<div style="text-align: center;padding-bottom: 1px;">
						<img style="width: 2em;height: 2em;display: block;padding-left: 8.5em;" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/account.png">
						<p style="color: white;font-size: 1.3em;margin-top: 2px;text-align: center">Account Setup</p>
					</div>
				</a>
			</div>
		</div>
		</div>

			<?php

		} else {
			?>

		<div style="background-color:#f9f9f9;  display: flex;justify-content: center; padding-bottom:7px;padding-top:20px;" id="nav-container">
			<div>
				<a style="font-size: 16px; color: #000;text-align: center;text-decoration: none;display: inline-block;" href="<?php echo ! empty( $_SERVER['REQUEST_URI'] ) ? esc_url( add_query_arg( array( 'tab' => 'config' ), sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) ) : ''; ?>">
					<button id="Back-To-Plugin-Configuration" type="button" value="Back-To-Plugin-Configuration" class="button button-primary button-large" style="position:absolute;left:15px;background: #473970">
						<span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span> 
						Plugin Configuration
					</button> 
				</a> 
			</div>
			<div style="display:block;text-align:center;margin: 10px;">
				<p style="font-size: 20px;font-weight: 800">miniOrange REST API Authentication</p>
			</div>
		</div>
			<?php
		}

		$mo_licensing_width        = '';
		$mo_api_main_dashboard_css = '';

		if ( isset( $_GET['tab'] ) && sanitize_text_field( wp_unslash( $_GET['tab'] ) ) === 'licensing' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are directly fetching value from URL and not form submission.
			$mo_licensing_width        = 'width:100%';
			$mo_api_main_dashboard_css = 'mo_api_main_dashboard2';
		} else {
			$mo_licensing_width        = 'width:73%';
			$mo_api_main_dashboard_css = 'mo_api_main_dashboard';
		}

		?>
		<div class="<?php echo esc_attr( $mo_api_main_dashboard_css ); ?>">
	<?php

	$mo_api_auth_message_flag  = get_option( 'mo_api_auth_message_flag' );
	$mo_api_auth_message_class = '';

	if ( 2 === $mo_api_auth_message_flag ) {
		$mo_api_auth_message_class = 'mo_api_auth_admin_custom_notice_alert';
	} elseif ( 1 === $mo_api_auth_message_flag ) {
		$mo_api_auth_message_class = 'mo_api_auth_admin_custom_notice_success';
	}

	if ( $mo_api_auth_message_flag ) {
		update_option( 'mo_api_auth_message_flag', 0 );
		?>

		<div class="<?php echo esc_attr( $mo_api_auth_message_class ); ?>" ><b><p style="font-size: 12px;"><?php echo esc_html( get_option( 'mo_api_auth_message' ) ); ?></p></b></div>
		<br>
		<?php
	}

	echo '
	<div id="mo_api_authentication_settings" style="padding-left:1em;">';
		echo '
		<div class="miniorange_container" style="padding-left:1em;">';
		echo '
		<table style="width:100%;">
			<tr>
				<td style="vertical-align:top;' . esc_attr( $mo_licensing_width ) . ';" class="mo_api_authentication_content">';
					Mo_API_Authentication_Admin_Menu::mo_api_auth_show_tab( $currenttab );
					Mo_API_Authentication_Admin_Menu::mo_api_auth_show_support_sidebar( $currenttab );
				echo '</tr>
		</table>
		<div class="mo_api_authentication_tutorial_overlay" id="mo_api_authentication_tutorial_overlay" hidden></div>
		</div>';
	?>
		</div>
	</div>

	<?php
}


/**
 * Admin Menu
 */
class Mo_API_Authentication_Admin_Menu {

	/**
	 * Show current tab
	 *
	 * @param mixed $currenttab current tab user is viewing.
	 * @return void
	 */
	public static function mo_api_auth_show_tab( $currenttab ) {
		if ( 'account' === $currenttab ) {
			if ( get_option( 'mo_api_authentication_verify_customer' ) === 'true' ) {
				Mo_API_Authentication_Account::verify_password();
			} elseif ( trim( get_option( 'mo_api_authentication_email' ) ) !== '' && trim( get_option( 'mo_api_authentication_admin_api_key' ) ) === '' && get_option( 'mo_api_authentication_new_registration' ) !== 'true' ) {
				Mo_API_Authentication_Account::verify_password();
			} else {
				Mo_API_Authentication_Account::register();
			}
		} elseif ( '' === $currenttab || 'config' === $currenttab ) {
			Mo_API_Authentication_Config::mo_api_authentication_config_panel();
		} elseif ( 'protectedrestapis' === $currenttab ) {
			Mo_API_Authentication_ProtectedRestAPIs::mo_api_authentication_protected_restapis();
		} elseif ( 'advancedsettings' === $currenttab ) {
			Mo_API_Authentication_AdvancedSettings::mo_api_authentication_advanced_settings();
		} elseif ( 'custom-integration' === $currenttab ) {
			Mo_API_Authentication_Custom_API_Integration::mo_api_authentication_customintegration();
		} elseif ( 'third-party-integration' === $currenttab ) {
			Mo_API_Authentication_Third_Party_Integrations::mo_api_authentication_thirdpartyintegration();
		} elseif ( 'requestfordemo' === $currenttab ) {
			Mo_API_Authentication_Demo::mo_api_authentication_requestfordemo();
		} elseif ( 'faq' === $currenttab ) {
			Mo_API_Authentication_FAQ::mo_api_authentication_admin_faq();
		} elseif ( 'licensing' === $currenttab ) {
			Mo_API_Authentication_License::mo_api_authentication_licensing_page();
		} elseif ( 'postman' === $currenttab ) {
			Mo_API_Authentication_Postman::mo_api_authentication_postman_page();
		}

	}

	/**
	 * Display support sidebar.
	 *
	 * @param mixed $currenttab current tab user is viewing.
	 * @return void
	 */
	public static function mo_api_auth_show_support_sidebar( $currenttab ) {
		if ( 'licensing' !== $currenttab ) {
			echo '<td style="vertical-align:top;padding-left:1%;" class="mo_api_authentication_sidebar">';
			echo esc_html( Mo_API_Authentication_Support::mo_api_authentication_admin_support() );
			echo '<br>';
			echo esc_html( Mo_API_Authentication_Support::mo_api_authentication_advertise() );
			echo '<br>';
			echo esc_html( Mo_API_Authentication_Support::mo_oauth_client_setup_support() );
			echo '</td>';
		}
	}

}
