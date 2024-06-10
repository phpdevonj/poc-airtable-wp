<?php
/**
 * Handle API protection
 * This file will handle the Basic Authentication flow to protect the REST APIs.
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
 * [Handle Basic Authentication method for API protection]
 */
class Mo_API_Authentication_Basic_OAuth {

	/**
	 * Check if valid request
	 *
	 * @param mixed $headers API request headers.
	 * @return bool
	 */
	public static function mo_api_auth_is_valid_request( $headers ) {
		if ( ( isset( $headers['AUTHORIZATION'] ) && '' !== $headers['AUTHORIZATION'] ) || ( isset( $headers['AUTHORISATION'] ) && '' !== $headers['AUTHORISATION'] ) ) {
			if ( isset( $headers['AUTHORIZATION'] ) && '' !== $headers['AUTHORIZATION'] ) {
				$authorization_header = explode( ' ', $headers['AUTHORIZATION'] );
			} elseif ( isset( $headers['AUTHORISATION'] ) && '' !== $headers['AUTHORISATION'] ) {
				$authorization_header = explode( ' ', $headers['AUTHORISATION'] );
			}

			if ( isset( $authorization_header[0] ) && ( strcasecmp( $authorization_header[0], 'Basic' ) === 0 ) && isset( $authorization_header[1] ) && '' !== $authorization_header[1] ) {
				$encoded_creds       = $authorization_header[1];
				$decoded_cred_string = base64_decode( $encoded_creds ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Using base64 for verifying standard basic authentication method and ignoring sanitization because we are not storing this in database.
				$creds               = explode( ':', $decoded_cred_string, 2 );

				if ( isset( $creds[0] ) && isset( $creds[1] ) ) {
					if ( get_option( 'mo_api_authentication_authentication_key' ) === 'uname_pass' || ! empty( $_GET['mo_rest_api_test_config'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are getting data from URL and not form submission.
						// username and password.
						$uname = sanitize_user( $creds[0] );
						$pword = $creds[1];
						$user  = get_user_by( 'login', $uname );
						if ( $user ) {
							$valid_pass = wp_authenticate_username_password( null, $uname, $pword );
							if ( true !== $valid_pass ) { // Using this flow to provide additional support for password verification of websites hosted on wordpress.org.
								$valid_pass_emails = wp_authenticate_email_password( null, $uname, $pword );
								$valid_pass        = null !== $valid_pass_emails && ! is_wp_error( $valid_pass_emails ) ? $valid_pass_emails : $valid_pass;
							}
							if ( ! is_wp_error( $valid_pass ) ) {
								wp_set_current_user( $user->ID );
								return true;
							} else {
								$response = array(
									'status'            => 'error',
									'error'             => 'INVALID_PASSWORD',
									'code'              => '400',
									'error_description' => 'Incorrect password.',
								);
								wp_send_json( $response, 400 );
							}
						} else {
							$response = array(
								'status'            => 'error',
								'error'             => 'INVALID_USERNAME',
								'code'              => '400',
								'error_description' => 'Username Does not exist.',
							);
							wp_send_json( $response, 400 );
						}
					} elseif ( get_option( 'mo_api_authentication_authentication_key' ) === 'cid_secret' ) {
						// client id and client secret.
						if ( get_option( 'mo_api_auth_clientid' ) === $creds[0] && get_option( 'mo_api_auth_clientsecret' ) === $creds[1] ) {
							return true;
						} else {
							$response = array(
								'status'            => 'error',
								'error'             => 'INVALID_CLIENT_CREDENTIALS',
								'code'              => '400',
								'error_description' => 'Invalid client ID or client secret.',
							);
							wp_send_json( $response, 400 );
						}
					}
				} else {
					$response = array(
						'status'            => 'error',
						'error'             => 'INVALID_TOKEN_FORMAT',
						'code'              => '401',
						'error_description' => 'Sorry, you are not using correct format to encode string.',
					);
					wp_send_json( $response, 401 );
				}
			} else {
				$response = array(
					'status'            => 'error',
					'error'             => 'INVALID_AUTHORIZATION_HEADER_TOKEN_TYPE',
					'code'              => '401',
					'error_description' => 'Authorization header must be type of Basic Token.',
				);
				wp_send_json( $response, 401 );
			}
		}
		$response = array(
			'status'            => 'error',
			'error'             => 'MISSING_AUTHORIZATION_HEADER',
			'code'              => '401',
			'error_description' => 'Authorization header not received. Either authorization header was not sent or it was removed by your server due to security reasons.',
		);
		wp_send_json( $response, 401 );
	}
}
