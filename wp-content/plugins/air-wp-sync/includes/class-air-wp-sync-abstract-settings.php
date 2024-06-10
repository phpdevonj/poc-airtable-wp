<?php

namespace Air_WP_Sync_Free;

/**
 * Abstract Settings class
 */
abstract class Air_WP_Sync_Abstract_Settings implements \JsonSerializable {
	/** @var array settings */
	protected $settings = array();

	/**
	 * Constructor
	 */
	public function __construct( $settings ) {
		$this->settings = is_array( $settings ) ? $settings : array();
	}

	/**
	 * Get a setting
	 */
	public function get( $key ) {
		return array_reduce(
			explode( '.', $key ),
			function ( $o, $p ) {
				return is_array($o) && array_key_exists( $p, $o ) ? $o[ $p ] : false;
			},
			$this->settings
		);
	}

	/**
	 * Set a setting
	 */
	public function set( $key, $value ) {
		$this->settings[ $key ] = $value;
	}

	/**
	 * Delete a setting
	 */
	public function delete( $key ) {
		if ( array_key_exists( $key, $this->settings ) ) {
			unset( $this->settings[ $key ] );
		}
	}

	/**
	 * Get all settings as array
	 */
	public function to_array() {
		return $this->settings;
	}

	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return $this->settings;
	}

}
