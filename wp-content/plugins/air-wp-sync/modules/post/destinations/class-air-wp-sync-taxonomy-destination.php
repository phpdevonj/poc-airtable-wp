<?php

namespace Air_WP_Sync_Free;

/**
 * Taxonomy Destination
 */
class Air_WP_Sync_Taxonomy_Destination extends Air_WP_Sync_Abstract_Destination {
	/** @var string Destination slug */
	protected $slug = 'taxonomy';

	/** @var string Module slug */
	protected $module = 'post';

	/** @var Air_WP_Sync_Markdown_Formatter Markdown formatter */
	protected $markdown_formatter;

	/** @var Air_WP_Sync_Term_Formatter Term formatter */
	protected $term_formatter;

	/** @var Air_WP_Sync_Interval_Formatter Interval formatter */
	protected $interval_formatter;

	/**
	 * Constructor
	 */
	public function __construct( $markdown_formatter, $term_formatter, $interval_formatter ) {
		parent::__construct();

		$this->markdown_formatter = $markdown_formatter;
		$this->term_formatter     = $term_formatter;
		$this->interval_formatter = $interval_formatter;

		add_action( 'airwpsync/import_record_after', array( $this, 'import' ), 10, 4 );
		add_filter( 'airwpsync/features_by_post_type', array( $this, 'add_features_by_post_type' ), 10, 2 );
	}

	/**
	 * Import terms
	 */
	public function import( $importer, $fields, $record, $post_id ) {
		$mapped_fields = $this->get_destination_mapping( $importer, $fields );
		foreach ( $mapped_fields as $mapped_field ) {
			$value    = $this->get_airtable_value( $fields, $mapped_field['airtable'], $importer );
			$taxonomy = $mapped_field['wordpress'];
			$value    = $this->format( $value, $mapped_field, $importer, $taxonomy );
			wp_set_object_terms( $post_id, $value, $taxonomy );
		}
	}

	/**
	 * Add field features for each post types
	 */
	public function add_features_by_post_type( $features, $post_type ) {
		$features[ $this->slug ] = get_object_taxonomies( $post_type );
		return $features;
	}

	/**
	 * Assign fields to mapping group
	 */
	protected function get_group() {
		return array(
			'label' => __( 'Taxonomies', 'air-wp-sync' ),
			'slug'  => 'taxonomy',
		);
	}

	/**
	 * Get mapping fields
	 */
	protected function get_mapping_fields() {
		$whitelist        = array( 'category', 'post_tag' );
		$excluded         = array( 'link_category' );
		$taxonomies       = get_taxonomies(
			array(
				'show_ui' => 1,
			),
			'objects'
		);
		$taxonomy_options = array();

		foreach ( $taxonomies as $taxonomy ) {
			if ( ! in_array( $taxonomy->name, $excluded, true ) ) {
				$enabled            = in_array( $taxonomy->name, $whitelist, true );
				$taxonomy_options[] = array(
					'value'             => $taxonomy->name,
					'label'             => sprintf( '%s (%s)', $taxonomy->labels->singular_name, $taxonomy->name ) . ( ! $enabled ? ' ' . __( '(Pro version)', 'airwpsync' ) : '' ),
					'enabled'           => $enabled,
					'supported_sources' => array(
						'autoNumber',
						'barcode.type',
						'barcode.text',
						'count',
						'createdBy.id',
						'createdBy.email',
						'createdBy.name',
						'number',
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
						'multipleCollaborators.id',
						'multipleCollaborators.email',
						'multipleCollaborators.name',
						'multipleRecordLinks',
						'multipleSelects',
						'multilineText',
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
				);
			}
		}

		return $taxonomy_options;
	}

	/**
	 * Format imported value
	 */
	protected function format( $value, $mapped_field, $importer, $taxonomy ) {
		$airtable_id = $mapped_field['airtable'];
		$source_type = $this->get_source_type( $airtable_id, $importer );

		// Markdown
		if ( 'richText' === $source_type ) {
			$value = $this->markdown_formatter->format( $value );
		}
		// Date
		elseif ( in_array( $source_type, array( 'date', 'dateTime' ), true ) ) {
			$value = date_i18n( get_option( 'date_format' ), strtotime( $value ) );
		} elseif ( 'duration' === $source_type ) {
			$field = $this->get_field_by_id( $airtable_id, $importer );
			$value = $this->interval_formatter->format( $value, $field );
		}
		// Default string
		elseif ( ! is_array( $value ) ) {
				$value = strval( $value );
		}

		return $this->term_formatter->format( $value, $importer, $taxonomy );
	}
}
