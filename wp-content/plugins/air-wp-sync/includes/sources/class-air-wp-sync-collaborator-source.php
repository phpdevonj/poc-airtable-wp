<?php

namespace Air_WP_Sync_Free;

/**
 * Collaborator Source
 */
class Air_WP_Sync_Collaborator_Source {
	protected $fields = array(
		'singleCollaborator',
		'multipleCollaborators',
		'createdBy',
		'lastModifiedBy',
	);

	public function __construct() {
		add_filter( 'airwpsync/get_table_fields', array( $this, 'explode_fields' ) );
	}

	public function explode_fields( $fields ) {
		foreach ( $fields as $i => $field ) {
			if ( in_array( $field->type, $this->fields, true ) ) {
				$part_one   = array_slice( $fields, 0, $i );
				$part_two   = array_slice( $fields, $i + 1 );
				$new_values = array(
					(object) array(
						'type' => sprintf( '%s.%s', $field->type, 'id' ),
						'id'   => sprintf( '%s.%s', $field->id, 'id' ),
						'name' => sprintf( '%s (%s)', $field->name, __( 'ID', 'air-wp-sync' ) ),
					),
					(object) array(
						'type' => sprintf( '%s.%s', $field->type, 'email' ),
						'id'   => sprintf( '%s.%s', $field->id, 'email' ),
						'name' => sprintf( '%s (%s)', $field->name, __( 'Email', 'air-wp-sync' ) ),
					),
					(object) array(
						'type' => sprintf( '%s.%s', $field->type, 'name' ),
						'id'   => sprintf( '%s.%s', $field->id, 'name' ),
						'name' => sprintf( '%s (%s)', $field->name, __( 'Name', 'air-wp-sync' ) ),
					),
				);
				$fields     = array_merge( $part_one, $new_values, $part_two );
			}
		}
		return $fields;
	}
}
