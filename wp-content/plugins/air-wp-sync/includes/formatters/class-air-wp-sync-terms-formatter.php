<?php

namespace Air_WP_Sync_Free;

/**
 * Terms Formatter
 */
class Air_WP_Sync_Terms_Formatter {
	/* @var Air_WP_Sync_Importer */
	protected $importer;

	/**
	 * Format source value
	 */
	public function format( $value, $importer, $taxonomy ) {
		$this->importer = $importer;

		if ( is_null( $value ) ) {
			return array();
		}

		// Make sure we have an array of terms
		$values = ! is_array( $value ) ? array( $value ) : $value;

		$terms = array();
		foreach ( $values as $value ) {
			$value = wp_strip_all_tags( $value );
			$term  = term_exists( $value, $taxonomy );
			if ( 0 === $term || null === $term ) {
				$term = wp_insert_term( $value, $taxonomy );
			}

			if ( is_wp_error( $term ) ) {
				$this->log( sprintf( '- Cannot get term \'%s\' (taxonomy: \'%s\'), error: %s', $value, $taxonomy, $term->get_error_message() ) );
			} else {
				$terms[] = (int) $term['term_id'];
			}
		}
		return $terms;
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
