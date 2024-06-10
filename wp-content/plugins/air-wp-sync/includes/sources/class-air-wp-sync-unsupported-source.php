<?php

namespace Air_WP_Sync_Free;

/**
 * Unsupported Source
 */
class Air_WP_Sync_Unsupported_Source {
	public function __construct() {
		add_filter( 'airwpsync/get_table_fields', array( $this, 'remove_fields' ) );
	}

	public function remove_fields( $fields ) {
		$fields = array_filter(
			$fields,
			function( $field ) {
				return $field->type !== 'button';
			}
		);
		return array_values( $fields );
	}
}
