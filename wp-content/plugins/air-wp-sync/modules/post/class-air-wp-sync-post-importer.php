<?php

namespace Air_WP_Sync_Free;

/**
 * Importer
 */
class Air_WP_Sync_Post_Importer extends Air_WP_Sync_Abstract_Importer {
	/**
	 * Init
	 */
	protected function init() {
		if ( $this->config()->get( 'post_type' ) === 'custom' ) {
			$this->register_post_type();
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function load_settings( $importer_post_object ) {
		parent::load_settings( $importer_post_object );

		// Update WordPress destination with new keys (Modules update).
		if ($this->config->get('mapping')) {
			$this->config->set('mapping', array_map(function ($mapping) {
				if ('meta::custom_field' === $mapping['wordpress']) {
					$mapping['wordpress'] = 'postmeta::custom_field';
				} elseif ('meta::_thumbnail_id' === $mapping['wordpress']) {
					$mapping['wordpress'] = 'postmeta::_thumbnail_id';
				}
				return $mapping;
			}, $this->config->get('mapping')));
		}

	}

	/**
	 * Register associated post type
	 */
	protected function register_post_type() {
		$cpt_slug = sanitize_key( $this->config()->get( 'post_type_slug' ) );
		$cpt_name = $this->config()->get( 'post_type_name' );

		if ( $cpt_slug && $cpt_name ) {
			register_post_type(
				$cpt_slug,
				array(
					'labels'   => array(
						'name'          => $cpt_name,
						'singular_name' => $cpt_name,
					),
					'public'   => true,
					'supports' => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'custom-fields' ),
					'rewrite'  => array(
						'slug'       => $cpt_slug,
						'with_front' => false,
					),
				)
			);
		}
	}

	/**
	 * Delete other content existing in WP but deleted in AT
	 */
	public function delete_removed_contents() {
		if ( 'add_update_delete' !== $this->config()->get( 'sync_strategy' ) ) {
			return;
		}

		$content_ids = get_post_meta( $this->infos()->get( 'id' ), 'content_ids', true ) ?: array();
		if ( ! is_array( $content_ids ) ) {
			$content_ids = array();
		}

		$posts = get_posts(
			array(
				'post_type'      => $this->get_post_type(),
				'post_status'    => 'any',
				'post__not_in'   => $content_ids,
				'fields'         => 'ids',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'relation' => 'OR',
						array(
							'key'   => '_air_wp_sync_importer_id',
							'value' => $this->infos()->get( 'id' ),
						),
						array(
							'key'     => '_air_wp_sync_importer_id',
							'compare' => 'NOT EXISTS',
						),
					),
					array(
						'key'     => '_air_wp_sync_record_id',
						'compare' => 'EXISTS',
					),
				),
			)
		);
		foreach ( $posts as $post_id ) {
			wp_delete_post( $post_id, true );
		}
	}

	/**
	 * Import record
	 */
	protected function import_record( $record, $post_id = null ) {
		$this->log( sprintf( $post_id ? '- Update record %s' : '- Create record %s', $record->id ) );

		$record = apply_filters( 'airwpsync/import_record_data', $record, $this );
		$fields = $this->get_mapped_fields( $record );

		$post_data = array(
			'post_type'  => $this->get_post_type(),
			'post_title' => 'Airtable Imported Content',
		);

		$post_metas = array(
			'_air_wp_sync_record_id'   => $record->id,
			'_air_wp_sync_hash'        => $this->generate_hash( $record ),
			'_air_wp_sync_importer_id' => $this->infos()->get( 'id' ),
			'_air_wp_sync_updated_at'  => gmdate( 'Y-m-d H:i:s' ),
		);

		$post_data = apply_filters( 'airwpsync/import_post_data', $post_data, $this, $fields, $record, $post_id );

		if ( empty( $post_data['post_author'] ) ) {
			$post_data['post_author'] = $this->config()->get( 'post_author' );
		}
		if ( empty( $post_data['post_status'] ) ) {
			$post_data['post_status'] = $this->config()->get( 'post_status' );
		}

		// Insert or update post
		if ( $post_id ) {
			$post_id = wp_update_post( array_merge( array( 'ID' => $post_id ), $post_data ), true );
		} else {
			$post_id = wp_insert_post( $post_data, true );
		}

		if ( is_wp_error( $post_id ) ) {
			throw new \Exception( $post_id->get_error_message() );
		}

		// Handle metas
		foreach ( $post_metas as $meta_key => $meta_value ) {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}

		do_action( 'airwpsync/import_record_after', $this, $fields, $record, $post_id );

		// Force wp_insert_post retrigger after metas
		do_action( 'wp_insert_post', $post_id, get_post( $post_id ), true );

		return $post_id;
	}

	/**
	 * Get existing content id
	 */
	protected function get_existing_content_id( $record ) {
		$objects = get_posts(
			array(
				'fields'      => 'ids',
				'post_type'   => $this->get_post_type(),
				'post_status' => 'any',
				'meta_query'  => array(
					array(
						'relation' => 'OR',
						array(
							'key'   => '_air_wp_sync_importer_id',
							'value' => $this->infos()->get( 'id' ),
						),
						array(
							'key'     => '_air_wp_sync_importer_id',
							'compare' => 'NOT EXISTS',
						),
					),
					array(
						'key'   => '_air_wp_sync_record_id',
						'value' => $record->id,
					),
				),
			)
		);
		return array_shift( $objects );
	}

	/**
	 * Get existing content hash
	 */
	protected function get_existing_content_hash( $content_id ) {
		return get_post_meta( $content_id, '_air_wp_sync_hash', true );
	}

	/**
	 * Post Type getter
	 */
	public function get_post_type() {
		return $this->config()->get( 'post_type' ) === 'custom' ? $this->config()->get( 'post_type_slug' ) : $this->config()->get( 'post_type' );
	}
}
