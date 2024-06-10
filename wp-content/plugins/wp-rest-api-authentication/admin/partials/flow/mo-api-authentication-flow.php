<?php
/**
 * Authentication flow
 * This file will saves the data for the Authentication method configured in the plugin.
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
 * Handle App settings.
 *
 * @return void
 */
function mo_api_authentication_config_app_settings() {
	if ( ! empty( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && current_user_can( 'administrator' ) ) {

		if ( ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_basic_authentication_config_form' ) && isset( $_REQUEST['mo_api_basic_authentication_method_config_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_basic_authentication_method_config_fields'] ) ), 'mo_api_basic_authentication_method_config' ) ) {
			update_option( 'mo_api_authentication_selected_authentication_method', 'basic_auth' );
			$mo_rest_api_ajax_method_data = get_option( 'mo_rest_api_ajax_method_data' );
			if ( $mo_rest_api_ajax_method_data ) {
				update_option( 'mo_api_authentication_authentication_key', $mo_rest_api_ajax_method_data['token_type'] );
			}
			delete_option( 'mo_rest_api_ajax_method_data' );
			update_option( 'mo_api_auth_message', 'Basic Authentication Method is configured successfully.' );
			update_option( 'mo_api_auth_message_flag', 1 );
		}

		if ( ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_jwt_authentication_config_form' ) && isset( $_REQUEST['mo_api_jwt_authentication_method_config_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_jwt_authentication_method_config_fields'] ) ), 'mo_api_jwt_authentication_method_config' ) ) {

			update_option( 'mo_api_authentication_selected_authentication_method', 'jwt_auth' );
			if ( empty( get_option( 'mo_api_authentication_jwt_client_secret' ) ) ) {
				update_option( 'mo_api_authentication_jwt_client_secret', stripslashes( wp_generate_password( 32, false, false ) ) );
			}
			update_option( 'mo_api_authentication_jwt_signing_algorithm', 'HS256' );
			update_option( 'mo_api_auth_message', 'JWT Authentication Method is configured successfully.' );
			update_option( 'mo_api_auth_message_flag', 1 );
		}

		if ( ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_key_authentication_config_form' ) && isset( $_REQUEST['mo_api_key_authentication_method_config_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_key_authentication_method_config_fields'] ) ), 'mo_api_key_authentication_method_config' ) ) {

			if ( ! get_option( 'mo_api_authentication_selected_authentication_method' ) || get_option( 'mo_api_authentication_selected_authentication_method' ) !== 'tokenapi' ) {
				update_option( 'mo_api_auth_message', 'This method is not available with your current plan. Please upgrade to use this authentication method' );
				update_option( 'mo_api_auth_message_flag', 2 );
				return;
			}

			update_option( 'mo_api_authentication_selected_authentication_method', 'tokenapi' );
			if ( get_option( 'mo_api_auth_bearer_token' ) === false ) {
				$bearer_token = stripslashes( wp_generate_password( 32, false, false ) );
				update_option( 'mo_api_auth_bearer_token', $bearer_token );
			}
			update_option( 'mo_api_auth_message', 'API Key Authentication Method is configured successfully.' );
			update_option( 'mo_api_auth_message_flag', 1 );
		} elseif ( ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_protected_apis_form' ) && isset( $_REQUEST['ProtectedRestAPI_admin_nonce_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['ProtectedRestAPI_admin_nonce_fields'] ) ), 'ProtectedRestAPI_admin_nonce' ) ) {
			// Catch the routes that should be whitelisted.
			$rest_routes = ( isset( $_POST['rest_routes'] ) ) ? array_map( 'esc_html', wp_unslash( $_POST['rest_routes'] ) ) : null; //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Not sanitizing the data as it will remove the brackets present in the regular expression of REST API endpoint.
			// If resetting or whitelist is empty, clear the option and exit the function.
			if ( empty( $rest_routes ) || isset( $_POST['reset'] ) ) {
				mo_api_authentication_reset_api_protection();
				add_settings_error( 'ProtectedRestAPI_notices', 'settings_updated', 'All APIs below are protected.', 'updated' );
				update_option( 'mo_api_auth_message', 'Your Settings for Protected REST APIs have been reset successfully' );
				update_option( 'mo_api_auth_message_flag', 1 );
				return;
			}

			// Save whitelist to the Options table.

			update_option( 'mo_api_authentication_protectedrestapi_route_whitelist', $rest_routes );
			add_settings_error( 'ProtectedRestAPI_notices', 'settings_updated', 'Whitelist settings saved.', 'updated' );
			update_option( 'mo_api_auth_message', 'Your Settings for Protected REST APIs have been saved successfully' );
			update_option( 'mo_api_auth_message_flag', 1 );

		} elseif ( ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_postman_file' ) && isset( $_REQUEST['mo_api_authentication_postman_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_postman_fields'] ) ), 'mo_api_authentication_postman_config' ) ) {
			$method = isset( $_POST['file_name'] ) ? sanitize_text_field( wp_unslash( $_POST['file_name'] ) ) : '';
			if ( '' !== $method ) {
				mo_api_authentication_postman_download( $method );
			} else {
				update_option( 'mo_api_auth_message', 'Something went wrong!! Please select any of the "Token" or "Resource" option and try again.' );
				update_option( 'mo_api_auth_message_flag', 2 );
				return;
			}
		}
	}
}

/**
 * Reset Protected APIs.
 *
 * @return void
 */
function mo_api_authentication_reset_api_protection() {
	$wp_rest_server = rest_get_server();
	$all_routes     = array_keys( $wp_rest_server->get_routes() );
	$all_routes     = array_map( 'esc_html', $all_routes );

	foreach ( $all_routes as $key => $value ) {
		if ( '/api/v1/token' === $value ) {
			array_splice( $all_routes, $key, 1 );
		}
	}
	foreach ( $all_routes as $key => $value ) {
		if ( '/api/v1/token-validate' === $value ) {
			array_splice( $all_routes, $key, 1 );
		}
	}

	update_option( 'mo_api_authentication_protectedrestapi_route_whitelist', $all_routes );
}

/**
 * Create client id and secret for JWT authentication method.
 *
 * @return void
 */
function mo_api_authentication_create_client() {
	$client_id = stripslashes( wp_generate_password( 12, false, false ) );
	update_option( 'mo_api_auth_clientid ', $client_id );
	$client_secret = stripslashes( wp_generate_password( 24, false, false ) );
	update_option( 'mo_api_auth_clientsecret', $client_secret );
}

/**
 * Reset settings.
 *
 * @return void
 */
function mo_api_authentication_reset_settings() {
	delete_option( 'mo_api_authentication_selected_authentication_method' );
	delete_option( 'mo_api_authentication_config_settings_tokenapi' );
	delete_option( 'mo_api_authentication_config_settings_basic_auth' );
	delete_option( 'mo_api_authentication_config_settings_jwt_auth' );
	delete_option( 'mo_api_auth_bearer_token ' );
	delete_option( 'mo_api_auth_clientid ' );
	delete_option( 'mo_api_auth_clientsecret' );
	delete_option( 'mo_api_authentication_authentication_key' );
	delete_option( 'mo_api_authentication_jwt_client_secret' );
	delete_option( 'mo_api_authentication_jwt_signing_algorithm' );
	update_option( 'mo_api_auth_message', 'Configuration reset successfully' );
}
/**
 * Export plugin config.
 *
 * @return array
 */
function mo_api_authentication_export_plugin_config() {
	$config                          = null;
	$config['Authentication_Method'] = get_option( 'mo_api_authentication_selected_authentication_method' );
	if ( 'tokenapi' === $config['Authentication_Method'] ) {
		$config['Authentication_Method'] = 'API Key';
	}
	return $config;
}

/**
 * Download Postman sample.
 *
 * @param mixed $method contains the authentication method.
 * @return void
 */
function mo_api_authentication_postman_download( $method ) {
	$all_files_url = array(
		'api-key'                  => 'https://developers.miniorange.com/static/postman/wp-rest-api-authentication/API_KEY_AUTHENTICATION_REQUEST.zip',
		'basic-username-password'  => 'https://developers.miniorange.com/static/postman/wp-rest-api-authentication/BASIC_AUTHENTICATION_USERNAME_PASSWORD.zip',
		'basic-client-credentials' => 'https://developers.miniorange.com/static/postman/wp-rest-api-authentication/BASIC_AUTHENTICATION_CLIENT_CREDENTIALS.zip',
		'jwt-token'                => 'https://developers.miniorange.com/static/postman/wp-rest-api-authentication/JWT_AUTHENITCATION_TOKEN_REQUEST.zip',
		'jwt-resource'             => 'https://developers.miniorange.com/static/postman/wp-rest-api-authentication/JWT_AUTHENTICATION_RESOURCE_REQUEST.zip',
	);

	// Create postman sample folder if not exist.
	$upload_dir = wp_upload_dir();
	if ( $upload_dir && isset( $upload_dir['basedir'] ) ) {
		$base_upload_dir       = $upload_dir['basedir'];
		$postman_sample_folder = $base_upload_dir . DIRECTORY_SEPARATOR . 'postman-sample';

		if ( ! file_exists( $postman_sample_folder ) && ! is_dir( $postman_sample_folder ) ) {
			wp_mkdir_p( $postman_sample_folder );
		}
	}

	$filepath = $postman_sample_folder . DIRECTORY_SEPARATOR . $method . '.zip';

	if ( ! file_exists( $filepath ) ) {
		// Download file.
		$tmp_file = download_url( $all_files_url[ $method ], 500000, false );
		// Copies the file to the final destination and deletes temporary file.
		copy( $tmp_file, $filepath );
		unlink( $tmp_file );
	}

	$zip = new ZipArchive();
	$zip->open( $filepath );
	$contents = '';
	$filename = '';
	for ( $i = 0; $i < $zip->numFiles; $i++ ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- Ignoring camel case here because the ZIP library has it's variables in camel case.
		$stat     = $zip->statIndex( $i );
		$filename = basename( $stat['name'] );
		$fp       = $zip->getStream( $filename );
		while ( ! feof( $fp ) ) {
			$contents .= fread( $fp, 2 ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fread -- Using deafult WordPress function to read local file.
		}
	}

	$jsonfile = plugin_dir_path( __FILE__ );
	$jsonfile = rtrim( $jsonfile, '/' );
	$jsonfile = $jsonfile . '\\mo_temp_json_file.json';
	file_put_contents( $jsonfile, $contents ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents -- Using file put contents to fetch local file.

	header( 'Content-Disposition: attachment; filename =' . $filename );
	header( 'Content-Type: application/json' );
	ob_clean();
	readfile( $jsonfile ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_readfile -- Using default WordPress function to read local file.
	unlink( $jsonfile );
	exit();
}
