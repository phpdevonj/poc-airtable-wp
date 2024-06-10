<?php

namespace Air_WP_Sync_Free;

use Exception;

/**
 * Airtable Api Client class
 */
class Air_WP_Sync_Airtable_Api_Client {
	/** @var string API Endpoint */
	protected $endpoint = 'https://api.airtable.com/v0';

	/** @var string Authentication Token */
	protected $token;

	/**
	 * Constructor
	 */
	public function __construct( $token ) {
		$this->token = $token;
	}

	/**
	 * List bases
	 */
	public function list_bases( $options = array() ) {
		return $this->make_api_request( '/meta/bases', $options );
	}

	/**
	 * Get tables
	 */
	public function get_tables( $base_id, $use_cache = true ) {
		$tables = [];
		$transient_name = sprintf( 'airwpsync_tables_%s', $base_id );
		if( $use_cache ) $tables = get_transient( $transient_name );
		if( empty( $tables ) ){
			$tables = $this->make_api_request( "/meta/bases/$base_id/tables" );
			set_transient( $transient_name, $tables, 15 * MINUTE_IN_SECONDS );
		}
		return $tables;
	}

	/**
	 * List records
	 */
	public function list_records( $base_id, $table_id, $options = array() ) {
		return $this->make_api_request( "/$base_id/$table_id", $options );
	}

	/**
	 * Get record
	 */
	public function get_record( $base_id, $table_id, $record_id, $options = array() ) {
		return $this->make_api_request( "/$base_id/$table_id/$record_id", $options );
	}

	/**
	 * Create records
	 */
	public function create_records( $base_id, $table_id, $records ) {
		return $this->make_api_request( "/$base_id/$table_id", array( 'records' => $records ), 'POST' );
	}

	/**
	 * Performs API request
	 */
	protected function make_api_request( $url, $data = array(), $type = 'GET' ) {
		$url = $this->endpoint . $url;

		if ( 'POST' === $type ) {
			$data = wp_json_encode( $data );
			if ( false === $data ) {
				throw new Exception( 'Cannot encode body in JSON' );
			}
		}
		$args     = $this->get_request_args( array( 'body' => $data ) );
		$response = 'POST' === $type ? wp_remote_post( $url, $args ) : wp_remote_get( $url, $args );
		return $this->validate_response( $response );
	}

	/**
	 * Build request args
	 */
	protected function get_request_args( $args = array() ) {
		return array_merge(
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $this->token,
					'Content-Type'  => 'application/json',
				),
				'timeout' => 15,
			),
			$args
		);
	}

	/**
	 * Validate HTTP Response and returns data
	 */
	protected function validate_response( $response ) {
		if ( is_wp_error( $response ) ) {
			throw new Exception( sprintf( 'Airtable API: %s', $response->get_error_message() ) );
		}
		// Check HTTP code
		$reponse_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $reponse_code ) {
			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body );
			if ( ! empty( $data->error ) ) {
				throw new Exception( sprintf( 'Airtable API: %s', $this->get_error_message( $data ) ) );
			}
			throw new Exception( sprintf( 'Airtable API: Received HTTP Error, code %s', $reponse_code ) );
		}
		// Get JSON data from request body
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body );
		if ( is_null( $data ) ) {
			throw new Exception( 'Airtable API: Couldnt decode JSON response' );
		}
		return $data;
	}

	/**
	 * Get error message from Airtable response
	 */
	protected function get_error_message( $data ) {
		if ( ! empty( $data->error->message ) ) {
			return $data->error->message;
		}
		if ( ! empty( $data->error->type ) ) {
			return $data->error->type;
		}
		if ( is_string( $data->error ) ) {
			return $data->error;
		}
		return 'No error message';
	}
}
