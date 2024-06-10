<?php

namespace Air_WP_Sync_Free;

use WP_CLI;

/**
 * Plugin Main class
 */

class Air_WP_Sync {
	/** @var array Available importers */
	protected $importers = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 100 );
		add_filter( 'cron_schedules', array( $this, 'add_cron_schedules' ), 100 );
		add_action( 'activated_plugin', array( $this, 'deactivate_other_instances' ) );
		add_action( 'pre_current_active_plugins', array( $this, 'plugin_deactivated_notice' ) );
		add_filter( 'airwpsync/get_importers', array( $this, 'get_importers' ) );
	}

	/**
	 * Init plugin
	 */
	public function init() {
		$this->load_textdomain();
		$this->setup();

		// Init Modules
		new Air_WP_Sync_Post_Module();
		new Air_WP_Sync_User_Module();

		$this->load_importers();

		// Admin
		if ( is_admin() ) {
			new Air_WP_Sync_Admin( );
		}

		// Initalize WP_CLI only in cli mode
		if ( class_exists( 'WP_CLI' ) ) {
			WP_CLI::add_command( 'air-wp-sync', new Air_WP_Sync_CLI( ) );
		}

		new Air_WP_Sync_Action_Consumer( );

		// Init Sources
		new Air_WP_Sync_Barcode_Source();
		new Air_WP_Sync_Collaborator_Source();
		new Air_WP_Sync_Link_To_Another_Record_Source();
		new Air_WP_Sync_Formula_Source();
		new Air_WP_Sync_Unsupported_Source();

		// Init Destinations with Formatters
		do_action( 'airwpsync/register_destination' );
	}

	/**
	 * Checks if another version of Air WP Sync free/pro is active and deactivates it.
	 * Hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
	 *
	 * @param string $plugin The plugin being activated.
	 */
	public function deactivate_other_instances( $plugin ) {
		if ( ! in_array( $plugin, array( 'air-wp-sync/air-wp-sync.php', 'air-wp-sync-pro/air-wp-sync.php', 'air-wp-sync-pro-plus/air-wp-sync.php' ), true ) ) {
			return;
		}

		$plugin_to_deactivate  = ['air-wp-sync/air-wp-sync.php'];
		$deactivated_notice_id = '1';

		// If we just activated the free version, deactivate the pro version.
		if ( in_array($plugin, $plugin_to_deactivate, true ) ) {
			$plugin_to_deactivate  = ['air-wp-sync-pro/air-wp-sync.php', 'air-wp-sync-pro-plus/air-wp-sync.php'];
			$deactivated_notice_id = '2';
		}

		if ( is_multisite() && is_network_admin() ) {
			$active_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
			$active_plugins = array_keys( $active_plugins );
		} else {
			$active_plugins = (array) get_option( 'active_plugins', array() );
		}

		foreach ( $active_plugins as $plugin_basename ) {
			if ( in_array($plugin_basename, $plugin_to_deactivate, true ) ) {
				set_transient( 'airwpsync_deactivated_notice_id', $deactivated_notice_id, 1 * HOUR_IN_SECONDS );
				deactivate_plugins( $plugin_basename );
				return;
			}
		}
	}

	/**
	 * Displays a notice when either ACF or ACF PRO is automatically deactivated.
	 */
	public function plugin_deactivated_notice() {
		$deactivated_notice_id = (int) get_transient( 'airwpsync_deactivated_notice_id' );
		if ( ! in_array( $deactivated_notice_id, array( 1, 2 ), true ) ) {
			return;
		}

		$message = __( "Air WP Sync and Air WP Sync Pro should not be active at the same time. We've automatically deactivated Air WP Sync.", 'air-wp-sync' );
		if ( 2 === $deactivated_notice_id ) {
			$message = __( "Air WP Sync and Air WP Sync Pro should not be active at the same time. We've automatically deactivated Air WP Sync Pro.", 'air-wp-sync' );
		}

		?>
		<div class="notice notice-warning">
			<p><?php echo esc_html( $message ); ?></p>
		</div>
		<?php

		delete_transient( 'airwpsync_deactivated_notice_id' );
	}

	/**
	 * Load translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'air-wp-sync', false, dirname( AIR_WP_SYNC_BASENAME ) . '/languages' );
	}

	/**
	 * Add custom cron schedules
	 */
	public function add_cron_schedules( $schedules ) {
		return array_merge(
			$schedules,
			array(
				'airwpsync_fiveminutes'   => array(
					'interval' => 300,
					'display'  => __( 'Every 5 minutes', 'air-wp-sync' ),
				),
				'airwpsync_tenminutes'    => array(
					'interval' => 600,
					'display'  => __( 'Every 10 minutes', 'air-wp-sync' ),
				),
				'airwpsync_thirtyminutes' => array(
					'interval' => 1800,
					'display'  => __( 'Every 30 minutes', 'air-wp-sync' ),
				),
			)
		);
	}

	/**
	 * Importers getter
	 */
	public function get_importers() {
		return $this->importers;
	}

	/**
	 * Plugin Setup
	 */
	protected function setup() {
		register_post_type(
			'airwpsync-connection',
			array(
				'labels'          => array(
					'name'               => __( 'Connections', 'air-wp-sync' ),
					'singular_name'      => __( 'Connection', 'air-wp-sync' ),
					'add_new'            => __( 'Add New', 'air-wp-sync' ),
					'add_new_item'       => __( 'Add New Connection', 'air-wp-sync' ),
					'edit_item'          => __( 'Edit Connection', 'air-wp-sync' ),
					'new_item'           => __( 'New Connection', 'air-wp-sync' ),
					'view_item'          => __( 'View Connection', 'air-wp-sync' ),
					'search_items'       => __( 'Search Connections', 'air-wp-sync' ),
					'not_found'          => __( 'No Connections found', 'air-wp-sync' ),
					'not_found_in_trash' => __( 'No Connections found in Trash', 'air-wp-sync' ),
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'_builtin'        => false,
				'capability_type' => 'post',
				'supports'        => array( 'title' ),
				'rewrite'         => false,
				'query_var'       => false,
			)
		);
	}

	/**
	 * Load available importers
	 */
	protected function load_importers() {
        $post_statuses = is_admin() ? array( 'publish', 'draft' ) : array( 'publish' );
		$importer_posts = get_posts(
			array(
				'post_type'      => 'airwpsync-connection',
				'post_status'    => $post_statuses,
				'posts_per_page' => -1,
			)
		);

		foreach ( $importer_posts as $importer_post ) {
			$module_slug = Air_WP_Sync_Helper::get_importer_module( $importer_post );
			$module      = Air_WP_Sync_Helper::get_module_by_slug( $module_slug );
			if ( $module ) {
				$this->importers[] = $module->get_importer_instance( $importer_post );
			}
		}
	}

}
