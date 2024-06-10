<?php
/**
 * Authentication flow
 * Fetch the token from token endpoint of JWT Authentication method.
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
require_once 'class-mo-api-authentication-basic-oauth.php';
require_once 'class-mo-api-authentication-tokenapi.php';
require_once 'class-mo-api-authentication-jwt-auth.php';

/**
 * Check user capability
 *
 * @return bool
 */
function mo_api_auth_user_has_capability() {
	$found      = false;
	$user       = wp_get_current_user();
	$user_roles = array( 'author', 'editor', 'contributor', 'subscriber', 'administrator' );
	foreach ( $user->caps as $caps ) {
		$found[ $caps ] = in_array( $caps, $user_roles, true ) ? true : false;
	}
	return $found;
}

/**
 * Token endpoint flow.
 *
 * @param mixed $request API request content.
 * @return void
 */
function mo_api_auth_token_endpoint_flow( $request ) {
	mo_api_auth_method_get_token( $request );
}
/**
 * Fetch token.
 *
 * @param mixed $request API request content.
 * @return void
 */
function mo_api_auth_method_get_token( $request ) {
	if ( isset( $request['username'] ) && isset( $request['password'] ) ) {
		$username = $request['username'];
		$password = $request['password'];

		$client_secret = sanitize_text_field( get_option( 'mo_api_authentication_jwt_client_secret' ) );

		if ( false === $client_secret || '' === $client_secret ) {
			$response = array(
				'status'            => 'error',
				'error'             => 'BAD_REQUEST',
				'code'              => '401',
				'error_description' => 'Sorry, client secret is required to make a request. Contact to your administrator.',
			);
			wp_send_json( $response, 401 );
		}

		$user = get_user_by( 'login', $username );
		if ( $user ) {
			wp_set_current_user( $user->ID );

			$valid_pass = wp_authenticate_username_password( null, $username, $password );
			if ( is_wp_error( $valid_pass ) ) { // Using this flow to provide additional support for password verification of websites hosted on wordpress.org.
				$valid_pass_emails = wp_authenticate_email_password( null, $username, $password );
				$valid_pass        = null !== $valid_pass_emails && ! is_wp_error( $valid_pass_emails ) ? $valid_pass_emails : $valid_pass;
			}

			if ( is_wp_error( $valid_pass ) ) {
				$valid_pass = false;
			} else {
				$valid_pass = true;
			}
		}

		if ( isset( $valid_pass ) && $valid_pass ) {
			$token_data = '';
			$token_data = mo_api_auth_create_jwt_token( $client_secret, $user );
			$response   = rest_ensure_response( $token_data );
			echo wp_json_encode( $token_data );
			exit;
		} else {
			$response = array(
				'status'            => 'error',
				'error'             => 'INVALID_CREDENTIALS',
				'code'              => '400',
				'error_description' => 'Invalid username or password.',
			);
			wp_send_json( $response, 400 );
		}
	} else {
		$response = array(
			'status'            => 'error',
			'error'             => 'FORBIDDEN',
			'code'              => '403',
			'error_description' => 'Username and password are required.',
		);
		wp_send_json( $response, 403 );
	}
}

/**
 * Create JWT token.
 *
 * @param mixed $client_secret client secret for the JWT authentication method.
 * @param mixed $user WP user data.
 * @return string
 */
function mo_api_auth_create_jwt_token( $client_secret, $user ) {

	$iat = time();
	$exp = time() + 157680000;

	// Create the token header.
	$header = wp_json_encode(
		array(
			'alg' => 'HS256',
			'typ' => 'JWT',
		)
	);

	// Create the token payload.
	$payload = wp_json_encode(
		array(
			'sub'  => $user->ID,
			'name' => $user->user_login,
			'iat'  => $iat,
			'exp'  => $exp,
		)
	);

	// Encode Header.
	$base64_url_header = mo_api_authentication_base64_url_encode( $header );

	// Encode Payload.
	$base64_url_payload = mo_api_authentication_base64_url_encode( $payload );

	// Create Signature Hash.
	$signature = hash_hmac( 'sha256', $base64_url_header . '.' . $base64_url_payload, $client_secret, true );

	// Encode Signature to Base64Url String.
	$base64_url_signature = mo_api_authentication_base64_url_encode( $signature );

	// Create JWT.
	$jwt = $base64_url_header . '.' . $base64_url_payload . '.' . $base64_url_signature;

	$token_data = array(
		'token_type' => 'Bearer',
		'iat'        => $iat,
		'expires_in' => $exp,
		'jwt_token'  => $jwt,
	);

	return $token_data;

}

/**
 * Convert string to base64 encoded string.
 *
 * @param mixed $text text to be encoded.
 * @return string
 */
function mo_api_authentication_base64_url_encode( $text ) {
	return rtrim( strtr( base64_encode( $text ), '+/', '-_' ), '=' ); //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- base64 encoding will be required to handle JWT token verification.
}

/**
 * Restrict REST API for invalid users.
 */
function mo_api_auth_restrict_rest_api_for_invalid_users() {

	if ( is_user_logged_in() && empty( isset( $_GET['mo_rest_api_test_config'] ) ? sanitize_text_field( wp_unslash( $_GET['mo_rest_api_test_config'] ) ) : '' ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation as we are fetching data from URL and not form submission
		return true;
	}

	if ( get_option( 'mo_api_authentication_protectedrestapi_route_whitelist' ) && Miniorange_API_Authentication_Admin::whitelist_routes( true ) === true ) {
		return true;
	}
	Miniorange_API_Authentication_Admin::mo_api_auth_else();

}


/**
 * Check if valid request.
 *
 * @return bool
 */
function mo_api_auth_is_valid_request() {
	$response = '';
	$headers  = mo_api_auth_getallheaders();
	$headers  = array_change_key_case( $headers, CASE_UPPER );

	$url_and_params = ! empty( $_SERVER['REQUEST_URI'] ) ? explode( '?', sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 2 ) : array( '', '' );
	if ( get_option( 'permalink_structure' ) === '' && isset( $url_and_params[1] ) ) {
		$url_and_params[0] = $url_and_params[1];
	}
	if ( stripos( $url_and_params[0], '/wp/v2' ) === false ) {
		if ( get_option( 'mo_rest_api_protect_migrate' ) ) {
			$response = array(
				'status'            => 'error',
				'error'             => 'Restricted',
				'error_description' => 'Sorry, you are not allowed to access REST API.',
				'error_reason'      => 'With the free plan, only WordPress default endpoints can be authenticated. You can upgrade to the suitable premium plan to securely access the custom built or 3rd-party plugin endpoint.',
			);
			wp_send_json( $response, 403 );
		}
		return true;
	}

	if ( ! empty( $_GET['mo_rest_api_test_config'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation as we are fetching data from URL and not form submission
		if ( sanitize_text_field( wp_unslash( $_GET['mo_rest_api_test_config'] ) ) === 'basic_auth' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation as we are fetching data from URL and not form submission
			$response = Mo_API_Authentication_Basic_OAuth::mo_api_auth_is_valid_request( $headers );
		} elseif ( sanitize_text_field( wp_unslash( $_GET['mo_rest_api_test_config'] ) ) === 'tokenapi' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation as we are fetching data from URL and not form submission
			$response = Mo_API_Authentication_TokenAPI::mo_api_auth_is_valid_request( $headers );
		} elseif ( sanitize_text_field( wp_unslash( $_GET['mo_rest_api_test_config'] ) ) === 'jwt_auth' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation as we are fetching data from URL and not form submission
			$response = Mo_API_Authentication_JWT_Auth::mo_api_auth_is_valid_request( $headers );
		}
	} else {
		if ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'basic_auth' ) {
			$response = Mo_API_Authentication_Basic_OAuth::mo_api_auth_is_valid_request( $headers );
		} elseif ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'tokenapi' ) {
			$response = Mo_API_Authentication_TokenAPI::mo_api_auth_is_valid_request( $headers );
		} elseif ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'jwt_auth' ) {
			$response = Mo_API_Authentication_JWT_Auth::mo_api_auth_is_valid_request( $headers );
		}
	}

	return $response;
}

if ( ! function_exists( 'mo_api_auth_getallheaders' ) ) {
	/**
	 * Get API request headers.
	 *
	 * @return array
	 */
	function mo_api_auth_getallheaders() {
		$headers = array();
		$server  = array_map( 'sanitize_text_field', $_SERVER );
		foreach ( $server as $name => $value ) {
			if ( substr( $name, 0, 5 ) === 'HTTP_' ) {
				$headers[ str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) ) ] = $value;
			}
		}
		return $headers;
	}
}
