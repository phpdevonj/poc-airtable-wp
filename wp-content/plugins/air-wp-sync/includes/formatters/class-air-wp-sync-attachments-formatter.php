<?php

namespace Air_WP_Sync_Free;

use WP_Error;

/**
 * Attachments Formatter
 */
class Air_WP_Sync_Attachments_Formatter {
	/* @var Air_WP_Sync_Importer */
	protected $importer;

	/**
	 * Format source value
	 */
	public function format( $value, $importer, $post_id = null ) {
		$this->importer = $importer;

		if ( empty( $value ) ) {
			return array();
		}

		// Make sure we have an array of medias
		$medias         = ! is_array( $value ) ? array( $value ) : $value;
		$attachment_ids = array();
		foreach ( $medias as $media ) {
			$attachment_id = $this->get_object_id_from_record_id( $media->id, 'attachment' );
			if ( ! $attachment_id || $this->needs_update( $attachment_id, $media ) ) {
				$attachment_id = $this->import_media( $media, $post_id );
			}

			if ( false !== $attachment_id ) {
				$attachment_ids[] = $attachment_id;
			}
		}

		return $attachment_ids;
	}

	/**
	 * Import a media
	 */
	protected function import_media( $media, $post_id = null ) {
		$this->log( sprintf( '- Import media %s', $media->id ) );
		$media_metas = array(
			'_air_wp_sync_record_id'  => $media->id,
			'_air_wp_sync_hash'       => $this->generate_hash( $media ),
			'_air_wp_sync_updated_at' => gmdate( 'Y-m-d H:i:s' ),
		);
		// Check if media already exists
		$attachment_id = $this->get_object_id_from_record_id( $media->id, 'attachment' );
		// If not, create it
		if ( ! $attachment_id ) {
			$this->log( sprintf( '- Create media %s', $media->id ) );
			$media_data = array(
				'post_title'  => $media->filename,
				'post_author' => 0,
				'post_parent' => $post_id,
			);

			$filename = $media->filename;

			// Force file extension from type field
			if ( ! empty( $media->type ) ) {
				$new_filename = pathinfo( sanitize_file_name( $media->filename ), PATHINFO_FILENAME );
				$mime_to_ext  = apply_filters(
					'getimagesize_mimes_to_exts',
					array(
						'image/jpeg' => 'jpg',
						'image/png'  => 'png',
						'image/gif'  => 'gif',
						'image/bmp'  => 'bmp',
						'image/tiff' => 'tif',
						'image/webp' => 'webp',
					)
				);
				// Get file extension from type
				if ( ! empty( $mime_to_ext[ $media->type ] ) ) {
					$extension = $mime_to_ext[ $media->type ];
					$filename  = "$new_filename.$extension";
				}
			}
			$result = $this->fetch_media( $media->url, $filename, null, $media_data );
			if ( is_wp_error( $result ) ) {
				$this->log( sprintf( '- ERROR: %s', $result->get_error_message() ) );
			} else {
				$this->log( sprintf( '- Success media %s', $result ) );
				$attachment_id = $result;
			}
		}
		if ( $attachment_id ) {
			// Add media metas
			foreach ( $media_metas as $meta_key => $meta_value ) {
				update_post_meta( $attachment_id, $meta_key, $meta_value );
			}
		}
		return (int) $attachment_id;
	}

	/**
	 * Fetch a media using WP core functions
	 */
	protected function fetch_media( $url, $filename = null, $desc = null, $post_data = array(), $post_meta = array() ) {
		require_once ABSPATH . 'wp-admin/includes/admin.php';

		if ( empty( $url ) || ! wp_http_validate_url( $url ) ) {
			return new WP_Error( 'air_wp_sync_fetch_media_invalid_url', 'Invalid URL.' );
		}

		$attachment_id = false;

		// Download file to temp location
		$temp_file = download_url( $url );

		if ( empty( $filename ) ) {
			$filename = basename( urldecode( $url ) );
		}

		// Try to guess file extension from type field
		if ( ! pathinfo( $filename, PATHINFO_EXTENSION ) ) {
			$mime_to_ext = apply_filters(
				'getimagesize_mimes_to_exts',
				array(
					'image/jpeg' => 'jpg',
					'image/png'  => 'png',
					'image/gif'  => 'gif',
					'image/bmp'  => 'bmp',
					'image/tiff' => 'tif',
					'image/webp' => 'webp',
				)
			);
			// Get file mimie type
			$mime_type = wp_get_image_mime( $temp_file );
			// Get file extension from it
			if ( ! empty( $mime_to_ext[ $mime_type ] ) ) {
				$extension = $mime_to_ext[ $mime_type ];
				$filename .= ".$extension";
			}
		}

		$file_data = array(
			'name'     => $filename,
			'tmp_name' => $temp_file,
		);

		if ( is_wp_error( $file_data['tmp_name'] ) ) {
			return $file_data['tmp_name'];
		}
		// Let WP handle this
		$result = media_handle_sideload( $file_data, 0, $desc, $post_data );

		if ( is_wp_error( $result ) ) {
			wp_delete_file( $file_data['tmp_name'] );
			return $result;
		}

		$attachment_id = $result;
		foreach ( $post_meta as $meta_key => $meta_value ) {
			update_post_meta( $attachment_id, $meta_key, $meta_value );
		}
		return $attachment_id;
	}

	/**
	 * Get WP object id from AT record id
	 */
	protected function get_object_id_from_record_id( $record_id, $post_type ) {
		$objects = get_posts(
			array(
				'fields'      => 'ids',
				'post_type'   => $post_type,
				'post_status' => 'any',
				'meta_query'  => array(
					array(
						'key'   => '_air_wp_sync_record_id',
						'value' => $record_id,
					),
				),
			)
		);
		return array_shift( $objects );
	}

	/**
	 * Compare hashes to check if WP object needs update
	 */
	protected function needs_update( $post_id, $record ) {
		return $this->generate_hash( $record ) !== $this->get_post_hash( $post_id );
	}

	/**
	 * Get stored post hash
	 */
	protected function get_post_hash( $post_id ) {
		return get_post_meta( $post_id, '_air_wp_sync_hash', true );
	}

	/**
	 * Generate hash for given Airtable record
	 */
	protected function generate_hash( $record ) {
		return md5( wp_json_encode( $record ) );
	}

	/**
	 * Log
	 */
	protected function log( $message, $level = 'log' ) {
		if ( $this->importer ) {
			$this->importer->log( $message, $level );
		}
	}
}
