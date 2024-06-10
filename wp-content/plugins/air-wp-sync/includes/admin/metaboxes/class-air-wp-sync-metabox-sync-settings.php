<?php

namespace Air_WP_Sync_Free;

/**
 * Air_WP_Sync_Metabox_Sync_Settings
 */
class Air_WP_Sync_Metabox_Sync_Settings {
	/**
	 * Constructor
	 */
	public function __construct( ) {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}

	/**
	 * Add metabox
	 */
	public function add_meta_box() {
		add_meta_box(
			'airwpsync-sync-settings',
			__( 'Sync Settings', 'air-wp-sync' ),
			array( $this, 'display' ),
			'airwpsync-connection',
			'normal'
		);
	}

	/**
	 * Output metabox HTML
	 */
	public function display( $post ) {
		$importer        = Air_WP_Sync_Helper::get_importer_by_id( $post->ID );
		$webhook_url     = $importer ? get_rest_url( null, 'airwpsync/v1/import/' . $importer->infos()->get( 'hash' ) ) : null;
		$sync_strategies = $this->get_sync_strategies();
		$schedules       = $this->get_schedules();
		include_once AIR_WP_SYNC_PLUGIN_DIR . 'views/metabox-sync.php';
	}

	/**
	 * Get sync strategies
	 */
	protected function get_sync_strategies() {
		return array(
			'add_update_delete' => __( 'Add, Update & Delete', 'air-wp-sync' ),
			'add_update'        => __( 'Add & Update', 'air-wp-sync' ),
			'add'               => __( 'Add', 'air-wp-sync' ),
		);
	}

	/**
	 * Get schedules
	 */
	protected function get_schedules() {
		$whitelist = array( 'hourly', 'twicedaily', 'daily', 'weekly' );
		$schedules = array();

		foreach ( wp_get_schedules() as $key => $schedule ) {
			if ( in_array( $key, $whitelist, true ) || strpos( $key, 'airwpsync_' ) === 0 ) {
				$enabled                            = $schedule['interval'] >= DAY_IN_SECONDS;
				$schedules[ $schedule['interval'] ] = array(
					'value'   => $key,
					'label'   => $schedule['display'] . ( ! $enabled ? ' ' . __( '(Pro version)', 'airwpsync' ) : '' ),
					'enabled' => $enabled,
				);
			}
		}
		ksort( $schedules );

		return array_reverse( $schedules );
	}
}
