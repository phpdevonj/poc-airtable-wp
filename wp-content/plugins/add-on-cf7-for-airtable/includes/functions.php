<?php

/**
 * Global plugin's functions.
 * No namespace, these globally-available-functions are prefixed.
 *
 * @package add-on-cf7-for-airtable
 */

use WPC_WPCF7_AT\API_Airtable;
use WPC_WPCF7_AT\Airtable_API_Client;
use WPC_WPCF7_AT\Options;
use WPC_WPCF7_AT\WPCF7_Airtable_Service;

defined('ABSPATH') || exit;

/**
 * Get an instance of the Airtable API client.
 *
 * @param string $key
 * @return Airtable_API_Client
 */
function wpconnect_wpcf7_airtable_get_api_client($token = null)
{
	$service = WPCF7_Airtable_Service::get_instance();
	return new Airtable_API_Client(is_null($token) ? $service->get_api_key() : $token);
}

/**
 * Get an instance of the Airtable API.
 *
 * @param string $app_id Api key.
 * @param string $key Api key.
 * @return API_Airtable
 */
function wpconnect_wpcf7_airtable_get_api($app_id, $key = null)
{
	$service = WPCF7_Airtable_Service::get_instance();

	return new API_Airtable(
		is_null($key) ? $service->get_api_key() : $key,
		$app_id
	);
}

/**
 * Is the API Key valid?
 *
 * @return boolean
 */
function wpconnect_wpcf7_airtable_api_key_is_valid()
{
	return Options\get_plugin_option('airtable_api_key_is_valid') > 0;
}

/**
 * Register WPCF7 Airtable service
 *
 * @return void
 */
function wpconnect_wpcf7_airtable_register_service()
{
	$integration = WPCF7_Integration::get_instance();

	$integration->add_service(
		'wpc_airtable',
		WPCF7_Airtable_Service::get_instance()
	);
}

/**
 * Save plugin version
 *
 * @return void
 */
function wpconnect_wpcf7_airtable_save_plugin_version()
{
	Options\update_plugin_option('version', WPCONNECT_WPCF7_AT_VERSION);
}

/**
 * Returns a list of screens id where we can show the add-on notice.
 *
 * @return string[]
 */
function wpconnect_wpcf7_airtable_get_notices_screens_id()
{
	return array(
		'contact_page_wpcf7-integration',
		'contact_page_wpcf7-new',
		'toplevel_page_wpcf7',
	);
}

/**
 * Show admin notice
 *
 * @return void
 */
function wpconnect_wpcf7_airtable_admin_notice__info()
{
	$allowed_pages_notices = wpconnect_wpcf7_airtable_get_notices_screens_id();
	if (!get_user_meta(get_current_user_id(), 'cf7_airtable_addon_notice_dismissed') && in_array(get_current_screen()->id, $allowed_pages_notices, true)) {
		$dismiss_url = wp_nonce_url(
			add_query_arg(
				'cf7_airtable_addon-dismissed',
				'1',
				get_permalink(get_current_screen()->id)
			),
			'wpc-nonce'
		);
?>
		<div class="notice notice-info is-dismissible">
			<p style="margin-top:20px;"><b><?php echo esc_html(__('Thank you for downloading CF7 to Airtable Integration!', 'add-on-cf7-for-airtable')); ?></b></p>
			<p><?php echo esc_html(__('Love our plugin? ', 'add-on-cf7-for-airtable')); ?><a href="https://wordpress.org/support/plugin/add-on-cf7-for-airtable/reviews/#new-post" target="_blank"><?php echo esc_html(__('Please leave us a review!', 'add-on-cf7-for-airtable')); ?></a></p>
			<p style=" margin-bottom:20px;"><?php echo esc_html(__('Discover all our products at: ', 'add-on-cf7-for-airtable')); ?><a href="https://wpconnect.co" target="_blank">https://wpconnect.co</a></p>
			<a href="<?php echo esc_url($dismiss_url); ?>" style="color: #3c434a;" class="wpc-wpcf7-airtable-dismiss-link"><?php echo esc_html(__('Dismiss this notice', 'add-on-cf7-for-airtable')); ?></a>
		</div>
<?php
	}
}
add_action('admin_notices', 'wpconnect_wpcf7_airtable_admin_notice__info');

/**
 * Dismiss notice for user
 *
 * @return void
 */
function wpconnect_wpcf7_airtable_cf7_notice_dismissed()
{
	if (isset($_GET['cf7_airtable_addon-dismissed'])) {
		if (isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'wpc-nonce')) {
			add_user_meta(get_current_user_id(), 'cf7_airtable_addon_notice_dismissed', 'true', true);
		} else {
			die(esc_html(__('Nonce is invalid', 'add-on-cf7-for-airtable')));
		}
	}
}
add_action('admin_init', 'wpconnect_wpcf7_airtable_cf7_notice_dismissed');

