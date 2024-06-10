<?php
/**
 * Handle API protection
 * This file will handle the JWT Authentication flow to protect the REST APIs.
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
 * [Handle JWT authentication method for API protection]
 */
class Mo_API_Authentication_JWT_Auth {

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
				$jwt_token = explode( '.', $authorization_header[1] );
				$jwt       = new Mo_API_Authentication_JWT_Auth();

				if ( $jwt->mo_api_auth_jwt_token_segment_validation( $jwt_token ) ) {
					return $jwt->mo_api_auth_jwt_signature_validation( $jwt_token );
				} else {
					$response = array(
						'status'            => 'error',
						'error'             => 'SEGMENT_FAULT',
						'code'              => '401',
						'error_description' => 'Incorrect JWT Format.',
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
		}
		$response = array(
			'status'            => 'error',
			'error'             => 'MISSING_AUTHORIZATION_HEADER',
			'code'              => '401',
			'error_description' => 'Authorization header not received. Either authorization header was not sent or it was removed by your server due to security reasons.',
		);
		wp_send_json( $response, 401 );
	}

	/**
	 * Decode JWT token
	 *
	 * @param mixed $text text to be decoded.
	 * @return string
	 */
	public function mo_api_authentication_base64_url_decode( $text ) {
		return sanitize_text_field( base64_decode( str_pad( strtr( $text, '-_', '+/' ), strlen( $text ) % 4, '=', STR_PAD_RIGHT ) ) ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Using base64 for verifying standard basic authentication method
	}

	/**
	 * Check if string is JSON
	 *
	 * @param mixed $string string containing JWT token.
	 * @return bool
	 */
	public function is_json( $string ) {
		return ( json_decode( $string ) === null ) ? false : true;
	}

	/**
	 * Check JWT token segment validation.
	 *
	 * @param mixed $jwt_token variable containing the JWT token.
	 * @return bool
	 */
	public function mo_api_auth_jwt_token_segment_validation( $jwt_token ) {
		if ( ! empty( $jwt_token[1] ) ) {
			return $this->is_json( $this->mo_api_authentication_base64_url_decode( $jwt_token[0] ) ) && $this->is_json( $this->mo_api_authentication_base64_url_decode( $jwt_token[1] ) );
		}
	}

	/**
	 * Check JWT token signature validation.
	 *
	 * @param mixed $jwt_token variable containing the JWT token.
	 * @return bool
	 */
	public function mo_api_auth_jwt_signature_validation( $jwt_token ) {
		$header_json  = json_decode( $this->mo_api_authentication_base64_url_decode( $jwt_token[0] ) );
		$payload_json = json_decode( $this->mo_api_authentication_base64_url_decode( $jwt_token[1] ) );
		$signing_algo = $header_json->alg;

		if ( get_option( 'mo_api_authentication_jwt_signing_algorithm' ) === $signing_algo ) {
			$signature            = hash_hmac( 'sha256', $jwt_token[0] . '.' . $jwt_token[1], get_option( 'mo_api_authentication_jwt_client_secret' ), true );
			$base64_url_signature = mo_api_authentication_base64_url_encode( $signature );

			if ( isset( $jwt_token[2] ) && hash_equals( $base64_url_signature, $jwt_token[2] ) ) {
				$user_data = json_decode( $this->mo_api_authentication_base64_url_decode( $jwt_token[1] ) );
				$user      = get_user_by( 'login', $user_data->name );
				wp_set_current_user( $user->ID );
				return true;
			} else {
				$response = array(
					'status'            => 'error',
					'error'             => 'INVALID_SIGNATURE',
					'code'              => '401',
					'error_description' => 'JWT Signature is invalid.',
				);
				wp_send_json( $response, 401 );
			}
		}
		return false;
	}

}
