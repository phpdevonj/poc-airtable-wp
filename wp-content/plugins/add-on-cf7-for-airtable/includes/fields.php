<?php
/**
 * Functions to map and format WPCF7 fields to Airtable's ones.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT\Fields;

defined( 'ABSPATH' ) || exit;

// ************************************
// *** WPCF7 > Airtable field mapping ***
// ************************************

/**
 * Map WPCF7 text field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_text( $fields ) {
	$fields['text'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
	);
	return $fields;
}

/**
 * Map WPCF7 email field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_email( $fields ) {
	$fields['email'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'email'          => __NAMESPACE__ . '\airtable_email_format',
	);
	return $fields;
}

/**
 * Map WPCF7 url field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_url( $fields ) {
	$fields['url'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'url'            => __NAMESPACE__ . '\airtable_url_format',
	);
	return $fields;
}

/**
 * Map WPCF7 tel field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_tel( $fields ) {
	$fields['tel'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'phoneNumber'    => __NAMESPACE__ . '\airtable_phone_number_format',
	);
	return $fields;
}

/**
 * Map WPCF7 number field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_number( $fields ) {
	$fields['number'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'number'         => __NAMESPACE__ . '\airtable_number_format',
	);
	return $fields;
}

/**
 * Map WPCF7 range field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_range( $fields ) {
	$fields['range'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'number'         => __NAMESPACE__ . '\airtable_number_format',
	);
	return $fields;
}

/**
 * Map WPCF7 date field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_date( $fields ) {
	$fields['date'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'date'           => __NAMESPACE__ . '\airtable_date_format',
	);
	return $fields;
}

/**
 * Map WPCF7 textarea field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_textarea( $fields ) {
	$fields['textarea'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'longText'       => __NAMESPACE__ . '\airtable_single_line_text_format',
	);
	return $fields;
}

/**
 * Map WPCF7 select field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_select( $fields ) {
	$fields['select'] = array(
		'singleLineText'  => array(
			__NAMESPACE__ . '\flatten_values',
			__NAMESPACE__ . '\airtable_single_line_text_format',
		),
		'multipleSelects' => __NAMESPACE__ . '\airtable_multiple_selects_format',
		'singleSelect'    => array(
			__NAMESPACE__ . '\flatten_values',
			__NAMESPACE__ . '\airtable_single_line_text_format',
		),
	);
	return $fields;
}

/**
 * Map WPCF7 checkbox field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_checkbox( $fields ) {
	$fields['checkbox'] = array(
		'multipleSelects' => __NAMESPACE__ . '\airtable_multiple_selects_format',
		'singleLineText'  => array(
			__NAMESPACE__ . '\flatten_values',
			__NAMESPACE__ . '\airtable_single_line_text_format',
		),
		'checkbox'       => array(
			__NAMESPACE__ . '\airtable_return_true',
			__NAMESPACE__ . '\airtable_checkbox_format',
		),
	);
	return $fields;
}

/**
 * Map WPCF7 radio field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_radio( $fields ) {
	$fields['radio'] = array(
		'multipleSelects' => __NAMESPACE__ . '\airtable_multiple_selects_format',
		'singleLineText'  => array(
			__NAMESPACE__ . '\flatten_values',
			__NAMESPACE__ . '\airtable_single_line_text_format',
		),
	);
	return $fields;
}

/**
 * Map WPCF7 acceptance field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_acceptance( $fields ) {
	$fields['acceptance'] = array(
		'singleLineText' => __NAMESPACE__ . '\airtable_single_line_text_format',
		'checkbox'       => array(
			__NAMESPACE__ . '\airtable_yes_no_to_bool',
			__NAMESPACE__ . '\airtable_checkbox_format',
		),

	);
	return $fields;
}

/**
 * Map WPCF7 file field.
 *
 * @param array $fields The supported WPCF7/Airtable fields.
 * @return array
 */
function map_wpcf7_file( $fields ) {
	$fields['file'] = array(
		'multipleAttachments' => array(
			__NAMESPACE__ . '\save_files',
			__NAMESPACE__ . '\airtable_multiple_attachments_format',
		),
	);
	return $fields;
}


// ****************************
// *** WPCF7 pre-formatters ***
// ****************************

/**
 * Explodes string value and returns an array. Returns false for empty field value.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return null|string[]
 */
function explode_values_comma( $field_value ) {
	if ( empty( $field_value ) ) {
		return null;
	}
	$array_value = explode( ', ', $field_value );
	return $array_value;
}

/**
 * Converts an array into a string separated by semicolon.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return mixed|string
 */
function flatten_values( $field_value ) {
	if ( is_array( $field_value ) ) {
		$field_value = implode( ', ', $field_value );
	}

	return $field_value;
}

/**
 * Always return true.
 * (useful for gdpr field which is required, so it's always true)
 *
 * @param mixed $field_value The WPForms field value.
 * @return bool
 */
function airtable_return_true( $field_value ) {
	return true;
}

/**
 * Converts "No" to false, other values to true if the $field_value is a string.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return bool
 */
function airtable_yes_no_to_bool( $field_value ) {
	if ( ! is_string( $field_value ) ) {
		return $field_value;
	}
	return __( 'No', 'add-on-cf7-for-airtable' ) !== $field_value;
}


/**
 * Saves $filepaths to a public folder then return the URLs or null if the upload failed.
 * Delete the file once the form has been processed.
 *
 * @param string[] $filepaths The file paths saved by Contact Form 7.
 * @return null|string[]
 */
function save_files( $filepaths ) {
	if ( empty( $filepaths ) ) {
		return null;
	}
	$upload_dir           = wp_upload_dir();
	$wpc_airtable_dirname = $upload_dir['basedir'] . '/wpc_wpcf7_airtable_uploads';
	if ( ! is_dir( $wpc_airtable_dirname ) ) {
		if ( ! wp_mkdir_p( $wpc_airtable_dirname ) ) {
			return null;
		}
		$htaccess_file = path_join( $wpc_airtable_dirname, '.htaccess' );

		if ( ! file_exists( $htaccess_file ) ) {
			// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
			$handle = @fopen( $htaccess_file, 'w' );
			if ( $handle ) {
				// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
				fwrite( $handle, "Options -Indexes\n" );
				// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				fclose( $handle );
			}
		}
	}
	foreach ( $filepaths as $index => $filepath ) {
		$time_now        = time();
		$uuid            = wp_generate_uuid4();
		$unique_filename = wp_unique_filename( $wpc_airtable_dirname, $time_now . '-' . $uuid . '-' . wp_basename( $filepath ) );
		$new_filepath    = $wpc_airtable_dirname . '/' . $unique_filename;

		if ( ! copy( $filepath, $new_filepath ) ) {
			$filepaths[ $index ] = null;
		} else {
			$filepaths[ $index ] = $new_filepath;
		}
	}

	$filepaths = array_filter( $filepaths );
	add_action(
		'add-on-cf7-for-airtable/after-airtable-save',
		function () use ( $filepaths ) {
			wp_schedule_single_event( time() + MINUTE_IN_SECONDS, 'add-on-cf7-for-airtable/delete-upload-files', array( $filepaths ) );
		}
	);

	$fileurls = array_map(
		function ( $filepath ) {
			return str_replace( trailingslashit( ABSPATH ), trailingslashit( home_url() ), $filepath );
		},
		$filepaths
	);

	return $fileurls;
}


// **********************************
// *** Airtable's fields formatters ***
// **********************************

/**
 * Format a field value to an Airtable's text field format.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return string|null
 */
function airtable_single_line_text_format( $field_value ) {
	if ( empty( $field_value ) && '0' !== $field_value ) {
		return null;
	}
	return (string) $field_value;
}

/**
 * Format a field value to an Airtable's number field format.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return float|null object
 */
function airtable_number_format( $field_value ) {
	if ( '' === $field_value ) {
		return null;
	}
	return (float) $field_value;
}

/**
 * Format a field value to an Airtable's url field format.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return null|string
 */
function airtable_url_format( $field_value ) {
	if ( empty( $field_value ) ) {
		return null;
	}
	return (string) $field_value;
}

/**
 * Format a field value to an Airtable's email field format.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return null|string
 */
function airtable_email_format( $field_value ) {
	if ( empty( $field_value ) || strpos( $field_value, '@' ) === false ) {
		return null;
	}
	return (string) $field_value;
}

/**
 * Format a field value to an Airtable's phone_number field format.
 *
 * @param mixed $field_value The WPCF7 field value.
 * @return null|string
 */
function airtable_phone_number_format( $field_value ) {
	if ( empty( $field_value ) ) {
		return null;
	}
	return (string) $field_value;
}


/**
 * Format a field value to an Airtable's multi_select field format.
 *
 * @param mixed $array_value The WPCF7 field value.
 * @return null|array
 */
function airtable_multiple_selects_format( $array_value ) {
	if ( empty( $array_value ) ) {
		return null;
	}

	if ( is_string( $array_value ) ) {
		$array_value = array( $array_value );
	}

	// Remove empty values.
	$array_value = array_filter( $array_value );

	if ( empty( $array_value ) ) {
		return null;
	}

	return $array_value;
}

/**
 * Format a field value to an Airtable's date field format.
 *
 * @param \DateTimeInterface|bool $field_datetime_value The WPCF7 formatted field value.
 * @return null|object
 */
function airtable_date_format( $field_datetime_value ) {
	if ( ! preg_match( '`^\d{4}-\d{2}-\d{2}$`', $field_datetime_value ) ) {
		return null;
	}
	return (string) $field_datetime_value;
}

/**
 * Format a field value to an Airtable's checkbox field format.
 *
 * @param bool $field_value The WPCF7 formatted field value.
 * @return bool
 */
function airtable_checkbox_format( $field_value ) {
	return (bool) $field_value;
}

/**
 * Format a field value to an Airtable's multipleAttachments field format.
 *
 * @param bool $field_value The WPCF7 formatted field value.
 * @return null|array
 */
function airtable_multiple_attachments_format( $field_value ) {
	if ( empty( $field_value ) ) {
		return null;
	}

	return array_map(
		function ( $url ) {
			return array( 'url' => $url );
		},
		$field_value
	);
}
