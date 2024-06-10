<?php

namespace Air_WP_Sync_Free;

require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/user/class-air-wp-sync-user-importer.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/user/destinations/class-air-wp-sync-user-destination.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/user/destinations/class-air-wp-sync-user-meta-destination.php';

/**
 * User Module
 *
 * @TODO: validate user login? (@see username_exists, validate_username, $illegal_logins = (array) apply_filters( 'illegal_user_logins', array() );
 */
class Air_WP_Sync_User_Module extends Air_WP_Sync_Abstract_Module {
	/** @var string Module slug */
	protected $slug = 'user';

	/** @var string Module name */
	protected $name = 'User';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles_scripts' ) );
		add_filter( 'airwpsync/get_l10n_strings', array( $this, 'add_l10n_strings' ) );
		add_action( 'airwpsync/register_destination', array( $this, 'register_destinations' ) );
		add_filter( 'airwpsync/mapping_validation_rules', array( $this, 'add_mapping_validation_rules' ), 10, 1 );
	}

	/**
	 * Register admin styles and scripts
	 */
	public function register_styles_scripts() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'airwpsync-connection' === $screen->id ) {
			wp_enqueue_script( 'air-wp-sync-user-hooks', plugins_url( 'modules/user/assets/js/hooks.js', AIR_WP_SYNC_PLUGIN_FILE ), array( 'air-wp-sync-admin' ), AIR_WP_SYNC_VERSION, false );
		}
	}

	/**
	 * Add module l10n strings
	 */
	public function add_l10n_strings( $l10n_strings ) {
		return array_merge(
			$l10n_strings,
			array(
				'requiredUserEmailErrorMessage' => __( 'It is mandatory to map the user e-mail address.', 'air-wp-sync' ),
				'requiredUserLoginErrorMessage' => __( 'It is mandatory to map the Username field.', 'air-wp-sync' ),
			)
		);
	}

	/**
	 * Render module settings
	 */
	public function render_settings( $post ) {
		include_once __DIR__ . '/views/settings.php';
	}

	/**
	 * Get importer instance
	 */
	public function get_importer_instance( $post ) {
		return new Air_Wp_Sync_User_Importer( $post, $this );
	}

	/**
	 * Register destinations
	 */
	public function register_destinations() {
		new Air_WP_Sync_User_Destination( new Air_WP_Sync_Markdown_Formatter( new Air_WP_Sync_Parsedown() ), new Air_WP_Sync_Interval_Formatter() );
		new Air_WP_Sync_User_Meta_Destination( new Air_WP_Sync_Markdown_Formatter( new Air_WP_Sync_Parsedown() ), new Air_WP_Sync_Attachments_Formatter() );
	}

	/**
	 * Add required email rule to mapping rules
	 */
	public function add_mapping_validation_rules( $rules ) {
		$rules[] = 'requiredUserEmail';
		$rules[] = 'requiredUserLogin';
		return $rules;
	}

	/**
	 * Get mapping options
	 */
	public function get_mapping_options() {
		return apply_filters( 'airwpsync/get_wp_fields', array(), $this->slug );
	}

	/**
	 * Get extra config
	 */
	public function get_extra_config() {
		return array(
			'foo' => 'bar',
		);
	}
}
