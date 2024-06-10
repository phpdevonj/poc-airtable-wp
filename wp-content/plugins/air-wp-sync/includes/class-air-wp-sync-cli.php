<?php

namespace Air_WP_Sync_Free;

use WP_CLI;

class Air_WP_Sync_CLI {
	/**
	 * List importers
	 */
	public function list( $args, $assoc_args ) {
		$formatted_importers = array_map(
			function( $importer ) {
				return array(
					'slug'  => $importer->infos()->get( 'slug' ),
					'title' => $importer->infos()->get( 'title' ),
				);
			},
			Air_WP_Sync_Helper::get_importers()
		);

		$formatter = new WP_CLI\Formatter(
			$assoc_args,
			array(
				'slug',
				'title',
			)
		);

		$formatter->display_items( $formatted_importers );
	}

	/**
	 * Run importer by slug
	 */
	public function import( $args ) {
		if ( empty( $args[0] ) ) {
			WP_CLI::error( sprintf( 'Missing slug argument.' ) );
			return;
		}
		list ( $slug ) = $args;

		$importer = $this->get_importer_by_slug( $slug );
		if ( $importer ) {
			$start = microtime( true );
			WP_CLI::line( 'Running...' );
			$result            = $importer->run();
			$time_elapsed_secs = number_format( microtime( true ) - $start );

			if ( is_wp_error( $result ) ) {
				WP_CLI::error( sprintf( 'Error: "%s"', $result->get_error_message() ) );
			} else {
				WP_CLI::success( sprintf( 'Done in %ss.', $time_elapsed_secs ) );
			}
		} else {
			WP_CLI::error( sprintf( 'No connection with slug "%s"', $slug ) );
		}
	}

	/**
	 * Get importer instance by slug
	 */
	protected function get_importer_by_slug( $slug ) {
		return array_reduce(
			Air_WP_Sync_Helper::get_importers(),
			function( $result, $importer ) use ( $slug ) {
				return $importer->infos()->get( 'slug' ) === $slug ? $importer : $result;
			},
			false
		);
	}
}
