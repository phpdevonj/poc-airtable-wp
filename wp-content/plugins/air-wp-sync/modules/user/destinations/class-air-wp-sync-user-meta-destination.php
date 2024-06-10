<?php

namespace Air_WP_Sync_Free;

/**
 * User Meta Destination
 */
class Air_WP_Sync_User_Meta_Destination extends Air_WP_Sync_Abstract_Destination {
	/** @var string Destination slug */
	protected $slug = 'usermeta';

	/** @var string Module slug */
	protected $module = 'user';

	/** @var Air_WP_Sync_Markdown_Formatter Markdown formatter */
	protected $markdown_formatter;

	/** @var Air_WP_Sync_Attachment_Formatter Attachment formatter */
	protected $attachment_formatter;

	/**
	 * Constructor
	 */
	public function __construct( $markdown_formatter, $attachment_formatter ) {
		parent::__construct();

		$this->markdown_formatter   = $markdown_formatter;
		$this->attachment_formatter = $attachment_formatter;

		add_action( 'airwpsync/import_record_after', array( $this, 'add_metas' ), 10, 4 );
	}

	/**
	 * Handle post meta importing
	 */
	public function add_metas( $importer, $fields, $record, $user_id ) {
		$mapped_fields = $this->get_destination_mapping( $importer, $fields );
		foreach ( $mapped_fields as $mapped_field ) {
			// Get meta value
			$value = $this->get_airtable_value( $fields, $mapped_field['airtable'], $importer );
			$value = $this->format( $value, $mapped_field, $importer, $user_id );
			// Get meta key
			$key = '';
			if ( '_thumbnail_id' === $mapped_field['wordpress'] ) {
				$key = $mapped_field['wordpress'];
			} elseif ( ! empty( $mapped_field['options']['name'] ) ) {
				$key = $mapped_field['options']['name'];
			}
			// Save meta
			if ( ! empty( $key ) ) {
				update_user_meta( $user_id, $key, $value );
			}
		}
	}

	/**
	 * Assign fields to mapping group
	 */
	protected function get_group() {
		return array(
			'slug' => 'user',
		);
	}

	/**
	 * Get mapping fields
	 */
	protected function get_mapping_fields() {
		return array(
			array(
				'value'             => 'custom_field',
				'label'             => __( 'Custom Field...', 'air-wp-sync' ),
				'enabled'           => true,
				'allow_multiple'    => true,
				'supported_sources' => array(
					'autoNumber',
					'barcode.type',
					'barcode.text',
					'checkbox',
					'count',
					'createdBy.id',
					'createdBy.email',
					'createdBy.name',
					'currency',
					'date',
					'dateTime',
					'duration',
					'email',
					'externalSyncSource',
					'lastModifiedBy.id',
					'lastModifiedBy.email',
					'lastModifiedBy.name',
					'lastModifiedTime',
					'multipleAttachments',
					'multipleCollaborators.id',
					'multipleCollaborators.email',
					'multipleCollaborators.name',
					'multipleRecordLinks',
					'multipleSelects',
					'multilineText',
					'number',
					'percent',
					'phoneNumber',
					'rating',
					'richText',
					'rollup',
					'singleCollaborator.id',
					'singleCollaborator.email',
					'singleCollaborator.name',
					'singleLineText',
					'singleSelect',
					'url',
				),
			),
		);
	}

	/**
	 * Format imported value
	 */
	protected function format( $value, $mapped_field, $importer, $user_id ) {
		$airtable_id = $mapped_field['airtable'];
		$destination = $mapped_field['wordpress'];
		$source_type = $this->get_source_type( $airtable_id, $importer );

		// Markdown
		if ( 'richText' === $source_type ) {
			$value = $this->markdown_formatter->format( $value );
		}
		// Attachments
		elseif ( 'multipleAttachments' === $source_type ) {
			$value = $this->attachment_formatter->format( $value, $importer );
		}
		// Checkbox
		elseif ( 'checkbox' === $source_type ) {
			// Convert boolean to 0|1
			$value = (int) filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		}

		return $value;
	}
}
