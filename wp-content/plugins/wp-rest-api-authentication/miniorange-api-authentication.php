<?php
/**
 * Main plugin file.
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

/**
 * Plugin Name:       WordPress REST API Authentication
 * Plugin URI:        wp-rest-api-authentication
 * Description:       WordPress REST API Authentication secures rest API access for unauthorized users using OAuth 2.0, Basic Auth, JWT, API Key. Also reduces potential attack factors to the respective site.
 * Version:           3.1.0
 * Author:            miniOrange
 * Author URI:        https://www.miniorange.com
 * License:           MIT/Expat
 * License URI:       https://docs.miniorange.com/mit-license
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINIORANGE_API_AUTHENTICATION_VERSION', '3.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-miniorange-api-authentication-activator.php
 *
 * @return void
 */
function remove_footer_admin() {
	echo '';
}

if ( isset( $_GET['page'] ) && sanitize_text_field( wp_unslash( $_GET['page'] ) ) === 'mo_api_authentication_settings' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are getting data from URL and not form submission.
	add_filter( 'admin_footer_text', 'remove_footer_admin' );
}

/**
 * Activate plugin.
 *
 * @return void
 */
function mo_api_auth_activate_miniorange_api_authentication() {
	mo_rest_api_set_cron_job();
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-api-authentication-activator.php';
	Miniorange_Api_Authentication_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-miniorange-api-authentication-deactivator.php
 *
 * @return void
 */
function mo_api_auth_deactivate_miniorange_api_authentication() {
	wp_clear_scheduled_hook( 'mo_api_display_the_popup' );
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-api-authentication-deactivator.php';
	Miniorange_Api_Authentication_Deactivator::mo_api_authentication_deactivate();
}

add_action( 'admin_enqueue_scripts', 'mo_api_auth_plugin_settings_style' );
add_action( 'admin_init', 'mo_initialize_jwt_settings' );
register_activation_hook( __FILE__, 'mo_api_auth_activate_miniorange_api_authentication' );
register_deactivation_hook( __FILE__, 'mo_api_auth_deactivate_miniorange_api_authentication' );
remove_action( 'admin_notices', 'mo_api_auth_success_message' );
remove_action( 'admin_notices', 'mo_api_auth_error_message' );
add_action( 'admin_print_footer_scripts-plugins.php', 'mo_api_authentication_feedback_request' );
add_action( 'mo_api_display_the_popup', 'mo_rest_api_scheduled_task' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-api-authentication.php';

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @return void
 */
function mo_api_auth_plugin_settings_style() {
	wp_enqueue_style( 'mo_api_authentication_admin_settings_style', plugins_url( 'css/style_settings.min.css', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
	wp_enqueue_style( 'mo_api_authentication_admin_settings_phone_style', plugins_url( 'css/phone.min.css', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
	wp_enqueue_style( 'mo_api_authentication_admin_settings_fontAwesome_style', plugins_url( 'css/font-awesome.min.css', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
}

/**
 * Feedback request.
 *
 * @return void
 */
function mo_api_authentication_feedback_request() {
	Mo_API_Authentication_Feedback::mo_api_authentication_display_feedback_form();
}

/**
 * Run plugin.
 *
 * @return void
 */
function run_miniorange_api_authentication() {

	$plugin = new Miniorange_Api_Authentication();
	$plugin->run();

}
run_miniorange_api_authentication();

/**
 * Check if customer is registered.
 *
 * @return integer
 */
function mo_api_authentication_is_customer_registered() {
	$email        = get_option( 'mo_api_authentication_admin_email' );
	$customer_key = get_option( 'mo_api_authentication_admin_customer_key' );
	if ( ! $email || ! $customer_key || ! is_numeric( trim( $customer_key ) ) ) {

		return 0;
	} else {
		return 1;
	}
}

/**
 * Success message.
 *
 * @return void
 */
function mo_api_auth_success_message() {
	$class   = 'error';
	$message = get_option( 'mo_api_auth_message' );
	echo "<div class='" . esc_html( $class ) . "'> <p>" . esc_html( $message ) . '</p></div>';
}

/**
 * Error message.
 *
 * @return void
 */
function mo_api_auth_error_message() {
	$class   = 'updated';
	$message = get_option( 'mo_api_auth_message' );
	echo "<div class='" . esc_attr( $class ) . "'><p>" . esc_html( $message ) . '</p></div>';
}

/**
 * Show success message
 *
 * @return void
 */
function mo_api_auth_show_success_message() {
	remove_action( 'admin_notices', 'mo_api_auth_success_message' );
	add_action( 'admin_notices', 'mo_api_auth_error_message' );
}

/**
 * Show error message
 *
 * @return void
 */
function mo_api_auth_show_error_message() {
	remove_action( 'admin_notices', 'mo_api_auth_error_message' );
	add_action( 'admin_notices', 'mo_api_auth_success_message' );
}

/**
 * Set cron job.
 *
 * @return void
 */
function mo_rest_api_set_cron_job() {
	if ( ! wp_next_scheduled( 'mo_api_display_the_popup' ) ) {
		wp_schedule_event( time() + 60, 'daily', 'mo_api_display_the_popup' ); // update timestamp and name according to interval.
	}
}

/**
 * Handle scheduled task.
 *
 * @return void
 */
function mo_rest_api_scheduled_task() {
	update_option( 'mo_rest_api_show_popup', 1 );
}

/**
 * Initialize JWT settings.
 *
 * @return void
 */
function mo_initialize_jwt_settings() {
	if ( empty( get_option( 'mo_api_authentication_jwt_client_secret' ) ) && empty( get_option( 'mo_api_authentication_jwt_signing_algorithm' ) ) ) {
		update_option( 'mo_api_authentication_jwt_client_secret', stripslashes( wp_generate_password( 32, false, false ) ) );
		update_option( 'mo_api_authentication_jwt_signing_algorithm', 'HS256' );
	}
}
