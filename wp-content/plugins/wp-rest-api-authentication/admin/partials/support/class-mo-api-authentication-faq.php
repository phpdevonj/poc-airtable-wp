<?php
/**
 * FAQ
 * Redirect users to FAQ page.
 *
 * @package    Miniorange_Api_Authentication
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * FAQ section
 */
class Mo_API_Authentication_FAQ {

	/**
	 * Internal redirect to display FAQ section.
	 *
	 * @return void
	 */
	public static function mo_api_authentication_admin_faq() {
		self::faq_page();
	}

	/**
	 * FAQ page.
	 *
	 * @return void
	 */
	public static function faq_page() {
		?>
			<div class="mo_table_layout">
				<object type="text/html" data="https://faq.miniorange.com/kb/" width="100%" height="600px" > 
				</object>
			</div>
		<?php
	}
}
