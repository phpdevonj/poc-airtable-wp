<?php
/**
 * Plugin Name: CF7 to Airtable
 * Description: Send the entries of your Contact Form 7 forms to your Airtable databases.
 * Author: WP connect
 * Author URI: https://wpconnect.co/
 * Text Domain: add-on-cf7-for-airtable
 * Domain Path: /languages/
 * Version: 2.1.0
 * Requires at least: 5.7
 * Requires PHP: 7.0
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT;

defined( 'ABSPATH' ) || exit;

/**
 * Define plugin constants
 */
define( 'WPCONNECT_WPCF7_AT_VERSION', '2.1.0' );
define( 'WPCONNECT_WPCF7_AT_URL', plugin_dir_url( __FILE__ ) );
define( 'WPCONNECT_WPCF7_AT_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPCONNECT_WPCF7_AT_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );
define( 'WPCONNECT_WPCF7_AT_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPCONNECT_WPCF7_AT_OPTIONS_PREFIX', 'wpcwpcf7at_' );


/**
 * Check for requirements and (maybe) load the plugin vital files.
 *
 * @return void
 */
function init() {
	// Bail early if requirements are not met.
	if ( ! meets_requirements() && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\notice_for_missing_requirements' );
		return;
	}

	// Register vital files.
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/functions.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/helpers.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/options.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/classes/_class-api-airtable.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/classes/class-airtable-api-client.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/classes/class-wpcf7-airtable-service.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/classes/class-wpcf7-field-mapper.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/contact-form-properties.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/fields.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/entry.php';
	require_once WPCONNECT_WPCF7_AT_DIR . '/includes/hooks.php';
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\init' );

/**
 * Does this WP install meet minimum requirements?
 *
 * @return boolean
 */
function meets_requirements() {
	global $wp_version;

	return (
		version_compare( PHP_VERSION, '7.0', '>=' ) &&
		version_compare( $wp_version, '5.5', '>=' ) &&
		defined( 'WPCF7_VERSION' ) &&
		version_compare( WPCF7_VERSION, '5.5.3', '>=' )
	);
}

/**
 * Display a notice if requirements are not met.
 *
 * @return void
 */
function notice_for_missing_requirements() {
	echo wp_kses(
		sprintf(
			'<div class="notice notice-error"><p>%1$s</p></div>',
			__( 'The "Contact Form 7 to Airtable" plugin is inactive because the minimal requirements are not met.', 'add-on-cf7-for-airtable' )
		),
		array(
			'div' => array( 'class' => array() ),
			'p'   => array(),
		)
	);
}

/**
 * Trigger a custom action when activating the plugin.
 *
 * @param string  $plugin The plugin's slug.
 * @param boolean $network Network activation.
 * @return void
 */
function on_plugin_activation( $plugin, $network ) {
	if ( WPCONNECT_WPCF7_AT_BASENAME !== $plugin ) {
		return;
	}

	init();
	do_action( 'add-on-cf7-for-airtable/plugin-activated', (bool) $network );
}
add_action( 'activate_plugin', __NAMESPACE__ . '\\on_plugin_activation', 10, 2 );

/**
 * Translations.
 *
 * @return void
 */
function load_translations() {
	load_plugin_textdomain( 'add-on-cf7-for-airtable', false, WPCONNECT_WPCF7_AT_PLUGIN_DIRNAME . '/languages/' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_translations' );

/**
 * Settings Link.
 *
 * @param array $links The array of plugin settings links.
 * @return array
 */
function add_settings_link( $links ) {
	$url             = add_query_arg( 'page', 'wpcf7-integration&service=wpc_airtable&action=setup', get_admin_url() . 'admin.php' );
	$settings_link[] = "<a href='" . esc_url( $url ) . "'>" . esc_html( __( 'Setup', 'add-on-cf7-for-airtable' ) ) . '</a>';
	$settings_link[] = "<a href='https://wordpress.org/support/plugin/add-on-cf7-for-airtable/reviews/#new-post' target='_blank'>" . esc_html( __( 'Leave a review', 'add-on-cf7-for-airtable' ) ) . '</a>';
	$links           = array_merge( $settings_link, $links );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), __NAMESPACE__ . '\\add_settings_link' );

/**
 * Register CSS.
 *
 * @return void
 */
function wpc_enqueue_custom_style() {
	$screens_ids = array(
		'contact_page_wpcf7-new',
		'toplevel_page_wpcf7',
	);

	if ( function_exists( 'wpconnect_wpcf7_airtable_get_notices_screens_id' ) ) {
		$screens_ids = array_merge( $screens_ids, wpconnect_wpcf7_airtable_get_notices_screens_id() );
	}

	if ( get_current_screen() && in_array( get_current_screen()->id, $screens_ids, true ) ) {
		wp_register_style( 'wpcf7-airtable-css', plugins_url( './assets/style/style.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_style( 'wpcf7-airtable-css' );
	}
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\wpc_enqueue_custom_style' );

/**
 * Register JS.
 *
 * @return void
 */
function wpc_enqueue_admin_scripts() {
    $script_path = plugins_url('./assets/js/admin.min.js', __FILE__);
    
    // Enqueue the JS file
    wp_enqueue_script('wpcf7-airtable-js', $script_path, array('jquery'), '1.0.0', true);

}
add_action('admin_enqueue_scripts',  __NAMESPACE__ . '\\wpc_enqueue_admin_scripts');