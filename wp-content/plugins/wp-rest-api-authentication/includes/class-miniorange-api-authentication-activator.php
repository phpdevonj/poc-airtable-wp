<?php
/**
 * Fired during plugin activation
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * This class defines all code necessary to run during the plugin's activation.
 */
class Miniorange_Api_Authentication_Activator {

	/**
	 * Plugin activator.
	 *
	 * @return void
	 */
	public static function activate() {
		update_option( 'host_name', 'https://login.xecurify.com' );

		mo_api_authentication_reset_api_protection();

	}

}
