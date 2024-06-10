<?php
/**
 * Protected REST APIs
 * This file will display the UI to whitelist/protect the WP REST API endpoints.
 *
 * @package    protected-rest-api
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [Protected REST APIs]
 */
class Mo_API_Authentication_ProtectedRestAPIs {

	/**
	 * Internal redirect to display protected REST API endpoints.
	 *
	 * @return void
	 */
	public static function mo_api_authentication_protected_restapis() {
		self::protect_wp_rest_apis();
	}

	/**
	 * Display protected REST API endpoints.
	 *
	 * @return void
	 */
	public static function protect_wp_rest_apis() {
		$democss = 'width: 350px; height:35px;';
		?>
			<style>
				#protectedrestapi_container ul li {
					padding-left: 20px;
				}

				#protectedrestapi_container em {
					font-size: 0.8em;
				}
			</style>

			<script>
				function protectedrestapi_namespace_click(namespace, id) {
					if (jQuery('#protectedrestapi_namespace_' + id).is(":checked")) {
						jQuery("input[data-namespace='" + namespace + "']").prop('checked', true);
					} else {
						jQuery("input[data-namespace='" + namespace + "']").prop('checked', false);
					}
				};
			</script>

			<div id="mo_api_authentication_password_setting_layout" class="mo_api_authentication_support_layout"> 
					<form method="post" action="" id="ProtectedRestAPI_form">
					<button type="button" style="width:70px;float: right;background: #473970;margin: -9px 10px" onclick="moProtectedAPIsSave()" class="button button-primary button-large">Save</button>
					<input type="submit" name="reset" value="Reset Settings" style="width:110px;float: right;background: #473970;margin-right: 5px;margin-top: -9px" class="button button-primary button-large">
				<h2 style="font-size: 20px;font-weight: 700">Protected REST API Settings</h2>
				<p style="font-size: 14px;font-weight: 400">All the REST APIs listed below are protected from public access. You can uncheck the checkboxes to make it publicly accessible.</p>
				<p style="font-size: 14px;font-weight: 400"><b>Tip: </b>This Setting with the free plan is only available for standard WordPress endpoints. For custom build endpoints or 3rd party plugin endpoints, go for <b><i><a href="admin.php?page=mo_api_authentication_settings&tab=licensing" style="color:#a83262"><u>Protecting 3rd Party Plugin and
				Custom APIs Plan</u></a> </i> or <i><a href="admin.php?page=mo_api_authentication_settings&tab=licensing" style="color:#a83262"><u>All-Inclusive Plan</u></a></i></b> now.</p>
				<p style="font-size: 14px;font-weight: 400"><b>Note: </b>The custom/3rd party plugin endpoints access can still be blocked or allowed to be accessed publicly with this plan of the plugin.</p>
				<br>
				<div class="mo_api_authentication_support_layout" id="mo_api_jwtauth_client_creds" style="margin-left: 5px; margin-top: 2px; width: 90%">
					<input type="hidden" name="option" value="mo_api_authentication_protected_apis_form">
				<?php wp_nonce_field( '' ); ?>
				<?php wp_nonce_field( 'ProtectedRestAPI_admin_nonce', 'ProtectedRestAPI_admin_nonce_fields' ); ?>

					<div id="protectedrestapi_container"><?php self::protected_rest_api_display_route_checkboxes(); ?></div>

				</div>
					<br>

				</form>

			<br>
			</div>
			<script >

				function moProtectedAPIsSave(){
					document.getElementById("ProtectedRestAPI_form").submit();
				}

			</script>
		<?php
	}

	/**
	 * Display Route checkboxes.
	 *
	 * @return void
	 */
	public static function protected_rest_api_display_route_checkboxes() {
		$wp_rest_server = rest_get_server();
		$all_namespaces = $wp_rest_server->get_namespaces();
		$all_routes     = array_keys( $wp_rest_server->get_routes() );
		if ( ! get_option( 'mo_api_authentication_init_protected_apis' ) ) {
			mo_api_authentication_reset_api_protection();
			update_option( 'mo_api_authentication_init_protected_apis', 'true' );
		}
		$whitelisted_routes = is_array( get_option( 'mo_api_authentication_protectedrestapi_route_whitelist' ) ) ? get_option( 'mo_api_authentication_protectedrestapi_route_whitelist' ) : array();

		$loop_counter      = 0;
		$current_namespace = '';

		foreach ( $all_routes as $route ) {
			$is_route_namespace = in_array( ltrim( $route, '/' ), $all_namespaces, true );
			$checked_prop       = self::protected_rest_api_get_route_checked_prop( $route, $whitelisted_routes );
			$route_disabled     = ( self::check_route_is_wp_standard_or_not( $route ) || get_option( 'mo_rest_api_protect_migrate' ) ) ? '' : 'disabled';
			if ( $is_route_namespace || '/' === $route ) {
				$current_namespace = $route;
				if ( 0 !== $loop_counter ) {
					echo '</ul>';
				}

				$route_for_display = ( '/' === $route ) ? '/' . esc_html__( 'REST API ROOT', 'disable-json-api' ) : esc_html( $route );

				echo '<h2><label><input name="' . esc_attr( 'rest_routes[]' ) . '" value="' . esc_attr( $route ) . '" id="' . esc_attr( 'protectedrestapi_namespace_' . $loop_counter ) . '" type="checkbox" onclick="protectedrestapi_namespace_click(\'' . esc_attr( $current_namespace ) . '\', \'' . esc_attr( $loop_counter ) . '\')" ' . esc_attr( $checked_prop ) . ' ' . esc_attr( $route_disabled ) . '>&nbsp;' . esc_html( $route_for_display ) . '</label></h2>';

				if ( '/' === $route ) {
					/* translators: %s: rest api url */
					echo '<li>' . sprintf( esc_html__( 'On this website, the REST API root is %s', 'disable-json-api' ), '<strong>' . esc_url( rest_url() ) . '</strong>' ) . '</li>';
				}
			} else {
				echo "<li><label><input name='rest_routes[]' value='" . esc_attr( $route ) . "' type='checkbox' ' data-namespace='" . esc_attr( $current_namespace ) . "' " . esc_attr( $checked_prop ) . ' ' . esc_attr( $route_disabled ) . '>&nbsp;' . esc_html( $route ) . '</label></li>';
			}

			$loop_counter ++;
		}
		echo '</ul>';
	}

	/**
	 * Check if the ruote is WP standard route or not
	 *
	 * @param mixed $route rest api ruote.
	 * @return bool
	 */
	public static function check_route_is_wp_standard_or_not( $route ) {
		if ( stripos( $route, '/wp/v2' ) === false ) {
			return false;
		} else {
			return true;
		}
	}


	/**
	 * Check if the route is checked.
	 *
	 * @param mixed $route rest api ruote.
	 * @param mixed $whitelisted_routes whitelisted routes.
	 * @return bool
	 */
	public static function protected_rest_api_get_route_checked_prop( $route, $whitelisted_routes ) {

		if ( self::check_route_is_wp_standard_or_not( $route ) || get_option( 'mo_rest_api_protect_migrate' ) ) {

			$is_route_checked = in_array( esc_html( $route ), $whitelisted_routes, true );
			return checked( $is_route_checked, true, false );
		} else {
			return false;
		}

	}
}
