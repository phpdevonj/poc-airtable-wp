<?php

namespace Air_WP_Sync_Free;

/**
 * Helper functions
 */
class Air_WP_Sync_Helper {
	/**
	 * Get properly formatted date for WP, with locale and timezone
	 */
	public static function get_formatted_date_time( $datetime ) {
		return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), is_int( $datetime ) ? $datetime : strtotime( $datetime ) );
	}

	/**
	 * Get importer instance from id
	 *
	 * @return Air_WP_Sync_Abstract_Importer|false
	 */
	public static function get_importer_by_id( $id ) {
		return array_reduce(
			self::get_importers(),
			function( $result, $importer ) use ( $id ) {
				return $importer->infos()->get( 'id' ) === (int) $id ? $importer : $result;
			},
			false
		);
	}

	/**
	 * Get modules
	 */
	public static function get_modules() {
		return apply_filters( 'airwpsync/get_modules', array() );
	}

	/**
	 * Get module by slug
	 */
	public static function get_module_by_slug( $slug ) {
		return self::get_modules()[ $slug ] ?? null;
	}

	/**
	 * Get importers
	 */
	public static function get_importers() {
		return apply_filters( 'airwpsync/get_importers', array() );
	}

	/**
	 * Get module from importer post object
	 */
	public static function get_importer_module( $importer_post_object ) {
		$config = json_decode( $importer_post_object->post_content, true );
		return $config['module'] ?? 'post';
	}

	/**
	 * Get table from id.
	 *
	 * @param array $tables
	 * @param string $table_id
	 *
	 * @return \stdClass|null
	 */
	public static function get_table_by_id($tables, $table_id) {
		$table  = null;

		if ( $tables ) {
			foreach ( $tables as $t ) {
				if ( $t->id === $table_id ) {
					$table = $t;
					break;
				}
			}
		}

		return $table;
	}
}
