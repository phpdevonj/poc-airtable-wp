<?php
/**
 * Plugin's helpers.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT\Helpers;

use WPC_WPCF7_AT\Options;
use WPC_WPCF7_AT\WPCF7_Field_Mapper;

defined( 'ABSPATH' ) || exit;

/**
 * Process the Airtable /account response.
 *
 * @param bool|\WP_Error $response A WP_Error if any.
 * @return void
 */
function process_airtable_test_request_response( $response ) {
	if ( is_wp_error( $response ) ) {
		Options\update_plugin_option(
			'airtable_api_error',
			array(
				'code'    => $response->get_error_code(),
				'message' => $response->get_error_message(),
			)
		);
		Options\delete_plugin_option( 'airtable_api_key_is_valid' );
	} else {
		Options\update_plugin_option( 'airtable_api_key_is_valid', time() );
		Options\delete_plugin_option( 'airtable_api_error' );
	}
}

/**
 * Retrieve a list of Airtable bases along with their respective tables.
 *
 *
 * @param bool $include_tables Whether to include the tables for each base in the result.
 * @param bool $bypass_cache   Whether to bypass the cached version and fetch the bases directly.
 * 
 * @return array An associative array where the key is the base ID and the value is an array with base details. 
 *
 */
function get_airtable_bases($include_tables = true, $bypass_cache = false ) {
    $transient_name = sprintf( '%1$sbases', WPCONNECT_WPCF7_AT_OPTIONS_PREFIX );
    
    $bases = get_transient( $transient_name );
    
    if ( $bases === false || $bypass_cache ) {
        $client = wpconnect_wpcf7_airtable_get_api_client();
        $bases  = [];
        try {
            $result = $client->list_bases();
            if( $result && isset( $result->bases ) ){
                foreach ( $result->bases as $base ) {
                    $bases[$base->id] = (array) $base;
                    if( $include_tables ) $bases[$base->id]['tables'] = get_airtable_tables_token($base->id);
                }
				set_transient( $transient_name, $bases, 15 * MINUTE_IN_SECONDS );
            }
        } catch (\Throwable $exception ) {
            error_log( $exception->getMessage() );
			set_transient( $transient_name, [], MINUTE_IN_SECONDS );
        }
    }
    return $bases;
}


/**
 * Get a cached version of Airtable table.
 *
 * @param string  $app_id The app id.
 * @param string  $table_id The table id.
 * @param boolean $bypass_cache Bypass API cache.
 * @param boolean $return_wp_error Whether to return a WP_Error Object or not if the request failed.
 * @return array
 */
function get_airtable_table( $app_id, $table_id, $bypass_cache = false, $return_wp_error = false ) {
	$transient_name = sprintf( '%1$sairtable_table%2$s', WPCONNECT_WPCF7_AT_OPTIONS_PREFIX, $table_id );
	$result         = get_transient( $transient_name );

	if ( false === $result || $bypass_cache ) {
		$api    = wpconnect_wpcf7_airtable_get_api( $app_id );
		$result = $api->get_table( $table_id );

		if ( ! is_wp_error( $result ) ) {
			set_transient( $transient_name, $result, 1 * MINUTE_IN_SECONDS );
		} elseif ( $return_wp_error ) {
			return $result;
		}
	}

	return $result;
}
/**
 * Get a cached version of Airtable tables columns.
 *
 * @param string  $app_id The Airtable app id.
 * @param string  $table_id The Airtable table id.
 * @param boolean $bypass_cache Bypass API cache.
 * @return array  Returns an associative array of columns (fields) where each
 *                field name is the key. Each value is an array that contains
 *                the name of the field.
 */
function get_airtable_table_columns( $app_id, $table_id, $bypass_cache = false ) {
	$table = get_airtable_table( $app_id, $table_id, $bypass_cache );

	$columns = array();
	if ( ! is_wp_error( $table ) ) {
		$columns = array_reduce(
			$table->records,
			function ( $result, $column ) {
				foreach ( $column->fields as $column_name => $value ) {
					if ( ! isset( $result[ $column_name ] ) ) {
						$result[ $column_name ] = array(
							'name' => $column_name,
						);
					}
				}

				return $result;
			},
			array()
		);
	}

	return $columns;
}

/**
 * Get fields from a specific Airtable table.
 *
 * @param string  $base_id   The app id.
 * @param string  $table_id  The table id.
 * @return array|null        Returns fields of the table or null if an error occurs.
 */
function get_airtable_fields($base_id, $table_id) {
    $table_data = get_airtable_tables_token($base_id, $table_id);
    
    // Vérifiez si la valeur retournée est une erreur WP_Error
    if (is_wp_error($table_data)) {
        return null;
    }

    if (isset($table_data['fields'])) {
        return $table_data['fields'];
    }

    return null;
}

/**
 * Returns Airtable table data for a given base with token
 * 
 * @param   string  $base_id
 * @return  array   $tables
 */
function get_airtable_tables_token( $base_id ){
	$tables = [];
	$client =wpconnect_wpcf7_airtable_get_api_client();
	try {
		$result = $client->get_tables( $base_id );
		if( $result && isset( $result->tables ) ){
			foreach ( $result->tables as $table ) {
				$table->fields = ! empty( $table->fields ) ? array_combine( wp_list_pluck( $table->fields, 'id' ), array_map( function( $field ){ return (array) $field; }, $table->fields ) ) : [];
				$table->views  = ! empty( $table->views ) ? array_combine( wp_list_pluck( $table->views, 'id' ), array_map( function( $view ){ return (array) $view; }, $table->views ) ) : [];
				$tables[$table->id] = (array) $table;
			} 
		}
	} catch (\Throwable $exception ) {
		error_log( $exception->getMessage() );
	}
	return $tables;
}

/**
 * Retrieve tables from Airtable for a specific base with token
 *
 * @param string $base_id The ID of the Airtable base.
 *
 * @return array An array of tables from Airtable for the specified base.
 */
function get_airtable_tables_for_base($base_id) {
    $base_id = sanitize_text_field($base_id);
    return get_airtable_tables_token($base_id);
}

/**
 * Generate a dropdown select box with Airtable fields for a specific table in a base with token
 *
 * This function takes in a base ID and a table ID and generates a select dropdown
 * of fields from that table. This can be useful for mapping fields between
 * a WordPress form and an Airtable table.
 *
 * @param string $base_id            The ID of the Airtable base.
 * @param string $table_id           The ID of the table within the specified Airtable base.
 * @param string $tag_name           The name of the CF7 tag being mapped.
 * @param array  $mappings_selected  Previously selected mappings for the CF7 form.
 *
 * @return string HTML string of the select dropdown.
 */
function generate_airtable_fields_select($base_id, $table_id, $tag_name, $mappings_selected) {
    $tables = get_airtable_tables_for_base($base_id);
    if (!isset($tables[$table_id]['fields'])) {
        return '';
    }
    $fields = $tables[$table_id]['fields'];

    $mapping = isset($mappings_selected[$tag_name]) ? $mappings_selected[$tag_name] : '';

    $output = '<select class="airtable-field-select" name="wpc-wpcf7-airtable[mapping][' . esc_attr($tag_name) . ']">';
    $default_text = __('Select a field', 'add-on-cf7-for-airtable');
    $output .= sprintf('<option value=""%s>%s</option>', $mapping == '' ? ' selected' : '', esc_html($default_text));

	foreach ($fields as $field_id => $field_data) {
		$selected = $field_data['name'] == $mapping ? ' selected' : '';
		$output .= sprintf('<option value="%s"%s>%s</option>', esc_attr($field_data['name']), $selected, esc_html($field_data['name']));
	}

    $output .= '</select>';
    return $output;
}

/**
 * Retrieve columns (fields) of a specific table from a given Airtable base with token.
 *
 * @param string $base_id   The ID of the Airtable base.
 * @param string $table_id  The ID of the table within the specified Airtable base.
 * @return array
 */
function get_airtable_table_columns_token( $base_id, $table_id ) {
    $tables = get_airtable_tables_token( $base_id );

    $table = null;
    foreach ($tables as $t) {
        if ($t['id'] == $table_id) {
            $table = $t;
            break;
        }
    }

    $columns = array();
    if ($table && isset($table['fields'])) {
        $columns = array_reduce(
            $table['fields'], 
            function ( $result, $column ) {
                $column_name = $column['name'];
                if ( ! isset( $result[ $column_name ] ) ) {
                    $result[ $column_name ] = array(
                        'name' => $column_name,
                    );
                }
                return $result;
            },
            array()
        );
    }
    return $columns;
}

/**
 * Returns mapped Airtable's fields name for each Contact Form 7 tags with a `airtable` property based on an Airtable table column list.
 *
 * @param WPCF7_ContactForm $contact_form A WPCF7_ContactForm instance.
 * @return array
 */
function get_mapped_tags_from_contact_form( $contact_form ) {
	$prop        = wp_parse_args(
		$contact_form->prop( 'wpc_airtable' ),
		array(
			'enabled'         => true,
			'app_id_selected' => '',
			'table_selected'  => '',
			'mapping'         => array(),
			'map_types'       => array(),
		)
	);
	$mapped_tags = array();
	if ( ! empty( $prop['app_id_selected'] ) && ! empty( $prop['table_selected'] ) ) {
		$mapping   = $prop['mapping'];
		$map_types = $prop['map_types'];

		foreach ( $contact_form->scan_form_tags() as $tag ) {
			// The field is not mapped.
			if ( ! isset( $mapping[ $tag->name ] ) || empty( $mapping[ $tag->name ] ) ) {
				continue;
			}
			$column_name           = $mapping[ $tag->name ];
			$column_type           = $map_types[ $tag->name ] ?? '';
			$column_type_was_empty = ! isset( $map_types[ $tag->name ] );

			// if we don't know the type, try best match from CF7 field type.
			if ( empty( $column_type ) ) {
				$has_multiple_values = tag_has_multiple_value( $tag );
				$types               = WPCF7_Field_Mapper::get_instance()->get_field_compatible_airtable_types( $tag->basetype, $has_multiple_values );
				$type                = array_pop( $types );
				$column_type         = $type;
			}

			$mapped_tags[ $tag->name ] = array(
				'type'                  => $tag->basetype,
				'content'               => $tag->content,
				'airtable_field_name'   => $column_name,
				'airtable_field_type'   => $column_type,
				'column_type_was_empty' => $column_type_was_empty,
			);
		}
	}
	return $mapped_tags;
}

/**
 * Check if a tag expect multiple values.
 *
 * @param WPCF7_FormTag $tag WPCF7 form tag.
 * @return bool
 */
function tag_has_multiple_value( $tag ) {
	return ( 'select' === $tag->basetype && in_array( 'multiple', $tag->options, true ) );
}

/**
 * Display a tooltip.
 *
 * @param string $text Tooltip text, HTML tags allowed: a and br.
 */
function tooltip( $text ) {
	printf(
		'<span class="wpc-wpcf7-airtable-tooltip dashicons dashicons-editor-help"><span class="wpc-wpcf7-airtable-tooltiptext">%s</span></span>',
		wp_kses(
			$text,
			array(
				'a'  => array(
					'href'   => true,
					'target' => true,
				),
				'br' => array(),
			)
		)
	);
}
