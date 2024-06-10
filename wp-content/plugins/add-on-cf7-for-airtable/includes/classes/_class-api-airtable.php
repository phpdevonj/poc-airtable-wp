<?php
/**
 * Airtable API class.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT;

defined( 'ABSPATH' ) || exit;

/**
 * This class is in charge of communicating with the Airtable API.
 */
class API_Airtable {
	/**
	 * API key.
	 *
	 * @var string
	 */
	protected $api_key = null;

	/**
	 * App Id.
	 *
	 * @var string
	 */
	protected $app_id = null;

	/**
	 * API response, raw.
	 *
	 * @var mixed
	 */
	protected $response = null;

	/**
	 * Instantiate this class by passing the API key.
	 *
	 * @param string $api_key The Airtable API key.
	 * @param string $app_id The Airtable App Id.
	 */
	public function __construct( $api_key, $app_id ) {
		$this->api_key = $api_key;
		$this->app_id  = $app_id;
	}

	// =========================
	//
	// ###    #####   ##
	// ## ##   ##  ##  ##
	// ##   ##  #####   ##
	// #######  ##      ##
	// ##   ##  ##      ##
	//
	// =========================

	/**
	 * Send a manual request to the Airtable API.
	 *
	 * @param string $route Airtable API Endpoint.
	 * @param array  $body Request body.
	 * @param string $method Request method.
	 * @return object|\WP_Error
	 */
	protected function request( $route = '', $body = array(), $method = 'POST' ) {
		if ( 'GET' !== $method ) {
			$body = wp_json_encode( $body );
		}

		// Construct headers.
		$headers = array(
			'Content-Type'  => 'application/json',
			'Authorization' => 'Bearer ' . $this->api_key,
		);

		$args = apply_filters(
			'add-on-cf7-for-airtable/airtable-api/request-args',
			array(
				'timeout' => 15,
				'body'    => $body,
				'method'  => $method,
				'headers' => $headers,
			)
		);

		$url = sprintf( '%1$s%2$s/%3$s', 'https://api.airtable.com/v0/', $this->app_id, $route );

		$this->response  = wp_remote_request( $url, $args );
		$pretty_response = json_decode( wp_remote_retrieve_body( $this->response ) );

		if ( in_array( (int) wp_remote_retrieve_response_code( $this->response ), array( 400, 401 ), true ) ) {
			$this->response = new \WP_Error(
				isset( $this->response->code ) ? sanitize_text_field( $this->response->code ) : 'wpc_wpcf7_airtable_api_error',
				isset( $this->response->message ) ? sanitize_text_field( $this->response->message ) : __( 'The Airtable API responded with an error.', 'add-on-cf7-for-airtable' ),
				array(
					'url'             => $url,
					'body'            => $body,
					'pretty_response' => $pretty_response,
					'response'        => $this->response,
				)
			);
		} elseif ( isset( $pretty_response->error ) ) {
			$this->response = new \WP_Error(
				isset( $pretty_response->error->type ) ? sanitize_text_field( $pretty_response->error->type ) : 'wpc_wpcf7_airtable_api_error',
				isset( $pretty_response->error->message ) ? sanitize_text_field( $pretty_response->error->message ) : __( 'The Airtable API responded with an error.', 'add-on-cf7-for-airtable' ),
				array(
					'url'             => $url,
					'body'            => $body,
					'pretty_response' => $pretty_response,
					'response'        => $this->response,
				)
			);
		}

		do_action( 'add-on-cf7-for-airtable/airtable-api/response', $route, $pretty_response, $this->response, $body );

		return is_wp_error( $this->response ) ? $this->response : $pretty_response;
	}

	// ============================
	//
	// ###     ####  ######
	// ## ##   ##       ##
	// ##   ##  ##       ##
	// #######  ##       ##
	// ##   ##   ####    ##
	//
	// ============================


	/**
	 * Add a row to a table.
	 *
	 * @param string $table_id The table id.
	 * @param array  $fields The fields values.
	 * @return object|\WP_Error
	 */
	public function add_table_row( $table_id, $fields = array() ) {
		return $this->request(
			$table_id,
			array(
				'records' => array(
					array(
						'fields' => $fields,
					),
				),
			)
		);
	}

	/**
	 * Get table records.
	 *
	 * @param string $table_id The table id.
	 * @return object|\WP_Error
	 */
	public function get_table( $table_id ) {
		return $this->request(
			$table_id,
			array(),
			'GET'
		);
	}
}
