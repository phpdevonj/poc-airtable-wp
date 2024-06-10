<?php

namespace Air_WP_Sync_Free;

/**
 * Post Meta Destination
 */
class Air_WP_Sync_Post_Meta_Destination extends Air_WP_Sync_Abstract_Destination {
	/** @var string Destination slug */
	protected $slug = 'postmeta';

	/** @var string Module slug */
	protected $module = 'post';

	/** @var Air_WP_Sync_Markdown_Formatter Markdown formatter */
	protected $markdown_formatter;

	/** @var Air_WP_Sync_Attachments_Formatter Attachment formatter */
	protected $attachment_formatter;

	/**
	 * Constructor
	 */
	public function __construct( $markdown_formatter, $attachment_formatter ) {
		parent::__construct();

		$this->markdown_formatter   = $markdown_formatter;
		$this->attachment_formatter = $attachment_formatter;

		add_action( 'airwpsync/import_record_after', array( $this, 'add_metas' ), 10, 4 );
		add_filter( 'airwpsync/features_by_post_type', array( $this, 'add_features_by_post_type' ), 10, 2 );
	}

	/**
	 * Handle post meta importing
	 */
	public function add_metas( $importer, $fields, $record, $post_id ) {
		$mapped_fields = $this->get_destination_mapping( $importer, $fields );
		foreach ( $mapped_fields as $mapped_field ) {
			// Get meta value
			$value = $this->get_airtable_value( $fields, $mapped_field['airtable'], $importer );
			$value = $this->format( $value, $mapped_field, $importer, $post_id );
			// Get meta key
			$key = '';
			if ( '_thumbnail_id' === $mapped_field['wordpress'] ) {
				$key = $mapped_field['wordpress'];
			} elseif ( ! empty( $mapped_field['options']['name'] ) ) {
				$key = $mapped_field['options']['name'];
			}
			// Save meta
			if ( ! empty( $key ) ) {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	/**
	 * Add field features for each post types
	 */
	public function add_features_by_post_type( $features, $post_type ) {
		$destination_features = array(
			'custom_field',
		);

		if ( post_type_supports( $post_type, 'thumbnail' ) ) {
			$destination_features[] = '_thumbnail_id';
		}
		$features[ $this->slug ] = $destination_features;
		return $features;
	}

	/**
	 * Assign fields to mapping group
	 */
	protected function get_group() {
		return array(
			'slug' => 'post',
		);
	}

	/**
	 * Get mapping fields
	 */
	protected function get_mapping_fields() {
		return array(
			array(
				'value'             => '_thumbnail_id',
				'label'             => __( 'Featured Image', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => array(
					'multipleAttachments',
				),
			),
			array(
				'value'             => 'custom_field',
				'label'             => __( 'Custom Field... (Pro version)', 'air-wp-sync' ),
				'enabled'           => false,
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
	protected function format( $value, $mapped_field, $importer, $post_id ) {
		$airtable_id = $mapped_field['airtable'];
		$destination = $mapped_field['wordpress'];
		$source_type = $this->get_source_type( $airtable_id, $importer );

		if ( '_thumbnail_id' === $destination ) {
			// Keep first attachment from multipleAttachments
			if ( is_array( $value ) ) {
				$value = array_shift( $value );
			}
			// Import as media and get attachment ID
			$value = $this->attachment_formatter->format( $value, $importer, $post_id );
			if ( is_array( $value ) ) {
				$value = array_shift( $value );
			}
			if ( ! empty( $value ) && ! is_int( $value ) ) {
				$value = null;
			}
		}

		return $value;
	}

	/**
	 * Check if source attachment is an image
	 */
	protected function check_if_image( $value ) {
		$type_parts = explode( '/', $value->type );
		return 'image' === $type_parts[0] ? $value : null;
	}
}
