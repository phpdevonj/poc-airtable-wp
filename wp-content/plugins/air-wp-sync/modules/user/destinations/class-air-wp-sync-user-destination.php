<?php

namespace Air_WP_Sync_Free;

/**
 * User Destination
 */
class Air_WP_Sync_User_Destination extends Air_WP_Sync_Abstract_Destination {
	/** @var string Destination slug */
	protected $slug = 'user';

	/** @var string Module slug */
	protected $module = 'user';

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

		add_filter( 'airwpsync/import_user_data', array( $this, 'add_to_user_data' ), 20, 3 );
		add_action( 'airwpsync/metabox_mapping_wordpress_after', array( $this, 'add_username_notice' ) );
	}

	/**
	 * Handle post data importing
	 */
	public function add_to_user_data( $post_data, $importer, $fields ) {
		$mapped_fields = $this->get_destination_mapping( $importer, $fields );

		foreach ( $mapped_fields as $mapped_field ) {
			$value                                   = $this->get_airtable_value( $fields, $mapped_field['airtable'], $importer );
			$post_data[ $mapped_field['wordpress'] ] = $this->format( $value, $mapped_field, $importer );
		}
		return $post_data;
	}

	/**
	 * Assign fields to mapping group
	 */
	protected function get_group() {
		return array(
			'label' => __( 'User', 'air-wp-sync' ),
			'slug'  => 'user',
		);
	}

	/**
	 * Get mapping fields
	 */
	protected function get_mapping_fields() {
		return array(
			array(
				'value'             => 'user_login',
				'label'             => __( 'Username', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
				'notice'            => __( 'Please note that usernames cannot be changed once created.', 'air-wp-sync' ),
			),
			array(
				'value'             => 'first_name',
				'label'             => __( 'First name', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'last_name',
				'label'             => __( 'Last name', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'nickname',
				'label'             => __( 'Nickname', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'user_email',
				'label'             => __( 'Email', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'user_url',
				'label'             => __( 'Website', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'description',
				'label'             => __( 'Biographical Info', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'role',
				'label'             => __( 'Role', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'locale',
				'label'             => __( 'Locale', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => $this->string_supported_sources,
			),
			array(
				'value'             => 'user_registered',
				'label'             => __( 'Registered Date', 'air-wp-sync' ),
				'enabled'           => true,
				'supported_sources' => array(
					'date',
					'dateTime',
					'lastModifiedTime',
				),
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

		if ( 'user_registered' === $destination ) {
			if ( ! empty( $value ) && false === strtotime( $value ) ) {
				$value = null;
			}
			$value = iso8601_to_datetime( $value );
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
		}

		return $value;
	}
}
