<?php

namespace Air_WP_Sync_Free;

/**
 * Importer
 */
class Air_WP_Sync_User_Importer extends Air_WP_Sync_Abstract_Importer {
	/**
	 * Delete other content existing in WP but deleted in AT
	 */
	public function delete_removed_contents() {
		if ( 'add_update_delete' !== $this->config()->get( 'sync_strategy' ) ) {
			return;
		}

		$content_ids = get_post_meta( $this->infos()->get( 'id' ), 'content_ids', true ) ?: array();
		if ( ! is_array( $content_ids ) ) {
			$content_ids = array();
		}

		$users = get_users(
			array(
				'exclude'    => $content_ids,
				'fields'     => 'ID',
				'number'     => -1,
				'meta_query' => array(
					array(
						'key'   => '_air_wp_sync_importer_id',
						'value' => $this->infos()->get( 'id' ),
					),
				),
			)
		);
		foreach ( $users as $user_id ) {
			wp_delete_user( $user_id );
		}
	}

	/**
	 * Import record
	 */
	protected function import_record( $record, $user_id = null ) {
		$this->log( sprintf( $user_id ? '- Update record %s' : '- Create record %s', $record->id ) );

		$record = apply_filters( 'airwpsync/import_record_data', $record, $this );
		$fields = $this->get_mapped_fields( $record );

		$user_metas = array(
			'_air_wp_sync_record_id'   => $record->id,
			'_air_wp_sync_hash'        => $this->generate_hash( $record ),
			'_air_wp_sync_importer_id' => $this->infos()->get( 'id' ),
			'_air_wp_sync_updated_at'  => gmdate( 'Y-m-d H:i:s' ),
		);

		$user_data = apply_filters( 'airwpsync/import_user_data', array(), $this, $fields, $record, $user_id );

		// Make sure we have mandatory data
		if ( empty( $user_data['user_pass'] ) ) {
			$user_data['user_pass'] = wp_generate_password();
		}
		if ( empty( $user_data['role'] ) ) {
			$user_data['role'] = $this->config()->get( 'default_role' );
		}
		if ( empty( $user_data['locale'] ) && 'site-default' !== $this->config()->get( 'default_locale' ) ) {
			$user_data['locale'] = $this->config()->get( 'default_locale' );
		}

		$is_new_user = null === $user_id;

		// Insert or update post
		if ( $user_id ) {
			$user_id = wp_update_user( array_merge( array( 'ID' => $user_id ), $user_data ), true );
		} else {
			$user_id = wp_insert_user( $user_data, true );
		}

		if ( is_wp_error( $user_id ) ) {
			throw new \Exception( $user_id->get_error_message() );
		}

		// Handle metas
		foreach ( $user_metas as $meta_key => $meta_value ) {
			update_user_meta( $user_id, $meta_key, $meta_value );
		}

		do_action( 'airwpsync/import_record_after', $this, $fields, $record, $user_id );

		if ( $is_new_user && $this->config()->get( 'send_user_notification' ) ) {
			do_action( 'edit_user_created_user', $user_id, 'both' );
		}

		return $user_id;
	}

	/**
	 * Get existing content id
	 */
	protected function get_existing_content_id( $record ) {
		$record = apply_filters( 'airwpsync/pre_check_existing_content', $record, $this, [ 'user::user_email' ], $this->get_import_fields_options() );
		$mapping              = ! empty( $this->config()->get( 'mapping' ) ) ? $this->config()->get( 'mapping' ) : array();
		$airtable_email_value = '';
		foreach ( $mapping as $mapping_field ) {
			if ( 'user::user_email' === $mapping_field['wordpress'] ) {
				$airtable_key         = $mapping_field['airtable'];
				$airtable_email_value = isset( $record->fields->$airtable_key ) ? $record->fields->$airtable_key : '';
			}
		}

		$user = get_user_by( 'email', $airtable_email_value );
		return $user ? $user->ID : false;
	}

	/**
	 * Get existing content hash
	 */
	protected function get_existing_content_hash( $content_id ) {
		return get_user_meta( $content_id, '_air_wp_sync_hash', true );
	}
}
