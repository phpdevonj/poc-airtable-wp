<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       miniorange
 *
 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Admin Support
 */
class Mo_API_Authentication_Support {

	/**
	 * Premium plugins advertise
	 *
	 * @return void
	 */
	public static function mo_api_authentication_admin_support() {
		?>
		<div id="mo_api_authentication_support_layout" class="mo_api_authentication_support_layout" style="background: linear-gradient(to right, #09B9CE, #3C79DA, #7039E5)">
			<div style="padding: 0 5px 5px 5px 5px">
				<img src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/mologo.png' ); ?>" height="45px" width="45px" style="float: right;padding-right: 10px;">
				<h2 class="mo_api_authentication_adv">Unlock More</h2>
				<h2 class="mo_api_authentication_adv">Security Features</h2>
				<p class="mo_api_authentication_adv_internal">Starting at  <span class="mo_api_authentication_adv_span">$149*</span></p>
				<hr class="mo_api_authentication_adv_hr">
				<p class="mo_api_authentication_adv_internal2"><a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?page=mo_api_authentication_settings&tab=licensing"><button type="button" style="width:140px;height: 40px;background: #473970;color: white" class="button button-primary button-large">Go Premium Now</button></a></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Handle advertising
	 *
	 * @return void
	 */
	public static function mo_api_authentication_advertise() {
		?>
		<div id="mo_api_authentication_support_layout" class="mo_api_authentication_support_layout" style="padding-top: 20px; margin-top: 0px">
			<div style="padding: 0 5px 5px 5px 5px;">

				<div style="display: flex;width: 100%;height: 65px">
					<div style="flex: 1;width: 19%">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/mologo.png' ); ?>" height="65px" width="65px">
					</div>
					<div style="width: 75%">
						<p class="mo_api_authentication_adv_custom_api_heading">Custom API for WordPress</p>
					</div>
				</div>
					<p class="mo_api_authentication_adv_custom_api">Create your own REST API endpoints in WordPress to interact with WordPress database to fetch, insert, update, delete data. Also, any external APIs can be connected to WordPress for interaction between WordPress & External application.</p>
				<br><br>
				<div>
				<p class="mo_api_authentication_adv_custom_api_p"><a href="https://wordpress.org/plugins/custom-api-for-wp/" target="_blank" rel="noopener" ><button type="button" style="width:120px;height: 40px;background: #473970;color: white" class="button button-primary button-large">Install Plugin</button></a></p>
			</div>
			</div>
			<br>
		</div>
		<br>
		<div id="mo_api_authentication_support_layout" class="mo_api_authentication_support_layout" style="padding: 20px; margin-top: 0px">
			<div style="padding: 5px 5px 5px 5px;">
				<div style="text-align: center;">
					<div>
						<img src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/api-gateway.png' ); ?>">
					</div>
					<div style="font-weight: 700;font-size: 15px;">
					Try miniOrange API Gateway today and take your APIs to the next level
					</div>
				</div>
				<p>Protect your APIs with miniOrange's API Gateway which acts as a security layer on top of your backend services, offering a one stop solution for enhanced security and mitigating OWASP vulnerabilities. It ensures secure request routing, rate limiting, authentication, caching, and other essential security.</p>
				<div style="margin-top:20px; display:flex;">
					<p style="flex: auto;align-self: center;"><a href="https://apisecurity.miniorange.com/?source=RESTAPIPlugin" target="_blank" rel="noopener" style="font-weight: bold;font-size:15px; color:#00CC83; text-decoration:none;" >Learn More 
						<svg xmlns="http://www.w3.org/2000/svg" width="17" height="12" viewBox="0 0 17 12" fill="none">
							<path d="M16.5303 6.53033C16.8232 6.23744 16.8232 5.76256 16.5303 5.46967L11.7574 0.6967C11.4645 0.403807 10.9896 0.403807 10.6967 0.6967C10.4038 0.989593 10.4038 1.46447 10.6967 1.75736L14.9393 6L10.6967 10.2426C10.4038 10.5355 10.4038 11.0104 10.6967 11.3033C10.9896 11.5962 11.4645 11.5962 11.7574 11.3033L16.5303 6.53033ZM-6.55671e-08 6.75L16 6.75L16 5.25L6.55671e-08 5.25L-6.55671e-08 6.75Z" fill="#00CC83"/>
						</svg>
					</a></p>
					<p><a href="https://apiconsole.miniorange.com/?source=RESTAPIPlugin" target="_blank" rel="noopener" ><button type="button" style="width:120px;height: 40px;background: #00CC83;font-weight: bold;color: white;border:none;" class="button button-primary button-large">Try Now</button></a></p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Handle customer support.
	 *
	 * @return void
	 */
	public static function mo_oauth_client_setup_support() {
		?>
	<div class="mo_rest_api_support-icon" style="display: block;">
			<div class="mo_rest_api_help-container" id="help-container" style="display: block;">
				<span class="mo_rest_api_span1">
					<div class="mo_rest_api_need">
						<span class="mo_rest_api_span2"></span>
						<div id="mo-rest-api-support-msg">Need Help or request a feature? We are right here!</div>
						<span class="fa fa-times fa-1x " id="mo-support-msg-hide" style="cursor:pointer;float:right;display:inline;">
					</span>
					</div>
				</span>
				<div id="service-btn">
				<div class="mo-rest-api-service-icon">
					<img src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/mail.png' ); ?>" class="mo-rest-api-service-img" alt="support">
				</div>
			</div>
			</div>
		</div>

	<div class="mo-rest-api-support-form-container" style="display: none;">
			<div class="mo-rest-api-widget-header">
				<b>Contact miniOrange Support</b>
				<div class="mo-rest-api-widget-header-close-icon">
					<span style="cursor: pointer;float:right;" id="mo-rest-api-support-form-hide"><img src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/remove.png' ); ?>" height="15px" width = "15px">
					</span>
				</div>
			</div>

			<div class="mo-rest-api-loading-inner" style="overflow:hidden;">
			<div class="loading-icon">
				<div class="loading-icon-inner">
				<span class="icon-box">
					<img class="icon-image" src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/tick.png' ); ?>" alt="success" height="25px" width = "25px" >
				</span>
				<p class="loading-icon-text">
					<p>Thanks for your inquiry.<br><br>If you don't hear from us within 24 hours, please feel free to send a follow up email to <a href="mailto:<?php echo 'apisupport@xecurify.com'; ?>"><?php echo 'apisupport@xecurify.com'; ?></a></p>
				</p>
				</div>
			</div>
			</div>

			<div class="mo-rest-api-loading-inner-2" style="overflow:hidden;">
			<div class="mo-rest-api-loading-icon-2">
				<div class="loading-icon-inner-2">
				<br>
				<span class="icon-box-2">
					<img class="icon-image-2" src="<?php echo esc_url( plugin_dir_url( dirname( __DIR__ ) ) . 'images/mail.png' ); ?>" alt="error" >
				</span>
				<p class="mo-rest-api-loading-icon-text-2">
					<p>Unable to connect to Internet.<br>Please try again.</p>
				</p>
				</div>
			</div>
			</div>
			<div class="mo-rest-api-loading-inner-3" style="overflow:hidden;">
			<div class="loading-icon-3">
				<p class="loading-icon-text-3">
					<p style="font-size:18px;">Please Wait...</p>
				</p>
				<div class="loader"></div>
			</div>
			</div>

			<br>
			<div class="support-form top-label" style="display: block;">
					<label for="email">
						Your Contact E-mail
					</label>
					<br><br>
					<input type="email" class="field-label-text" name="email" id="person_email" dir="auto" required="true" title="Enter a valid email address." placeholder="Enter valid email">
					<br><br>
					<label>
						How can we help you?
					</label>
					<br><br>
					<textarea rows="5" id="person_query" name="description" dir="auto" required="true" class="field-label-textarea" placeholder="You will get reply via email"></textarea>
					<br><br>
					<button id="mo-rest-api-submit-support" type="submit" class="button button-primary button-large" style="width:70px;margin-left:30%;border-radius: 2px;background: #473970;" value="Submit" aria-disabled="false">Submit</button>
			</div>
		</div>
	<script>

			jQuery('#mo-rest-api-support-form-hide').click(function(){
				jQuery(".mo-rest-api-support-form-container").css('display','none');
			});

			jQuery('#mo-rest-api-support-msg').click(function(){
					jQuery(".mo-rest-api-support-form-container").show();
					jQuery(".mo-rest-api-support-msg").hide();
				});

			jQuery("#service-btn").click(function(){
					jQuery(".mo-rest-api-support-form-container").show();
					jQuery(".mo-rest-api-support-msg").hide();
				});
			jQuery("#mo-rest-api-submit-support").click(function(){

				var email = jQuery("#person_email").val();
				var query = jQuery("#person_query").val();
				var fname = "<?php echo esc_attr( ( wp_get_current_user()->user_firstname ) ); ?>";
				var lname = "<?php echo esc_attr( ( wp_get_current_user()->user_lastname ) ); ?>";
				var version = "<?php echo esc_attr( MINIORANGE_API_AUTHENTICATION_VERSION ); ?>";
				var query = "[WordPress REST API Authentication plugin] "+version+" - "+query;
				var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
				if(email == "" || query == "" || !pattern.test(email)){

					jQuery('#login-error').show();
					jQuery('#errorAlert').show();

				}
				else{
					jQuery('input[type="text"], textarea').val('');
					jQuery('select').val('Select Category');
					jQuery(".support-form").css('display','none');
					jQuery(".mo-rest-api-loading-inner-3").css('display','block');
					var json = new Object();

					json = {
						"email" : email,
						"query" : query,
						"ccEmail" : "apisupport@xecurify.com",
						"company" : "<?php echo ! empty( $_SERVER ['SERVER_NAME'] ) ? esc_html( sanitize_text_field( wp_unslash( $_SERVER ['SERVER_NAME'] ) ) ) : ''; ?>",
						"firstName" : fname,
						"lastName" : lname,
					}
				   
					var jsonString = JSON.stringify(json);
					jQuery.ajax({
						url: "https://login.xecurify.com/moas/rest/customer/contact-us",
						type : "POST",
						data : jsonString,
						crossDomain: true,
						dataType : "text",
						contentType : "application/json; charset=utf-8",
						success: function (data, textStatus, xhr) { successFunction(); },
						error: function (jqXHR, textStatus, errorThrown) { errorFunction(); }
					});
				}
			});

			function successFunction(){
				jQuery(".mo-rest-api-loading-inner-3").css('display','none');
				jQuery(".mo-rest-api-loading-inner").css('display','block');
			}

			function errorFunction(){
				jQuery(".mo-rest-api-loading-inner-3").css('display','none');
				jQuery(".mo-rest-api-loading-inner-2").css('display','block');
			}

	</script>
		<?php
	}

}
