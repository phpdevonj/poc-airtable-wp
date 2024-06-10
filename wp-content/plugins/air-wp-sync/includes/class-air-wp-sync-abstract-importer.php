<?php

namespace Air_WP_Sync_Free;

use DateTime, DateTimeZone, DateInterval;
use Exception, TypeError;
use WP_Error, WP_CLI;

/**
 * Abstract Importer
 */
abstract class Air_WP_Sync_Abstract_Importer {
	/** @var Air_WP_Sync_Importer_Settings Infos */
	public $infos;

	/** @var Air_WP_Sync_Importer_Settings Config */
	public $config;

	/** @var Air_WP_Sync_Airtable_Api_Client Api Client */
	protected $api_client;

	/** @var Air_WP_Sync_Abstract_Module module */
	protected $module;

	/**
	 * Constructor
	 */
	public function __construct( $importer_post_object, $module ) {
		$this->module = $module;
		$this->load_settings( $importer_post_object );

		add_filter( 'airwpsync/get_importers', array( $this, 'register' ) );
		$this->init();
		$this->schedule_cron_event();
	}

	/**
	 * Register importer
	 */
	public function register( $importers ) {
		$importers[] = $this;
		return $importers;
	}

	/**
	 * Infos getter
	 */
	public function infos() {
		return $this->infos;
	}

	/**
	 * Config getter
	 */
	public function config() {
		if (!$this->config->get( 'enable_link_to_another_record' ) && $this->config->get( 'mapping' )) {
			foreach ($this->config->get( 'mapping' ) as $mapping) {
				if ($mapping['airtable'] && strpos($mapping['airtable'], '__rel__') === 0) {
					$this->config->set( 'enable_link_to_another_record', 'yes' );
					break;
				}
			}
		}
		return $this->config;
	}

	/**
	 * Scheduled Sync next getter
	 */
	public function get_next_scheduled_sync() {
		return wp_next_scheduled( $this->get_schedule_slug() );
	}

	/**
	 * Fields getter
	 */
	public function get_airtable_fields() {
		return get_post_meta( $this->infos()->get( 'id' ), 'table_fields', true );
	}

	/**
	 * Run ID getter
	 */
	public function get_run_id() {
		return get_post_meta( $this->infos()->get( 'id' ), 'run', true );
	}

	/**
	 * Cron action
	 */
	public function cron() {
		return $this->run();
	}

	/**
	 * Run importer
	 */
	public function run() {
		if ( $this->get_run_id() ) {
			return new WP_Error( 'air-wp-sync-run-error', __( 'A sync is already running.', 'air-wpsync' ) );
		}

		try {
			// Define a unique id for this run
			$run_id = uniqid();
			// Save run
			update_post_meta( $this->infos()->get( 'id' ), 'run', $run_id );

			$this->log( sprintf( 'Starting importer...' ) );

			// Save table schema
			update_post_meta( $this->infos()->get( 'id' ), 'table_fields', $this->get_table_fields() );
			// Loop through all pages
			$offset = null;
			do {
				wp_cache_delete( $this->infos()->get( 'id' ), 'post_meta' );
				$offset = $this->get_records( $run_id, $offset );
			} while ( ! empty( $offset ) && $this->get_run_id() );

			return true;
		} catch ( Exception $e ) {
			$this->log( $e->getMessage() );
			$this->end_run( 'error', $e->getMessage() );
			return new WP_Error( 'air-wp-sync-run-error', $e->getMessage() );
		} catch ( TypeError $e ) {
			$this->log( $e->getMessage() );
			$this->end_run( 'error', $e->getMessage() );
			return new WP_Error( 'air-wp-sync-run-error', $e->getMessage() );
		}
	}

	/**
	 * Log message to file and WPCLI output
	 */
	public function log( $message, $level = 'log' ) {
		if ( ! is_dir( AIR_WP_SYNC_LOGDIR ) ) {
			wp_mkdir_p( AIR_WP_SYNC_LOGDIR );
		}
		$file = fopen( AIR_WP_SYNC_LOGDIR . '/' . $this->infos()->get( 'slug' ) . '-' . gmdate( 'Y-m-d' ) . '-' . $this->get_run_id() . '.log', 'a' );
		if ( ! is_string( $message ) ) {
			$message = var_export( $message, true );
		}
		fwrite( $file, "\n" . gmdate( 'Y-m-d H:i:s' ) . ' ' . $level . ' :: ' . $message );
		fclose( $file );

		if ( class_exists( 'WP_CLI' ) ) {
			$method = method_exists( 'WP_CLI', $level ) ? $level : 'log';
			WP_CLI::$method( $message );
		}
	}

	/**
	 * Process an airtable record import
	 */
	public function process_airtable_record( $record ) {
		$this->log( sprintf( 'Record ID %s', $record->id ) );
		try {
			// Check if we have existing content for this record
			$content_id = $this->get_existing_content_id( $record );
			if ( $content_id ) {
				$this->log( sprintf( '- Found matching content, ID %s', $content_id ) );
				// Check if we must update it
				if ( 'add' !== $this->config()->get( 'sync_strategy' ) && $this->needs_update( $content_id, $record ) ) {
					$content_id = $this->import_record( $record, $content_id );
				} else {
					$this->log( sprintf( '- No update needed' ) );
				}
			} else {
				$content_id = $this->import_record( $record );
			}
			return $content_id;
		} catch ( Exception $e ) {
			$this->log( $e->getMessage() );
			return new WP_Error( 'air-wp-sync-run-error', $e->getMessage() );
		} catch ( TypeError $e ) {
			$this->log( $e->getMessage() );
			return new WP_Error( 'air-wp-sync-run-error', $e->getMessage() );
		}
	}


	public function get_module() {
		return $this->module;
	}

	/**
	 * Delete other content existing in WP but deleted in AT
	 */
	abstract public function delete_removed_contents();

	/**
	 * End run
	 */
	public function end_run( $status = 'success', $error = null ) {
		global $wpdb;
		$importer_id = $this->infos()->get( 'id' );
		$run_id      = $this->get_run_id();
		// Delete any remaining AS actions
		$action_ids = \ActionScheduler::store()->query_actions(
			array(
				'hook'                  => 'airwpsync_process_records',
				'status'                => \ActionScheduler_Store::STATUS_PENDING,
				'partial_args_matching' => 'like',
				'args'                  => array(
					'importer_id' => $importer_id,
					'run_id'      => $run_id,
				),
				'per_page'              => -1,
			)
		);
		foreach ( $action_ids as $action_id ) {
			\ActionScheduler::store()->cancel_action( $action_id );
		}
		// Delete temporary options
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
				$wpdb->esc_like( sprintf( 'airwpsync-%s-run-%s-', $importer_id, $run_id ) ) . '%'
			)
		);
		// Remove temporary metas
		update_post_meta( $importer_id, 'content_ids', null );
		update_post_meta( $importer_id, 'run', null );
		update_post_meta( $importer_id, 'table_fields', null );
		// Update status and error
		update_post_meta( $importer_id, 'status', $status );
		update_post_meta( $importer_id, 'last_error', $error );
		// Save date if success
		if ( 'success' === $status ) {
			update_post_meta( $importer_id, 'last_updated', gmdate( 'Y-m-d H:i:s' ) );
		}
	}

	/**
	 * Get table fields from API
	 */
	public function get_table_fields() {
		$app_id = $this->config()->get( 'app_id' );
		$data   = $this->get_api_client()->get_tables( $app_id );
		$table  = Air_WP_Sync_Helper::get_table_by_id($data->tables, $this->config()->get( 'table' ));

		$fields = $table && $table->fields ? $table->fields : array();

		return apply_filters( 'airwpsync/get_table_fields', $fields, $app_id, $this->get_api_client(), $this->get_import_fields_options() );
	}

	/**
	 * Get AT records from API
	 */
	protected function get_records( $run_id, $offset = null ) {
		$api_list_options = array(
			'offset'                => $offset,
			'view'                  => $this->config()->get( 'view' ),
			'filterByFormula'       => $this->config()->get( 'formula_filter' ),
			'returnFieldsByFieldId' => true,
		);
		// Remove empty values
		$api_list_options = array_filter( $api_list_options );
		// Get records
		$app_id   = $this->config()->get( 'app_id' );
		$table_id = $this->config()->get( 'table' );
		$data     = $this->get_api_client()->list_records( $app_id, $table_id, $api_list_options );
		// Loop through all records
		$chunks = array_chunk( $data->records, 10 );
		foreach ( $chunks as $chunk ) {
			// Save Airtable record as a temporary option
			$item_id = uniqid( 'airwpsync-' . $this->infos()->get( 'id' ) . '-run-' . $this->get_run_id() . '-item-' );
			update_option( $item_id, $chunk );
			// Add it to queue
			as_enqueue_async_action(
				'airwpsync_process_records',
				array(
					'importer_id' => $this->infos()->get( 'id' ),
					'run_id'      => $run_id,
					'item_id'     => $item_id,
				)
			);
		}

		return ! empty( $data->offset ) ? $data->offset : false;
	}

	/**
	 * Get mapped fields
	 */
	protected function get_mapped_fields( $record ) {
		// Airtable omit keys for empty fields, lets add them with an empty string
		$mapping       = ! empty( $this->config()->get( 'mapping' ) ) ? $this->config()->get( 'mapping' ) : array();
		$airtable_keys = array_map(
			function( $mapping_pair ) {
				if ( preg_match( '/(.+)\.(.+)/', $mapping_pair['airtable'], $matches ) ) {
					$airtable_id = $matches[1];
				} else {
					$airtable_id = $mapping_pair['airtable'];
				}
				return $airtable_id;
			},
			$mapping
		);

		$fields = array();
		foreach ( $airtable_keys as $airtable_key ) {
			$fields[ $airtable_key ] = isset( $record->fields->$airtable_key ) ? $record->fields->$airtable_key : '';
		}

		return apply_filters( 'airwpsync/import_record_fields', $fields, $this );
	}

	/**
	 * Load importer settings from post object
	 */
	protected function load_settings( $importer_post_object ) {
		$infos = array(
			'id'       => $importer_post_object->ID,
			'slug'     => $importer_post_object->post_name,
			'title'    => $importer_post_object->post_title,
			'modified' => $importer_post_object->post_modified_gmt,
			'hash'     => wp_hash( $importer_post_object->ID ),
		);

		$this->infos = new Air_WP_Sync_Importer_Settings( $infos );

		$config       = json_decode( $importer_post_object->post_content, true );
		$this->config = new Air_WP_Sync_Importer_Settings( $config );
	}

	/**
	 * Get cron schedule slug
	 */
	protected function get_schedule_slug() {
		return 'air_wp_sync_importer_' . $this->infos()->get( 'id' );
	}

	/**
	 * Init cron events
	 */
	protected function schedule_cron_event() {
		if ( 'cron' === $this->config()->get( 'scheduled_sync.type' ) && $this->config()->get( 'scheduled_sync.recurrence' ) ) {
			add_action( $this->get_schedule_slug(), array( $this, 'cron' ) );
			if ( false === $this->get_next_scheduled_sync() ) {
				wp_schedule_event( $this->get_schedule_timestamp(), $this->config()->get( 'scheduled_sync.recurrence' ), $this->get_schedule_slug() );
			}
		} elseif ( $this->get_next_scheduled_sync() ) {
			wp_clear_scheduled_hook( $this->get_schedule_slug() );
		}
	}

	/**
	 * Get Schedule timestamp
	 */
	protected function get_schedule_timestamp() {
		$datetime   = new DateTime( 'now', new DateTimeZone( wp_timezone_string() ) );
		$recurrence = $this->config()->get( 'scheduled_sync.recurrence' );
		if ( 'weekly' === $recurrence ) {
			if ( $this->config()->get( 'scheduled_sync.weekday' ) ) {
				$datetime->modify( 'next ' . $this->config()->get( 'scheduled_sync.weekday' ) );
			}
		}
		if ( in_array( $recurrence, array( 'weekly', 'daily' ), true ) ) {
			if ( $this->config()->get( 'scheduled_sync.time' ) ) {
				$time = explode( ':', $this->config()->get( 'scheduled_sync.time' ) );
				$datetime->setTime( $time[0], $time[1] );
			}
		} else {
			$schedules = wp_get_schedules();
			$interval  = isset( $schedules[ $recurrence ] ) ? $schedules[ $recurrence ]['interval'] : HOUR_IN_SECONDS;
			$datetime->add( new DateInterval( 'PT' . $interval . 'S' ) );
		}
		return $datetime->getTimestamp();
	}

	/**
	 * Get or instanciate Airtable API client
	 */
	public function get_api_client() {
		if ( null === $this->api_client ) {
			$this->api_client = new Air_WP_Sync_Airtable_Api_Client( $this->config()->get( 'api_key' ) );
		}
		return $this->api_client;
	}

	/**
	 * Compare hashes to check if WP object needs update
	 */
	protected function needs_update( $content_id, $record ) {
		if ( defined( 'AIR_WP_SYNC_FORCE_UPDATES' ) && AIR_WP_SYNC_FORCE_UPDATES ) {
			return true;
		}
		return $this->generate_hash( $record ) !== $this->get_existing_content_hash( $content_id );
	}

	/**
	 * Generate hash for given Airtable record
	 */
	protected function generate_hash( $record ) {
		// $record_array = json_decode( json_encode( $record ), true );
		// $filtered = $this->filter_attachments_urls( $record_array );
		// Remove cs & ts query strings from urls in AT record
		$record_json = preg_replace( '/cs=[^"]+/i', '', wp_json_encode( $record ) );
		$record_json = preg_replace( '/ts=[^"]+/i', '', $record_json );
		return md5( $record_json . wp_json_encode( $this->config()->to_array() ) );
	}

	/**
	 * Filters the record attachment fields to exclude urls prior to hashing
	 * Airtable URLs change every two hours, causing update problems
	 */
	protected function filter_attachments_urls( $record ){
		foreach ( $record as $key => &$value ) {
			if ( is_array( $value ) ) $value = filter_attachments_urls( $value );
		}
		
		return array_filter( $record, function( $value, $key ){
			return $key != 'url';
		}, ARRAY_FILTER_USE_BOTH);
	}

	/**
	 * Returns the import fields options.
	 *
	 * @return array Import field's options
	 */
	public function get_import_fields_options() {
		$options = [
			'enable_link_to_another_record' => 'yes' === $this->config()->get( 'enable_link_to_another_record' ),
		];

		return $options;
	}

	/**
	 * Init
	 */
	protected function init() {
	}

	/**
	 * Import AT record
	 */
	abstract protected function import_record( $record, $existing_object_id = null );

	/**
	 * Get existing content id
	 */
	abstract protected function get_existing_content_id( $record );

	/**
	 * Get existing content hash
	 */
	abstract protected function get_existing_content_hash( $content_id );
}
