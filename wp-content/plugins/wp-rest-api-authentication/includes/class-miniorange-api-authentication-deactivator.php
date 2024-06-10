<?php
/**
 * Fired during plugin deactivation
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @package    Miniorange_Api_Authentication
 */
class Miniorange_Api_Authentication_Deactivator {

	/**
	 * Delete plugin configuration after deactivation.
	 *
	 * @return void
	 */
	public static function mo_api_authentication_deactivate() {
		delete_option( 'host_name' );
		delete_option( 'mo_api_authentication_new_registration' );
		delete_option( 'mo_api_authentication_admin_phone' );
		delete_option( 'mo_api_authentication_verify_customer' );
		delete_option( 'mo_api_authentication_admin_customer_key' );
		delete_option( 'mo_api_authentication_admin_api_key' );
		delete_option( 'mo_api_authentication_new_customer' );
		delete_option( 'mo_api_authentication_customer_token' );
		delete_option( 'mo_api_auth_message' );
		delete_option( 'mo_api_authentication_registration_status' );
		delete_option( 'mo_api_authentication_current_plugin_version' );
	}

}
