<?php

namespace Air_WP_Sync_Free;

/**
 * Air_WP_Sync_Metabox_Importer_Settings
 */
class Air_WP_Sync_Metabox_Importer_Settings {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}

	/**
	 * Add metabox
	 */
	public function add_meta_box() {
		add_meta_box(
			'airwpsync-post-settings',
			__( 'Import As...', 'air-wp-sync' ),
			array( $this, 'display' ),
			'airwpsync-connection',
			'normal',
			'high'
		);
	}

	/**
	 * Output metabox HTML
	 */
	public function display( $post ) {
		$modules = Air_WP_Sync_Helper::get_modules();
		include_once AIR_WP_SYNC_PLUGIN_DIR . 'views/metabox-importer-settings.php';
	}
}
