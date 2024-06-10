<?php

namespace Air_WP_Sync_Free;

require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/class-air-wp-sync-post-helpers.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/class-air-wp-sync-post-importer.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/destinations/class-air-wp-sync-post-destination.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/destinations/class-air-wp-sync-post-meta-destination.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'modules/post/destinations/class-air-wp-sync-taxonomy-destination.php';

/**
 * Post Module
 */
class Air_WP_Sync_Post_Module extends Air_WP_Sync_Abstract_Module {
	/** @var string Module slug */
	protected $slug = 'post';

	/** @var string Module name */
	protected $name = 'Post';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles_scripts' ) );
		add_filter( 'airwpsync/get_l10n_strings', array( $this, 'add_l10n_strings' ) );
		add_action( 'airwpsync/register_destination', array( $this, 'register_destinations' ) );
		add_action( 'airwpsync/connections_list_type_column', array( $this, 'connections_list_type_column' ) );
	}

	public function connections_list_type_column( $importer ) {
		if ( $importer->get_module() === $this ) {
			$post_type        = $importer->get_post_type();
			$post_type_object = get_post_type_object( $post_type );
			if ( $post_type_object ) {
				echo '<br>';
				echo esc_html__( 'Importing as: ', 'air-wp-sync' );
				$menu_icon = $post_type_object->menu_icon ? $post_type_object->menu_icon : 'dashicons-admin-post';
				echo '<span class="dashicons ' . esc_attr( $menu_icon ) . '"></span> ';
				echo esc_html( $post_type_object->labels->name );
			}
		}
	}

	/**
	 * Register admin styles and scripts
	 */
	public function register_styles_scripts() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'airwpsync-connection' === $screen->id ) {
			wp_enqueue_script( 'air-wp-sync-post-hooks', plugins_url( 'modules/post/assets/js/hooks.js', AIR_WP_SYNC_PLUGIN_FILE ), array( 'air-wp-sync-admin' ), AIR_WP_SYNC_VERSION, false );
		}
	}

	/**
	 * Add module l10n strings
	 */
	public function add_l10n_strings( $l10n_strings ) {
		return array_merge(
			$l10n_strings,
			array(
				'deleteActionConfirmation'   => __( 'You have a Custom Post Type declared using this connection. Are you sure to delete it?', 'air-wp-sync' ),
				'slugErrorMessage'           => __( 'Only lowercase alphanumeric characters, dashes, and underscores are allowed.', 'air-wp-sync' ),
				'allowedCptSlugErrorMessage' => __( 'This slug is already in use, please choose another.', 'air-wp-sync' ),
			)
		);
	}

	/**
	 * Render module settings
	 */
	public function render_settings( $post ) {
		$importer     = Air_WP_Sync_Helper::get_importer_by_id( $post->ID );
		$post_types   = array_filter(
			Air_WP_Sync_Post_Helpers::get_post_types(),
			function( $post_type ) use ( $importer ) {
				return ! $importer || ( $importer->config()->get( 'post_type' ) !== 'custom' || $importer->config()->get( 'post_type_name' ) !== $post_type['value'] );
			}
		);
		$post_stati   = Air_WP_Sync_Post_Helpers::get_post_stati();
		$post_authors = Air_WP_Sync_Post_Helpers::get_post_authors();
		include_once __DIR__ . '/views/settings.php';
	}


	/**
	 * Get importer instance
	 */
	public function get_importer_instance( $post ) {
		return new Air_Wp_Sync_Post_Importer( $post, $this );
	}

	/**
	 * Register destinations
	 */
	public function register_destinations() {
		new Air_WP_Sync_Post_Destination( new Air_WP_Sync_Markdown_Formatter( new Air_WP_Sync_Parsedown() ), new Air_WP_Sync_Interval_Formatter() );
		new Air_WP_Sync_Post_Meta_Destination( new Air_WP_Sync_Markdown_Formatter( new Air_WP_Sync_Parsedown() ), new Air_WP_Sync_Attachments_Formatter() );
		new Air_WP_Sync_Taxonomy_Destination( new Air_WP_Sync_Markdown_Formatter( new Air_WP_Sync_Parsedown() ), new Air_WP_Sync_Terms_Formatter(), new Air_WP_Sync_Interval_Formatter() );
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
			'reservedCptSlugs'   => $this->get_reserved_cpt_slugs(),
			'featuresByPostType' => $this->get_features_by_post_type(),
		);
	}

	/**
	 * Get reserved CPT slugs
	 */
	protected function get_reserved_cpt_slugs() {
		return array_values( get_post_types() );
	}

	/**
	 * Get available features by post type
	 */
	protected function get_features_by_post_type() {
		$features = array();
		foreach ( Air_WP_Sync_Post_Helpers::get_post_types() as $post_type ) {
			$features[ $post_type['value'] ] = apply_filters(
				'airwpsync/features_by_post_type',
				array(),
				$post_type['value']
			);
		}
		// Default features for custom post type
		$features['custom'] = array(
			'post' => array(
				'post_name',
				'post_date',
				'post_title',
				'post_excerpt',
				'post_content',
			),
			'meta' => array(
				'_thumbnail_id',
				'custom_field',
			),
		);
		return $features;
	}
}
