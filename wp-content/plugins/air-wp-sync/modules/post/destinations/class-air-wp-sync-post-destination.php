<?php

namespace Air_WP_Sync_Free;

/**
 * Post Destination
 */
class Air_WP_Sync_Post_Destination extends Air_WP_Sync_Abstract_Destination {
	/** @var string Destination slug */
	protected $slug = 'post';

	/** @var string Module slug */
	protected $module = 'post';

	/** @var Air_WP_Sync_Markdown_Formatter Markdown formatter */
	protected $markdown_formatter;

	/** @var Air_WP_Sync_Interval_Formatter Interval formatter */
	protected $interval_formatter;

	protected $string_supported_sources = array(
		'autoNumber',
		'barcode.type',
		'barcode.text',
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
	);

	/**
	 * Constructor
	 */
	public function __construct( $markdown_formatter, $interval_formatter ) {
		parent::__construct();

		$this->markdown_formatter = $markdown_formatter;
		$this->interval_formatter = $interval_formatter;

		add_filter( 'airwpsync/import_post_data', array( $this, 'add_to_post_data' ), 20, 3 );
		add_filter( 'airwpsync/features_by_post_type', array( $this, 'add_features_by_post_type' ), 10, 2 );
	}

	/**
	 * Handle post data importing
	 */
	public function add_to_post_data( $post_data, $importer, $fields ) {
		$mapped_fields = $this->get_destination_mapping( $importer, $fields );

		foreach ( $mapped_fields as $mapped_field ) {
			$value                                   = $this->get_airtable_value( $fields, $mapped_field['airtable'], $importer );
			$post_data[ $mapped_field['wordpress'] ] = $this->format( $value, $mapped_field, $importer );
		}
		return $post_data;
	}

	/**
	 * Add field features for each post types
	 */
	public function add_features_by_post_type( $features, $post_type ) {
		$destination_features = array(
			'post_name',
			'post_date',
			'post_status',
		);

		if( is_post_type_hierarchical( $post_type ) ){
			$destination_features[] = 'post_parent';
		}

		if ( post_type_supports( $post_type, 'title' ) ) {
			$destination_features[] = 'post_title';
		}

		if ( post_type_supports( $post_type, 'editor' ) ) {
			$destination_features[] = 'post_content';
		}

		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			$destination_features[] = 'post_excerpt';
		}

		if ( post_type_supports( $post_type, 'author' ) ) {
			$destination_features[] = 'post_author';
		}

		$features[ $this->slug ] = $destination_features;
		return $features;
	}

	/**
	 * Assign fields to mapping group
	 */
	protected function get_group() {
		return array(
			'label' => __( 'Post', 'air-wp-sync' ),
			'slug'  => 'post',
		);
	}

	/**
	 * Get mapping fields
	 */
	protected function get_mapping_fields() {
		return array(
			array(
				'value'             => 'post_title',
				'label'             => __( 'Title', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_content',
				'label'             => __( 'Content', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_excerpt',
				'label'             => __( 'Excerpt', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_name',
				'label'             => __( 'Slug', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_author',
				'label'             => __( 'Author', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_status',
				'label'             => __( 'Status', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'post_date',
				'label'             => __( 'Publication Date', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => array(
					'date',
					'dateTime',
					'lastModifiedTime',
				),
			),
			array(
				'value'             => 'post_parent',
				'label'             => __( 'Post parent (ID)', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => array( 'number' ),
			),
		);
	}

	/**
	 * Format imported value
	 */
	protected function format( $value, $mapped_field, $importer ) {
		$airtable_id = $mapped_field['airtable'];
		$destination = $mapped_field['wordpress'];
		$source_type = $this->get_source_type( $airtable_id, $importer );

		if ( 'post_author' === $destination ) {
			$user  = get_user_by( 'email', $value );
			$value = $user ? $user->ID : null;
		} elseif ( 'post_date' === $destination ) {
			if ( ! empty( $value ) && false === strtotime( $value ) ) {
				$value = null;
			}
			$value = iso8601_to_datetime( $value );
		} elseif ( 'post_parent' === $destination ) {
			$value = ! empty($value) ? (int) $value : 0;
		} else {
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
			// Multiple values
			elseif ( is_array( $value ) ) {
				$value = implode( ', ', $value );
			}
			// Default string
			else {
				$value = strval( $value );
			}

			// Remove html tags if saving as post title or slug
			if ( 'post_title' === $destination ) {
				$value = wp_strip_all_tags( $value );
			}
		}

		return $value;
	}
}
