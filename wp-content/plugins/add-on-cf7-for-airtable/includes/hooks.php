<?php
/**
 * Hooks used by the plugin.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT\Hooks;

use WPC_WPCF7_AT\Options;
use WPC_WPCF7_AT\Helpers;
use WPC_WPCF7_AT\CFP;

defined( 'ABSPATH' ) || exit;


// On plugin activation, keep the current plugin version in an option.
add_action( 'add-on-cf7-for-airtable/plugin-activated', 'wpconnect_wpcf7_airtable_save_plugin_version', 10, 1 );

// Register WPCF7 Airtable service.
add_action( 'wpcf7_init', 'wpconnect_wpcf7_airtable_register_service', 1, 0 );

// *******************************
// *** CONTACT FORM PROPERTIES ***
// *******************************

// Register the wpc_airtable contact form property.
add_filter( 'wpcf7_pre_construct_contact_form_properties', 'WPC_WPCF7_AT\CFP\register_property', 10, 1 );
// Build the editor panel for the wpc_airtable property.
add_filter( 'wpcf7_editor_panels', 'WPC_WPCF7_AT\CFP\editor_panels', 10, 1 );
// Save the wpc_airtable property value.
add_action( 'wpcf7_save_contact_form', 'WPC_WPCF7_AT\CFP\save_contact_form', 10, 1 );


// ***********************************
// *** CONTACT FORM FIELDS MAPPING ***
// ***********************************

add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_text' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_email' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_url' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_tel' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_number' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_range' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_textarea' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_select' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_checkbox' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_radio' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_acceptance' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_date' );
add_filter( 'add-on-cf7-for-airtable/wpcf7-field-mapper/fields', 'WPC_WPCF7_AT\Fields\map_wpcf7_file' );

// *******************************
// *** ENTRY ***
// *******************************

// Save contact form submission to Airtable table.
add_action( 'wpcf7_before_send_mail', 'WPC_WPCF7_AT\Entry\save_wpcf7_entry_in_airtable_table', 10, 3 );

// Delete files uploads after the form has been processed.
add_action( 'add-on-cf7-for-airtable/delete-upload-files', 'WPC_WPCF7_AT\Entry\delete_uploads', 10, 3 );

/**
 * AJAX callback function to fetch tables from Airtable for a specific base.
 *
 * Reads the base ID from the AJAX request, fetches the tables from Airtable,
 * and then returns them as a JSON response.
 *
 * Hooks:
 * 'wp_ajax_fetch_airtable_tables' - For logged in users.
 * 'wp_ajax_nopriv_fetch_airtable_tables' - For users not logged in.
 */
function fetch_airtable_tables_callback() {
    $base_id = sanitize_text_field($_POST['app_id']);
    $tables = Helpers\get_airtable_tables_token($base_id);
    echo json_encode($tables);
    wp_die();
}
add_action('wp_ajax_fetch_airtable_tables', 'WPC_WPCF7_AT\Hooks\fetch_airtable_tables_callback');
add_action('wp_ajax_nopriv_fetch_airtable_tables', 'WPC_WPCF7_AT\Hooks\fetch_airtable_tables_callback');