<?php
/**
 * Plugin Name: Air WP Sync - Airtable to WordPress
 * Plugin URI: https://wpconnect.co/air-wp-sync-plugin/
 * Description: Swiftly sync Airtable to your WordPress website!
 * Version: 2.1.0
 * Requires at least: 5.7
 * Tested up to: 6.4
 * Requires PHP: 7.0
 * Author: WP connect
 * Author URI: https://wpconnect.co/
 * License: GPLv2 or later License
 * Text Domain: air-wp-sync
 * Domain Path: /languages/
 */

namespace Air_WP_Sync_Free;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'AIR_WP_SYNC_VERSION', '2.1.0' );
define( 'AIR_WP_SYNC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AIR_WP_SYNC_PLUGIN_FILE', __FILE__ );
define( 'AIR_WP_SYNC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AIR_WP_SYNC_BASENAME', plugin_basename( __FILE__ ) );
define( 'AIR_WP_SYNC_LOGDIR', wp_upload_dir( null, false )['basedir'] . '/airwpsync-logs/' );

require_once AIR_WP_SYNC_PLUGIN_DIR . 'vendor/woocommerce/action-scheduler/action-scheduler.php';

require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-abstract-settings.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-abstract-module.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-abstract-importer.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-abstract-destination.php';


require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-parsedown.php';

require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-action-consumer.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-importer-settings.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-helper.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/class-air-wp-sync-admin.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-airtable-api-client.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/class-air-wp-sync-cli.php';

require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/class-air-wp-sync-post-module.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/user/class-air-wp-sync-user-module.php';

require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/formatters/class-air-wp-sync-attachments-formatter.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/formatters/class-air-wp-sync-markdown-formatter.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/formatters/class-air-wp-sync-terms-formatter.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/formatters/class-air-wp-sync-interval-formatter.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/sources/class-air-wp-sync-barcode-source.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/sources/class-air-wp-sync-collaborator-source.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/sources/class-air-wp-sync-link-to-another-record-source.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/sources/class-air-wp-sync-formula-source.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/sources/class-air-wp-sync-unsupported-source.php';

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\air_wp_sync_deactivate' );


if (!function_exists(__NAMESPACE__ . '\air_wp_sync_deactivate')) {
	/**
	 * The code that runs during plugin deactivation.
	 */
	function air_wp_sync_deactivate() {
		// flush rewrite rules
		flush_rewrite_rules();
		// Clear hooks
		foreach ( _get_cron_array() as $cron ) {
			foreach ( array_keys( $cron ) as $hook ) {
				if ( strpos( $hook, 'air_wp_sync_importer_' ) === 0 ) {
					wp_clear_scheduled_hook( $hook );
				}
			}
		}
	}
}
// Init plugin
new Air_WP_Sync();
