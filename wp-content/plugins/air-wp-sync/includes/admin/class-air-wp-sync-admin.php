<?php

namespace Air_WP_Sync_Free;

require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/class-air-wp-sync-admin-connections-list.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/class-air-wp-sync-admin-connection.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/metaboxes/class-air-wp-sync-metabox-field-mapping.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/metaboxes/class-air-wp-sync-metabox-global-settings.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/metaboxes/class-air-wp-sync-metabox-importer-settings.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/metaboxes/class-air-wp-sync-metabox-sync-settings.php';
require_once AIR_WP_SYNC_PLUGIN_DIR . 'includes/admin/metaboxes/class-air-wp-sync-metabox-import-infos.php';

/**
 * Admin
 */
class Air_WP_Sync_Admin {
	/**
	 * Constructor
	 */
	public function __construct( ) {

		add_action( 'admin_menu', array( $this, 'add_menu' ), 100 );
		add_action( 'in_admin_header', array( $this, 'in_admin_header' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles_scripts' ) );
		add_action( 'admin_notices', array( $this, 'add_notices' ) );

		add_filter( 'plugin_action_links_' . AIR_WP_SYNC_BASENAME, array( $this, 'plugin_action_links' ) );

		new Air_WP_Sync_Admin_Connections_List( );
		new Air_WP_Sync_Admin_Connection( );
	}

	/**
	 * Add menu
	 */
	public function add_menu() {
		add_menu_page(
			__( 'Air WP Sync', 'air-wp-sync' ),
			__( 'Air WP Sync', 'air-wp-sync' ),
			apply_filters( 'airwpsync/manage_options_capability', 'manage_options' ),
			'edit.php?post_type=airwpsync-connection',
			false,
			'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZpZXdCb3g9IjAgMCA0MyAzNiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CiAgICA8cGF0aCBkPSJNMTksMC40TDMuMSw3Yy0wLjksMC40LTAuOSwxLjYsMCwyTDE5LDE1LjNjMS40LDAuNiwzLDAuNiw0LjMsMEwzOS4zLDljMC45LTAuNCwwLjktMS42LDAtMkwyMy41LDAuNCBDMjItMC4xLDIwLjQtMC4xLDE5LDAuNCAiIGZpbGw9ImN1cnJlbnRDb2xvciIvPgogICAgPHBhdGggZD0iTTIyLjYsMTguN3YxNS43YzAsMC43LDAuOCwxLjMsMS41LDFsMTcuNy02LjkgYzAuNC0wLjIsMC43LTAuNiwwLjctMVYxMS44YzAtMC43LTAuOC0xLjMtMS41LTFsLTE3LjcsNi45QzIyLjksMTcuOSwyMi42LDE4LjMsMjIuNiwxOC43IiBmaWxsPSJjdXJyZW50Q29sb3IiLz4KICAgIDxwYXRoIGQ9Ik0xOC41LDE5LjVsLTUuMywyLjVsLTAuNSwwLjNMMS42LDI3LjYgQzAuOSwyOCwwLDI3LjUsMCwyNi43VjExLjljMC0wLjMsMC4xLTAuNSwwLjMtMC43QzAuNCwxMS4xLDAuNSwxMSwwLjYsMTFjMC4zLTAuMiwwLjYtMC4yLDEtMC4xbDE2LjgsNi43IEMxOS4zLDE3LjksMTkuMywxOS4xLDE4LjUsMTkuNSIgZmlsbD0iY3VycmVudENvbG9yIi8+Cjwvc3ZnPg=='
		);
		add_submenu_page(
			'edit.php?post_type=airwpsync-connection',
			__( 'All Connections', 'air-wp-sync' ),
			__( 'All Connections', 'air-wp-sync' ),
			apply_filters( 'airwpsync/manage_options_capability', 'manage_options' ),
			'edit.php?post_type=airwpsync-connection'
		);
		add_submenu_page(
			'edit.php?post_type=airwpsync-connection',
			__( 'Add New', 'air-wp-sync' ),
			__( 'Add New', 'air-wp-sync' ),
			apply_filters( 'airwpsync/manage_options_capability', 'manage_options' ),
			'post-new.php?post_type=airwpsync-connection'
		);
	}

	/**
	 * Display plugin header
	 */
	public function in_admin_header() {
		$screen = get_current_screen();
		if ( 'airwpsync-connection' === $screen->post_type ) {
			include_once AIR_WP_SYNC_PLUGIN_DIR . 'views/header.php';
		}
	}

	/**
	 * Register admin styles and scripts
	 */
	public function register_styles_scripts() {
		wp_enqueue_style( 'air-wp-sync-admin', plugins_url( 'assets/css/admin-page.css', AIR_WP_SYNC_PLUGIN_FILE ), false, AIR_WP_SYNC_VERSION );
	}

	/**
	 * Show action links on the plugin screen
	 */
	public function plugin_action_links( $links ) {
		return array_merge(
			$links,
			array(
				'upgrade'  => '<a href="https://wpconnect.co/air-wp-sync-plugin/" target="_blank"><b>' . esc_html__( 'Upgrade to pro version', 'air-wp-sync' ) . '</b></a>',
			)
		);
	}

	/**
	 * Add admin notices
	 */
	public function add_notices() {
		// Add notice if some importers have deprecated api keys
		$deprecated_key_importers = array_filter(
			Air_WP_Sync_Helper::get_importers(),
			function( $importer ) {
				return strpos( $importer->config()->get( 'api_key' ), 'key' ) === 0;
			}
		);

		if ( $deprecated_key_importers ) {
			$list    = array_map(
				function( $importer ) {
					return '<a href="' . get_edit_post_link( $importer->infos()->get( 'id' ) ) . '">' . get_the_title( $importer->infos()->get( 'id' ) ) . '</a>';
				},
				$deprecated_key_importers
			);
			$list    = implode( ', ', $list );
			/* translators: %s = list of connections using deprecated API keys */
			$message = sprintf( __( '<strong>Air WP Sync:</strong> The following connections use API Keys that will be deprecated. To benefit from all the features of our plugin in a more secure way, please use a personal access token instead: %s', 'air-wp-sync' ), $list );
			echo wp_kses(
				"<div class='notice notice-warning'><p>{$message}</p></div>",
				array(
					'div'    => array(
						'class' => array(),
					),
					'p'      => array(),
					'strong' => array(),
				)
			);
		}
	}
}
