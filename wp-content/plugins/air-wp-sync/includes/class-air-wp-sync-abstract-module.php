<?php

namespace Air_WP_Sync_Free;

/**
 * Abstract Module
 */
abstract class Air_WP_Sync_Abstract_Module {
	/** @var string Module slug */
	protected $slug;

	/** @var string Module name */
	protected $name;

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( ! isset( $this->slug ) ) {
			throw new \Exception( get_class( $this ) . ' must have a $slug property' );
		}
		if ( ! isset( $this->name ) ) {
			throw new \Exception( get_class( $this ) . ' must have a $name property' );
		}

		add_filter( 'airwpsync/get_modules', array( $this, 'register' ) );
	}

	/**
	 * Register module
	 */
	public function register( $modules ) {
		return array_merge( $modules, array( $this->get_slug() => $this ) );
	}

	/**
	 * Slug getter
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * Name getter
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Render module settings
	 */
	abstract public function render_settings( $post );

	/**
	 * Get importer instance
	 */
	abstract public function get_importer_instance( $post );

	/**
	 * Get mapping options
	 */
	abstract public function get_mapping_options();

	/**
	 * Get extra config
	 */
	public function get_extra_config() {
		return array();
	}
}
