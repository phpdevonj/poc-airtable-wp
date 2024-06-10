<?php

namespace Air_WP_Sync_Free;

/**
 * Admin Connection
 */
class Air_WP_Sync_Admin_Connection {

	/** @var bool Whether we should display max connection notice */
	protected $display_max_connection = false;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add_meta_boxes();

		add_action( 'edit_form_top', array( $this, 'add_header' ) );
		add_action( 'dbx_post_sidebar', array( $this, 'add_footer' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles_scripts' ) );
		add_filter( 'script_loader_tag', array( $this, 'add_alpine_defer_attribute' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );
		add_action( 'wp_insert_post_data', array( $this, 'wp_insert_post_data' ), 10, 2 );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_post_updated_messages' ), 10, 2 );
		add_filter( 'redirect_post_location', array( $this, 'redirect_post_location' ), 10, 2 );
		add_action( 'admin_notices', array( $this, 'admin_notices' ), 10 );

	}

	/**
	 * Output wrapper opening for alpinejs x-data
	 */
	public function add_header() {
		if ( 'airwpsync-connection' === get_post_type() ) {
			echo '<div id="airwpsync-alpine-container" x-data="airWpSyncSettingsHandler" @focusout="change" @input="change" @validate="submit">';
			echo '<div id="airwpsync-validation-notice" class="notice notice-error" style="display:none"><p><strong>' . esc_html__( 'Error:', 'air-wp-sync' ) . '</strong> ' . esc_html__( 'One or more fields have an error. Please check and try again.', 'air-wp-sync' ) . '</p></div>';
		}
	}

	/**
	 * Output wrapper closing for alpinejs x-data
	 */
	public function add_footer() {
		if ( 'airwpsync-connection' === get_post_type() ) {
			echo '</div>';
		}
	}

	/**
	 * Register admin styles and scripts
	 */
	public function register_styles_scripts() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'airwpsync-connection' === $screen->id ) {
			wp_enqueue_script( 'air-wp-sync-alpine', plugins_url( 'assets/js/alpinejs@3.10.2.min.js', AIR_WP_SYNC_PLUGIN_FILE ), false, AIR_WP_SYNC_VERSION, false );
			wp_enqueue_script( 'air-wp-sync-admin', plugins_url( 'assets/js/admin-page.js', AIR_WP_SYNC_PLUGIN_FILE ), array( 'air-wp-sync-alpine', 'jquery-ui-tooltip', 'wp-hooks' ), AIR_WP_SYNC_VERSION, false );
			wp_add_inline_script( 'air-wp-sync-admin', 'var airwpsyncImporterData = ' . $this->get_config(), 'before' );
			wp_add_inline_script( 'air-wp-sync-admin', 'var airWpSync = ' . $this->get_modules_config(), 'before' );
			wp_localize_script( 'air-wp-sync-admin', 'airWpSyncL10n', $this->get_l10n_strings() );
			wp_enqueue_script( 'air-wp-sync-admin-metabox-mapping', plugins_url( 'assets/js/metabox-mapping/main.js', AIR_WP_SYNC_PLUGIN_FILE ), array( 'air-wp-sync-admin' ), AIR_WP_SYNC_VERSION, false );
		}
	}

	/**
	 * Add defer attribute to AlpineJS script
	 */
	public function add_alpine_defer_attribute( $tag, $handle ) {
		if ( 'air-wp-sync-alpine' === $handle ) {
			$tag = str_replace( ' src', ' defer="defer" src', $tag );
		}
		return $tag;
	}

	/**
	 * Add metaboxes for importer post type
	 */
	public function add_meta_boxes() {
		new Air_WP_Sync_Metabox_Global_Settings();
		new Air_WP_Sync_Metabox_Importer_Settings();
		new Air_WP_Sync_Metabox_Field_Mapping();
		new Air_WP_Sync_Metabox_Sync_Settings();
		new Air_WP_Sync_Metabox_Import_Infos();
	}

	/**
	 * After importer is saved
	 */
	public function save_post( $post_id, $post, $update ) {
		if ( ! $update || wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || 'airwpsync-connection' !== $post->post_type ) {
			return;
		}

		// FLush rewrite rules
		delete_option( 'rewrite_rules' );

		// Clear schedule
		wp_clear_scheduled_hook( 'air_wp_sync_importer_' . $post_id );
	}

	/**
	 * Before importer is saved
	 */
	public function wp_insert_post_data( $data, $postarr ) {
		if ( 'airwpsync-connection' !== $postarr['post_type'] ) {
			return $data;
		}

		// Limit active importers
		$post_id = $postarr['ID'] ?? 0;

		if ( ! isset( $data['post_status'] ) || $data['post_status'] === 'publish' ) {
			$importers = get_posts(
				array(
					'post_type'      => 'airwpsync-connection',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'post__not_in'   => array( $post_id ),
				)
			);
			if ( count( $importers ) > 0 ) {
				$data['post_status']          = 'draft';
				$this->display_max_connection = true;
			}
		}

		// Update slug
		if ( array_key_exists( 'post_title', $data ) ) {
			$data['post_name'] = sanitize_title( $data['post_title'] );
		}

		return $data;
	}

	/**
	 * Customize connections update messages
	 */
	public function post_updated_messages( $messages ) {
		$back_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( admin_url( 'edit.php?post_type=airwpsync-connection' ) ),
			__( 'Back to list', 'air-wp-sync' )
		);

		$messages['airwpsync-connection'] = array_replace(
			$messages['post'],
			array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Connection updated.', 'air-wp-sync' ) . $back_link_html,
				4  => __( 'Connection updated.', 'air-wp-sync' ),
				6  => __( 'Connection published.', 'air-wp-sync' ),
				7  => __( 'Connection saved.', 'air-wp-sync' ),
				10 => __( 'Connection draft updated.', 'air-wp-sync' ),
			)
		);

		return $messages;
	}

	/**
	 * Customize connections bulk update messages
	 */
	public function bulk_post_updated_messages( $messages, $bulk_counts ) {
		$messages['airwpsync-connection'] = array_replace(
			$messages['post'],
			array(
				/* translators: %s: Number of connections. */
				'updated'   => _n( '%s connection updated.', '%s connections updated.', $bulk_counts['updated'], 'air-wp-sync' ),
				'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 connection not updated, somebody is editing it.', 'air-wp-sync' ) :
					/* translators: %s: Number of connections. */
					_n( '%s connection not updated, somebody is editing it.', '%s connections not updated, somebody is editing them.', $bulk_counts['locked'], 'air-wp-sync' ),
				/* translators: %s: Number of connections. */
				'deleted'   => _n( '%s connection permanently deleted.', '%s connections permanently deleted.', $bulk_counts['deleted'], 'air-wp-sync' ),
				/* translators: %s: Number of connections. */
				'trashed'   => _n( '%s connection moved to the Trash.', '%s connections moved to the Trash.', $bulk_counts['trashed'], 'air-wp-sync' ),
				/* translators: %s: Number of connections. */
				'untrashed' => _n( '%s connection restored from the Trash.', '%s connections restored from the Trash.', $bulk_counts['untrashed'], 'air-wp-sync' ),
			)
		);

		return $messages;
	}

	/**
	 * Get connection config
	 */
	protected function get_config() {
		global $post;
		$importer = Air_WP_Sync_Helper::get_importer_by_id($post->ID);
		return $importer ? wp_json_encode( $importer->config() ) : '{}';
	}

	/**
	 * Get modules config
	 */
	protected function get_modules_config() {
		$config = array_map(
			function( $module ) {
				return array(
					'mappingOptions' => $module->get_mapping_options(),
					'extraConfig'    => $module->get_extra_config(),
				);
			},
			Air_WP_Sync_Helper::get_modules()
		);
		return wp_json_encode( $config );
	}

	/**
	 * Get localization strings
	 */
	protected function get_l10n_strings() {
		$l10n_strings = array(
			'startingUpdate' => __( 'In progress...', 'air-wp-sync' ),
			'canceling'      => __( 'Canceling...', 'air-wp-sync' ),
		);
		return apply_filters( 'airwpsync/get_l10n_strings', $l10n_strings );
	}


	/**
	 * Add display max connection parameter to location url
	 */
	public function redirect_post_location( $location, $post_id ) {
		if ( $this->display_max_connection ) {
			$location = add_query_arg( 'display_max_connection', 1, $location );
			$location = remove_query_arg( 'message', $location );
		}
		return $location;
	}

	/**
	 * Display max connection mesage if parameter was added
	 */
	public function admin_notices() {
		// phpcs:ignore
		if ( ! empty( $_GET['display_max_connection'] ) && '1' === $_GET['display_max_connection'] ) {
			printf(
				'<div class="%1$s"><p>%2$s</p></div>',
				esc_attr( 'notice notice-error' ),
				wp_kses(
					__( 'Thank you for using the Free Version of our plugin! You already have an active connection. To be able to create as many active connections as you want, <a href="https://wpconnect.co/air-wp-sync-plugin/#pricing-plan" target="_blank">Upgrade to Pro Version</a>.', 'air-wp-sync' ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					)
				)
			);
		}
	}

}
