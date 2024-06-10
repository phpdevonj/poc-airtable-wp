<?php

namespace Air_WP_Sync_Free;

/**
 * Barcode Source
 */
class Air_WP_Sync_Link_To_Another_Record_Source {
	protected static $imported_fields_id = [];

	public function __construct() {
		add_filter( 'airwpsync/get_table_fields', array( $this, 'generate_link_record_fields' ), 10, 4 );
		add_filter( 'airwpsync/pre_check_existing_content', array( $this, 'populate_required_link_record_fields'), 10, 4 );
		add_filter( 'airwpsync/import_record_data', array( $this, 'populate_link_record_fields'), 10, 2 );
	}

	/**
	 * Get fields info from linked table.
	 *
	 * @param array $fields
	 * @param string $base_id
	 * @param Air_WP_Sync_Airtable_Api_Client $api_client
	 *
	 * @return array|mixed|object[]
	 */
	public function generate_link_record_fields( $fields, $base_id, $api_client, $options = [] ) {
		if ( !isset($options['enable_link_to_another_record']) || !$options['enable_link_to_another_record'] ) {
			return $fields;
		}
		foreach ( $fields as $i => $field ) {
			if ( in_array( $field->type, array( 'multipleRecordLinks' ), true ) ) {
				// Avoid infinite loops...
				if (in_array($field->id, self::$imported_fields_id, true)) {
					continue;
				}
				self::$imported_fields_id[]= $field->id;
				$data_table = $api_client->get_tables($base_id);
				$table  = Air_WP_Sync_Helper::get_table_by_id($data_table->tables, $field->options->linkedTableId);
				if (!$table) {
					continue;
				}
				$other_record_fields = $table->fields ? $table->fields : array();
				/*
				 * !!! If at some point we want to support nested multipleRecordLinks we will certainly need to change the table loading behaviour to:
				 * - Load tables name + id
				 * - when the user select the table, load the fields + multipleRecordLinks
				 * If we don't change this behaviour we don't know if we are loading multipleRecordLinks from the selected table or another one, so it's complex to avoid infinite loops...
				 */
				$other_record_fields = array_filter($other_record_fields, function ($field) {
					// We don't yet support nested multipleRecordLinks.
					return $field->type !== 'multipleRecordLinks';
				});
				$other_record_fields = array_values($other_record_fields);
				$other_record_fields = apply_filters( 'airwpsync/get_table_fields', $other_record_fields, $base_id, $api_client );

				foreach ($other_record_fields as $other_record_field) {
					$fields[]= (object) array(
						'type' => $other_record_field->type,
						'id' => '__rel__' . $field->id . '|' . $other_record_field->id,
						'name' => $other_record_field->name,
						'group' => '→ ' . $field->name,
					);
				}
				if (!$field->options->prefersSingleRecordLink) {
					foreach ( $other_record_fields as $other_record_field ) {
						$fields[]= (object) array(
							'type' => 'airwpsyncProxyRecordLinks|' . $other_record_field->type,
							'proxy_type' => $other_record_field->type,
							'id' => '__rel__' . $field->id . '|__proxy__|' . $other_record_field->id,
							// Translators: %s the field name.
							'name' => sprintf(__('[All records] %s'), $other_record_field->name),
							'group' => '→ ' . $field->name,
						);
					}
				}
			}
		}

		return $fields;
	}

	/**
	 * Populate required fields from linked records before the function `get_existing_content_id` is called.
	 *
	 * @param \stdClass $record
	 * @param Air_WP_Sync_Importer $importer
	 * @param array $destination_fields List of destination fields keys.
	 * @param array $options Importer options (e.g. "enable_link_to_another_record")
	 *
	 * @return \stdClass The record with the linked records fields.
	 */
	public function populate_required_link_record_fields($record, $importer, $destination_fields, $options = []) {
		if ( !isset($options['enable_link_to_another_record']) || !$options['enable_link_to_another_record'] ) {
			return $record;
		}
		$source_field_filter = [];
		$mappings = $importer->config()->get('mapping');
		if (is_array($mappings)) {
			foreach ( $destination_fields as $destination_field ) {
				foreach ($mappings as $mapping) {
					if ($destination_field === $mapping['wordpress']) {
						$source_field_filter[] = $mapping['airtable'];
					}
				}
			}
		}

		if (count($source_field_filter) > 0) {
			$record = $this->populate_link_record_fields($record, $importer, $source_field_filter);
		}

		return $record;
	}

	/**
	 * Populate fields from linked records.
	 *
	 * @param \stdClass $record
	 * @param Air_WP_Sync_Importer $importer
	 *
	 * @return \stdClass The record with the linked records fields.
	 */
	public function populate_link_record_fields($record, $importer, $source_field_filter = []) {
		// Prepare an index of the fields to makes things simpler.
		$full_fields = $importer->get_table_fields();
		$full_fields_indexed = array_reduce($full_fields, function ($result, $full_field) {
			$result[$full_field->id] = $full_field;
			return $result;
		}, []);

		foreach ($full_fields as $full_field) {
			// If we have a multipleRecordLinks field, get the data from the linked record and reformat the fields Air_WP_Sync_Abstract_Destination->get_airtable_value to work.
			if (preg_match( '/__rel__([^\|]+)(\|__proxy__)?\|([^\|]+)/', $full_field->id, $matches ) && (count($source_field_filter) === 0 || in_array($full_field->id, $source_field_filter, true))) {
				$base_id = $importer->config()->get('app_id');
				$record_link_field_id = $matches[1];
				$linked_record_field_id_full = $matches[3];
				$linked_record_field_id = $linked_record_field_id_full;

				// Manage composed fields with properties (@see Air_WP_Sync_Barcode_Source).
				if ( preg_match( '/(.+)\.(.+)/', $linked_record_field_id_full, $composed_matches ) ) {
					$linked_record_field_id = $composed_matches[1];
				}

				$full_field_key = '__rel__' . $record_link_field_id . $matches[2] . '|' . $linked_record_field_id;
				if ( strpos($full_field->type, 'airwpsyncProxyRecordLinks|') === 0) {
					if (!isset($record->fields->{$full_field_key})) {
						$record->fields->{$full_field_key} = [];
					}
					if( ! empty( $record->fields->{$record_link_field_id} ) ){
						foreach ($record->fields->{$record_link_field_id} as $record_id) {
							$link_record = $importer->get_api_client()->get_record($base_id, $full_fields_indexed[$record_link_field_id]->options->linkedTableId, $record_id, [ 'returnFieldsByFieldId' => true, ]);
							if (!isset($link_record->fields->{$linked_record_field_id})) {
								continue;
							}
							$field_value = $link_record->fields->{$linked_record_field_id};
							$record->fields->{$full_field_key} []= $field_value;
						}
					}
				} else {
					if( ! empty($record->fields->{$record_link_field_id}) ){
						$link_record = $importer->get_api_client()->get_record($base_id, $full_fields_indexed[$record_link_field_id]->options->linkedTableId, $record->fields->{$record_link_field_id}[0], [ 'returnFieldsByFieldId' => true, ]);
						if (!isset($link_record->fields->{$linked_record_field_id})) {
							continue;
						}
						$field_value = $link_record->fields->{$linked_record_field_id};
						$record->fields->{$full_field_key} = $field_value;
					}
				}
			}
		}

		// Reset $imported_fields_id after each new record.
		self::$imported_fields_id = [];

		return $record;
	}

	/**
	 * Prefix types with "airwpsyncProxyRecordLinks|".
	 *
	 * @param array $types Field types.
	 *
	 * @return string[]
	 */
	public static function prefix_types($types) {
		if (!is_array($types)) {
			return [];
		}
		return array_map(function ($type) {
			return 'airwpsyncProxyRecordLinks|' . $type;
		}, $types);
	}
}
