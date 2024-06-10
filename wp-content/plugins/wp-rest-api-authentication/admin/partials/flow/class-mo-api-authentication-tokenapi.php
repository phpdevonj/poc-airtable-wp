<?php
/**
 * Handle API protection
 * This file will handle the API Key flow to protect the REST APIs.
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
 * [Handle API Key authentication method for API protection]
 */
class Mo_API_Authentication_TokenAPI {

	/**
	 * Check if request is valid.
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

			if ( isset( $authorization_header[0] ) && ( strcasecmp( $authorization_header[0], 'Bearer' ) === 0 ) && isset( $authorization_header[1] ) && '' !== $authorization_header[1] ) {
				$ip_token     = $authorization_header[1];
				$bearer_token = get_option( 'mo_api_auth_bearer_token' );
				if ( $ip_token === $bearer_token ) {
					return true;
				} else {
					$response = array(
						'status'            => 'error',
						'error'             => 'INVALID_API_KEY',
						'code'              => '401',
						'error_description' => 'Sorry, you are using invalid API Key.',
					);
					wp_send_json( $response, 401 );
				}
			} else {
				$response = array(
					'status'            => 'error',
					'error'             => 'INVALID_AUTHORIZATION_HEADER_TOKEN_TYPE',
					'code'              => '401',
					'error_description' => 'Authorization header must be type of Bearer Token.',
				);
				wp_send_json( $response, 401 );
			}
		} else {
			$response = array(
				'status'            => 'error',
				'error'             => 'MISSING_AUTHORIZATION_HEADER',
				'code'              => '401',
				'error_description' => 'Authorization header not received. Either authorization header was not sent or it was removed by your server due to security reasons.',
			);
			wp_send_json( $response, 401 );
		}
	}
}
