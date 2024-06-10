<?php

namespace Air_WP_Sync_Free;

/**
 * Markdown Formatter
 */
class Air_WP_Sync_Markdown_Formatter {
	/** @var Parsedown Parsedown instance */
	protected $parsedown;

	public function __construct( $parsedown ) {
		$this->parsedown = $parsedown;
	}

	/**
	 * Convert Markdown to HTML
	 */
	public function format( $value ) {
		// Fix double backslash esacaping
		$value = str_replace( '\_', '_', $value );
		$html  = $this->parsedown->setBreaksEnabled( true )->text( $value );
		return $html;
	}
}
