<?php
/**
 * Save WPCF7 contact form entries to Airtable table.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT\Entry;

use WPC_WPCF7_AT\WPCF7_Field_Mapper;
use WPC_WPCF7_AT\WPCF7_Airtable_Service;
use WPC_WPCF7_AT\Helpers;
use WPC_WPCF7_AT\Airtable_API_Client;

defined( 'ABSPATH' ) || exit;

/**
 * Saves contact form submission to Airtable table
 *
 * @param WPCF7_ContactForm $contact_form A WPCF7_ContactForm instance.
 * @param bool              $abort Set to true if the form submission should be aborted.
 * @param WPCF7_Submission  $submission A WPCF7_Submission instance.
 * @return void
 */
function save_wpcf7_entry_in_airtable_table( $contact_form, &$abort, $submission ) {
	$service = WPCF7_Airtable_Service::get_instance();
	if ( ! $service->is_active() ) {
		return;
	}
	if ( $contact_form->in_demo_mode() ) {
		return;
	}

	$consented            = true;
	$optional_consent_tag = false;
	foreach ( $contact_form->scan_form_tags( 'feature=name-attr' ) as $tag ) {
		if ( $tag->has_option( 'consent_for:airtable' ) ) {
			if ( $tag->has_option( 'optional' ) ) {
				$optional_consent_tag = $tag;
			}
			if ( null === $submission->get_posted_data( $tag->name ) ) {
				$consented = false;
			}
			break;
		}
	}

	if ( ! $consented ) {
		return;
	}

	$prop = wp_parse_args(
		$contact_form->prop( 'wpc_airtable' ),
		array(
			'enabled'         => true,
			'app_id_selected' => '',
			'table_selected'  => '',
			'mapping'         => array(),
			'map_types'       => array(),
		)
	);

	if ( ! $prop['enabled'] || empty( $prop['app_id_selected'] ) || empty( $prop['table_selected'] ) ) {
		return;
	}

	$table_id = $prop['table_selected'];

	$data            = (array) $submission->get_posted_data();
	$files           = $submission->uploaded_files();
	$airtable_fields = array();
	$field_mapper    = WPCF7_Field_Mapper::get_instance();
	$mapped_tags     = Helpers\get_mapped_tags_from_contact_form( $contact_form );

	foreach ( $mapped_tags as $wpcf7_field_name => $field ) {
		$column_name          = $field['airtable_field_name'];
		$original_field_value = $data[ $wpcf7_field_name ];
		// Change value for special fields.
		if ( 'acceptance' === $field['type'] ) {
			$original_field_value = $original_field_value ? $field['content'] : __( 'No', 'add-on-cf7-for-airtable' );
		} elseif ( 'file' === $field['type'] ) {
			if ( ! isset( $files[ $wpcf7_field_name ] ) ) {
				$original_field_value = array();
			} else {
				$original_field_value = $files[ $wpcf7_field_name ];
			}
		}
		$field_value = $field_mapper->get_formatted_field_value( $field['type'], $field['airtable_field_type'], $original_field_value );
		if ( null !== $field_value ) {
			$airtable_fields[ $column_name ] = $field_value;
		}
	}


	$app_id = $prop['app_id_selected'];	
	$service = WPCF7_Airtable_Service::get_instance();
	$api_key = $service->get_api_key();
	$api_client = new Airtable_API_Client($api_key);
	$records = array( array( 'fields' => $airtable_fields ) );
	$response   = $api_client->create_records( $app_id, $table_id, $records );

	if (is_wp_error($response) || $response->error) {

		$error_message = $response->message;

		// Display error
    	$submission_response = __("Due to an error, your message could not be sent. Please try again later.", 'add-on-cf7-for-airtable');

		// If there is an optional consent tag, let the user know he can uncheck it.
		if ( $optional_consent_tag ) {
			/* translators: %s: consent checkbox text */
			$submission_response= sprintf( __("Due to an error, your message could not be sent. Please try again later or uncheck.", 'add-on-cf7-for-airtable'), $optional_consent_tag->content);
		}
    	$submission->set_response($submission_response);

		// Send email to administrator
		$admin_email = get_option('admin_email');
        $subject = __('Error during Contact Form 7 submission', 'add-on-cf7-for-airtable');
        $message = __("An error occurred while saving the submission to Airtable.", 'add-on-cf7-for-airtable') . "\n\n";
        /* translators: %s: error message */
		$message .= sprintf(__("Error message: %s", 'add-on-cf7-for-airtable'), $error_message) . "\n";
		wp_mail($admin_email, $subject, $message);	
    	
		
		$abort = true;
    	return;
	}

	do_action( 'add-on-cf7-for-airtable/after-airtable-save' );
}

/**
 * Delete files uploaded ($filepaths) in `wpc_wpcf7_airtable_uploads` folder.
 *
 * @param string[] $filepaths File paths to be deleted.
 * @return void
 */
function delete_uploads( $filepaths ) {
	$upload_dir           = wp_upload_dir();
	$wpc_airtable_dirname = $upload_dir['basedir'] . '/wpc_wpcf7_airtable_uploads';
	foreach ( $filepaths as $filepath ) {
		$filepath = realpath( $filepath );
		if ( $filepath && strpos( $filepath, $wpc_airtable_dirname ) === 0 && is_file( $filepath ) ) {
			unlink( $filepath );
		}
	}
}
