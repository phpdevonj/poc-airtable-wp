<?php

namespace Air_WP_Sync_Free;

/**
 * Air_WP_Sync_Metabox_Field_Mapping
 */
class Air_WP_Sync_Metabox_Field_Mapping {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_filter( 'airwpsync/mapping_validation_rules', array( $this, 'add_mapping_validation_rules' ), 10, 1 );
	}

	/**
	 * Add metabox
	 */
	public function add_meta_box() {
		$tooltip_html = '<span class="airwpsync-tooltip" aria-label="' . esc_attr__( 'Add all the Airtable fields you want to synchronize and then select the corresponding data types where they will be imported into your post', 'air-wp-sync' ) . '">?</span>';
		add_meta_box(
			'airwpsync-mapping',
			__( 'Field Mapping', 'air-wp-sync' ) . $tooltip_html,
			array( $this, 'display' ),
			'airwpsync-connection',
			'normal',
			'high'
		);
	}

	/**
	 * Output metabox HTML
	 */
	public function display() {
		$mapping_validation_rules = apply_filters( 'airwpsync/mapping_validation_rules', array( 'required' ) );
		include_once AIR_WP_SYNC_PLUGIN_DIR . 'views/metabox-mapping.php';
	}

	/**
	 * Add required mapping rule to mapping rules
	 */
	public function add_mapping_validation_rules( $rules ) {
		$rules[] = 'mappingRequired';
		return $rules;
	}
}
