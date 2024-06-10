<?php

namespace Air_WP_Sync_Free;

use Exception;

/**
 * Air_WP_Sync_Metabox_Global_Settings
 */
class Air_WP_Sync_Metabox_Global_Settings {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'wp_ajax_air_wp_sync_get_airtable_bases', array( $this, 'get_airtable_bases' ) );
		add_action( 'wp_ajax_air_wp_sync_get_airtable_tables', array( $this, 'get_airtable_tables' ) );
		add_action( 'wp_ajax_air_wp_sync_check_formula_filter', array( $this, 'check_formula_filter' ) );
	}

	/**
	 * Add metabox
	 */
	public function add_meta_box() {
		add_meta_box(
			'airwpsync-global-settings',
			__( 'Airtable Settings', 'air-wp-sync' ),
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
		include_once AIR_WP_SYNC_PLUGIN_DIR . 'views/metabox-airtable-settings.php';
	}

	public function get_airtable_bases() {
		// Data check
		if ( empty( $_POST['apiKey'] ) ) {
			wp_die();
		}
		// Nonce check
		check_ajax_referer( 'air-wp-sync-ajax', 'nonce' );

		// Get data
		$params  = array_merge( $_POST );
		$params  = wp_unslash( $params );
		$api_key = sanitize_text_field( $params['apiKey'] );

		try {
			$offset = null;
			$bases  = array();

			if ( strpos( $api_key, 'key' ) === 0 ) {
				/* translators: %1$s = access token creation URL */
				throw new Exception( sprintf( __( 'This looks like a user API key that is now deprecated. Please replace it with a <a href="%1$s" target="_blank">personal access token</a>.', 'air-wp-sync' ), 'https://airtable.com/developers/web/guides/personal-access-tokens' ) );
			}

			$client = new Air_WP_Sync_Airtable_Api_Client( $api_key );

			do {
				$options = array( 'offset' => $offset );
				$result  = $client->list_bases( $offset );
				$offset  = $result->offset ?? null;
				$bases   = array_merge( $bases, $result->bases );
			} while ( ! is_null( $offset ) );

			wp_send_json_success(
				array(
					'bases' => $bases,
				)
			);
		} catch ( Exception $e ) {
			wp_send_json_error(
				array(
					'error' => $e->getMessage(),
				)
			);
		}
	}

	public function get_airtable_tables() {
		// Data check
		if ( empty( $_POST['apiKey'] ) || empty( $_POST['appId'] ) ) {
			wp_die();
		}
		// Nonce check
		check_ajax_referer( 'air-wp-sync-ajax', 'nonce' );

		// Get data
		$params  = array_merge( $_POST );
		$params  = wp_unslash( $params );
		$api_key = sanitize_text_field( $params['apiKey'] );
		$app_id  = sanitize_text_field( $params['appId'] );

		$options = [];
		try {
			$options  = json_decode(sanitize_text_field( $params['options'] ), true);
		} catch (\Exception $e) {

		}

		try {
			$offset = null;
			$bases  = array();

			$client = new Air_WP_Sync_Airtable_Api_Client( $api_key );
			$result = $client->get_tables( $app_id );
			$tables = $result->tables;

			foreach ( $tables as &$table ) {
				$table->fields = apply_filters( 'airwpsync/get_table_fields', $table->fields, $app_id, $client, $options );
			}

			wp_send_json_success(
				array(
					'tables' => $tables,
				)
			);
		} catch ( Exception $e ) {
			wp_send_json_error(
				array(
					'error' => $e->getMessage(),
				)
			);
		}
	}

	public function check_formula_filter() {
		// Data check
		if ( empty( $_POST['apiKey'] ) || empty( $_POST['appId'] ) || empty( $_POST['table'] ) ) {
			wp_die();
		}
		// Nonce check
		check_ajax_referer( 'air-wp-sync-ajax', 'nonce' );

		// Get data
		$params         = array_merge( $_POST );
		$params         = wp_unslash( $params );
		$api_key        = sanitize_text_field( $params['apiKey'] );
		$app_id         = sanitize_text_field( $params['appId'] );
		$table          = sanitize_text_field( $params['table'] );
		$view           = sanitize_text_field( $params['view'] ?? '' );
		$formula_filter = sanitize_text_field( $params['formulaFilter'] ?? '' );

		$options = array();
		if ( ! empty( $view ) ) {
			$options['view'] = $view;
		}
		if ( ! empty( $formula_filter ) ) {
			$options['filterByFormula'] = $formula_filter;
		} else {
			wp_send_json_error(
				array(
					'nonce'   => $nonce,
					'message' => __( 'No formula to check', 'air-wp-sync' ),
				)
			);
		}

		$nonce = wp_create_nonce( 'air-wp-sync-ajax' );

		try {
			$client  = new Air_WP_Sync_Airtable_Api_Client( $api_key );
			$records = $client->list_records( $app_id, $table, $options );

			wp_send_json_success(
				array(
					'nonce' => $nonce,
				)
			);
		} catch ( Exception $e ) {
			// TODO: translate error message
			// if ( strpos( $e->getMessage(), 'Airtable API: The formula for filtering records is invalid' ) > -1 ) {
			// }

			wp_send_json_error(
				array(
					'nonce' => $nonce,
					'error' => $e->getMessage(),
				)
			);
		}
	}
}
