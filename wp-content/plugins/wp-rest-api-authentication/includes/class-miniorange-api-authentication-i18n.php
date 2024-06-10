<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    Miniorange_Api_Authentication
 */
class Miniorange_Api_Authentication_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'miniorange-api-authentication',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
