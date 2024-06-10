<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
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
 * [Description Mo_API_Authentication_Custom_API_Integration]
 */
class Mo_API_Authentication_Custom_API_Integration {

	/**
	 * Internal redirect for Custom API Integration
	 *
	 * @return void
	 */
	public static function mo_api_authentication_customintegration() {
		self::custom_api_integration();
	}

	/**
	 * Custom API Integrations
	 *
	 * @return void
	 */
	public static function custom_api_integration() {

		?>
			<div id="mo_api_authentication_password_setting_layout" class="mo_api_authentication_support_layout">

				<div style="display: flex;">
					<div style="float: left"><h2 class="mo_third_part_intg_heading">Custom/Third Party Plugin API Authentication/Integrations</h2></div>
					<div style="float: left;margin: 10px;">
					<div class="mo_api_auth_inner_premium_label"><p>Premium</p></div>
					</div>
				</div>	

				<p style="font-size: 14px;font-weight: 400;padding-right: 10px;">The REST APIs of third-party plugin can be authenticated with the <b><i><a href="admin.php?page=mo_api_authentication_settings&tab=licensing" style="color:#a83262"><u>Protecting 3rd Party Plugin and
				Custom APIs Plan</u></a> </i> or <i><a href="admin.php?page=mo_api_authentication_settings&tab=licensing" style="color:#a83262"><u>All-Inclusive Plan</u></a></i></b>. Also any third-party application can also be integrated using the plugin via APIs. Contact us at <a href="mailto:apisupport@xecurify.com?subject=WP REST API Authentication Plugin - Enquiry"><b>apisupport@xecurify.com</b></a> to know more.</p>
				<br>

				<div class="mo_api_authentication_support_layout" style="padding-left: 5px;width: 90%">
					<br>
					<table cellpadding="4" cellspacing="4">

						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/woocommerce-circle.png'; ?>" width="50px"> </td>
							<td><h2> WooCommerce  </h2></td>
						</tr>
						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/buddypress.png'; ?>" width="50px"> </td>
							<td><h2> BuddyPress </h2></td>
						</tr>
						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/gravityform.jpg'; ?>" width="50px"> </td>
							<td><h2> Gravity Form </h2></td>
						</tr>
						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/learndash.png'; ?>" width="50px"> </td>
							<td><h2> Learndash API Endpoints </h2></td>
						</tr>
						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/cocart-icon.png'; ?>" width="50px"> </td>
							<td><h2> CoCart API Endpoints </h2></td>
						</tr>
						<tr>
							<td><input type="checkbox" disabled></td>
							<td> <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ) . '../../images/logo.png'; ?>" width="50px"> </td>
							<td><h2> Custom Built REST Endpoints in WordPress</h2></td>
						</tr>
					</table>
					<br>
				</div>
				<br>
			</div>

		<?php
	}
}
