<?php
/**
 * Account
 * This file will help in handling of user login/signup in miniOrange.
 *
 * @package    account
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adding required files
 */
require 'login/register.php';
require 'login/verify-password.php';

/**
 * Create new user/Login existing user using miniOrange credentials.
 */
class Mo_API_Authentication_Account {
	/**
	 * Verify miniOrange credentials of the user
	 *
	 * @return void
	 */
	public static function verify_password() {
		mo_api_authentication_verify_password_ui();
	}
	/**
	 * Show UI to register users / display logged in user information
	 *
	 * @return void
	 */
	public static function register() {
		if ( ! mo_api_authentication_is_customer_registered() ) {
			mo_api_authentication_register_ui();
		} else {
			mo_api_authentication_show_customer_info();
		}
	}
}
