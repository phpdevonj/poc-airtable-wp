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

/**
 * [Basic Auth Configuration]
 */
class Mo_API_Authentication_Basic_Oauth_Config {

	/**
	 * Basic Authentication Configuration output.
	 *
	 * @return void
	 */
	public static function mo_api_auth_configuration_output() {

		?>
		<div id="mo_api_basic_authentication_support_layout" class="mo_api_authentication_support_layout">				

		<input type="hidden" name="action" id="mo_api_basicauth_save_config_input" value="Save Basic Auth">
		<div id="mo_api_authentication_support_basicoauth" class="mo_api_authentication_common_div_css">

			<button type="button" onclick="moBasicAuthenticationMethodSave('save_basic_auth')" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;">Next</button>
			<a href="admin.php?page=mo_api_authentication_settings"><button type="button" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;margin-right: 15px;">Back</button></a>

			<h4><a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration: none">Configure Methods</a> > Basic Authentication Method</h4>
			<h2 class="mo_api_authentication_method_head">Basic Authentication Method</h2>

			<p class="mo_api_authentication_method_description">WordPress REST API - Basic Authentication Method involves the REST APIs access on validation against the API token generated based on the user’s username, password and on basis of client credentials.</p>
			<br>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/youtube.png" height="25px" width="25px"></div>
				<a href="https://www.youtube.com/watch?v=vwxkpuj7LCw" target="_blank" rel="noopener noreferrer"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Video guide</b></p></div></a>
			</div>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/user-guide.png" height="25px" width="25px"></div>
				<a href="https://plugins.miniorange.com/wordpress-rest-api-basic-authentication-method#step_1" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Setup Guide</p></div></a>
			</div>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/document.png" height="25px" width="25px"></div>
				<a href="https://developers.miniorange.com/docs/rest-api-authentication/wordpress/basic-authentication" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Developer Doc</b></p></div></a>
			</div>
			<br><br>
			<div class="mo_api_authentication_support_layout" style="border-width: 0px;padding-left: 2px">
				<br>
				<h3 style="margin-top: 40px">Select One of the below Basic Token generation types - </h3>
				<br>
				<div class="mo_api_authentication_card_layout_internal">

					<div class="mo_api_flex_child" id="mo_api_config_bauth1" onclick="moBasicAuthenticationClienCreds('uname_pass')">
						<div style="height: 30%">
						<div id="mo_api_basicauth_select_type1" style="
						<?php
						if ( ! get_option( 'mo_api_authentication_selected_authentication_method' ) || ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'basic_auth' && get_option( 'mo_api_authentication_authentication_key' ) === 'uname_pass' ) ) {
							echo 'display:block';
						} else {
							echo 'display:none';}
						?>
						"><img src="<?php echo esc_attr( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/select-all.png" height="25px" width="25px" style="float: right;padding-top: 0px;padding-right: 5px;">
						</div>
						<div class="mo_api_bauth_internal_div">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/guarantee.png" height="30px" width="30px"></div>
						</div>
						<div style="height: 50%;width: 90%;text-align: center;padding-top: 10%">
							<p style="font-size: 15px;font-weight: 500">Username & Password with Base64 Encoding</p>
						</div>
					</div>
					<div class="mo_api_flex_child mo_api_no_cursor">
						<div style="height: 30%">
							<div class="mo_api_auth_premium_label_jwt">
								<div class="mo_api_auth_premium_label_internal_jwt">
									<div class="mo_api_auth_premium_label_text_jwt">Premium</div>
								</div>
							</div>
						<div class="mo_api_bauth_internal_div">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/user-authentication.png" height="30px" width="30px"></div>
						</div>
						<div style="height: 50%;width: 90%;text-align: center;padding-top: 10%;">
						<p style="font-size: 15px;font-weight: 500">Username & Password with HMAC Validation</p>
						</div>

				</div>
			</div>
				<br>

				<?php

					$basic_auth_client_creds_enable = 0;

				if ( get_option( 'mo_api_authentication_selected_authentication_method' ) === 'basic_auth' && get_option( 'mo_api_authentication_authentication_key' ) === 'cid_secret' ) {
					$basic_auth_client_creds_enable = 1;
				} else {
					$basic_auth_client_creds_enable = 0;
				}
				?>

				<div class="mo_api_authentication_card_layout_internal">
					<div class="mo_api_flex_child" id="mo_api_config_bauth2" onclick="moBasicAuthenticationClienCreds('cid_secret')" style="
					<?php
					if ( ! $basic_auth_client_creds_enable ) {
						echo 'cursor:no-drop';}
					?>
					" >
						<div style="height: 30%">
							<div class="mo_api_auth_premium_label_jwt">
								<div class="mo_api_auth_premium_label_internal_jwt">
									<div class="mo_api_auth_premium_label_text_jwt">Premium</div>
								</div>
							</div>
							<?php if ( $basic_auth_client_creds_enable ) { ?>
						<div id="mo_api_basicauth_select_type2" style=""><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/select-all.png" height="25px" width="25px" style="float: right;padding-top: 0px;padding-right: 5px;"></div>
					<?php } ?>
						<div class="mo_api_bauth_internal_div" >
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/key.png" height="30px" width="30px"></div>
						</div>
						<div class="mo_api_bauth_internal" >
						<p style="font-size: 15px;font-weight: 500">Client ID & Secret with Base64 Encoding</p></div>

					</div>
					<div class="mo_api_flex_child mo_api_no_cursor">
						<div style="height: 30%">
							<div class="mo_api_auth_premium_label_jwt">
								<div class="mo_api_auth_premium_label_internal_jwt">
									<div class="mo_api_auth_premium_label_text_jwt">Premium</div>
								</div>
							</div>
						<div class="mo_api_bauth_internal_div">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/secure.png" height="30px" width="30px"></div>
						</div>
						<div class="mo_api_bauth_internal">
							<p style="font-size: 15px;font-weight: 500">Client ID & Secret with HMAC Validation</p>
						</div>
					</div>
				</div>
				<br>
			</div>
			<br>

		</div>
		</div>
	</form>
</div>

<div class="mo_api_authentication_support_layout" id="mo_api_basicauth_finish" style="display: none;">
		<form method="post" id="mo-api-basic-authentication-method-form" action="">
					<input required type="hidden" name="option" value="mo_api_basic_authentication_config_form" />
					<?php wp_nonce_field( 'mo_api_basic_authentication_method_config', 'mo_api_basic_authentication_method_config_fields' ); ?>	

			<div id="mo_api_basicauth_client_creds" style="margin-left: 20px;">
				<input type="hidden" name="action" id="mo_api_auth_save_config_input" value="Save Configuration">
				<button type="submit" onclick="moBasicAuthenticationMethodFinish()" class="mo_api_authentication_method_save_button2 button button-primary button-large" style="background: #473970;margin-right: 10px;">Finish</button>
				<button type="button" onclick="moBasicAuthenticationMethodBack()" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;margin-right: 15px;">Back</button>
				<b><p><a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration: none">Configure Methods</a> > Basic Authentication Method</p></b>
			<h2 style="font-size: 22px;">Configuration Overview</h2>
				<br>
				<div class="mo_api_authentication_support_layout" style="width: 90%;">
					<br>

					<table width="80%">
						<tr>
							<td>
								<p style="font-size: 15px;">Token credentials Type :</p>
							</td>
							<td>
								<p id="mo_api_basicauth_token_type" class="mo_api_basicauth_creds_type"></p>
							</td>
						</tr>
						<tr>
							<td>
								<p style="font-size: 15px;">Token Encryption Method :</p>
							</td>
							<td>
								<p class="mo_api_basicauth_creds_type" >Base64 Encoding</p>
							</td>
						</tr>
					</table>

						<div id="mo_api_basic_auth_show_client_creds" style="display: none;">

						<table width="80%">
							<tr>
								<td style="width: 60%">
									<p style="font-size: 15px;">Client ID :</p>
								</td>
								<td >
									<p><input id="mo_api_basicauth_clientid" type="text" value="" disabled></p>
								</td>
							</tr>
							<tr>
								<td>
									<p style="font-size: 15px;">Client Secret :</p>
								</td>
								<td>
									<p><input id="mo_api_basicauth_clientsecret" type="password" value="" disabled></p>
								</td>
							</tr>
							</table>
						</div>
				</div>
				<br>
				<h2 style="font-size: 22px;">Test Configuration</h2>
				<br>
				<div class="mo_api_authentication_support_layout" id="mo_api_authentication_basic_test_config" style="width: 90%;">
					<table width="80%">
						<tr>
							<td>
								<p>Username:</p>
								<input type="text" id='mo_rest_api_basic_auth_username' size="28" placeholder="Enter WordPress Username" class='mo_test_config_input' >
							</td>
							<td>
								<p >Password:</p>
								<span id="mo_api_auth_test_password">
									<input type="password" id='mo_rest_api_rest_basic_auth_password' size="28" placeholder="Enter WordPress Password" class = 'mo_test_config_input'>
									<i class="fa fa-fw fa-eye-slash" id="mo_api_basic_eye_show_hide" aria-hidden="true" onclick="mo_rest_api_display_basic_auth_password()"></i>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<p>REST API Endpoint: </p>
							</td>
						</tr>
						<tr>
							<td colspan='2'><input type='button' value="GET" class='mo_test_config_request_method'>&nbsp;<input type='text' id='rest_basic_auth_endpoint' value="<?php echo esc_html( get_rest_url() ) . 'wp/v2/posts'; ?>" size="40" class = 'mo_test_config_input' placeholder='Enter REST API Endpoint' /></td>
						</tr>
						<tr>
							<td>
								<br><br><input type='button' onclick="mo_rest_api_JWTtest_config_basic_auth();" value="Test Configuration" class="mo_test_config_button"></button>
							</td>
						</tr>
					</table>
					<br><br>
						<div id="mo_api_basic_auth_message">
							<p class="mo_api_auth_note"><strong><i>Note: </i></strong>The Test has been done successfully. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.</p>
						</div>
					<br>
					<h4 id='basic_auth_req_headers_text' style='display:none;'><b> Request Headers: </b></h4>
					<div id="basic_auth_request_headers" class='mo_request_header_basic_auth'>
						<p><span class='mo_test_config_key'>Authorization </span><span class='mo_test_config_string'>Basic </span><span class='mo_test_config_key_string' id='basic_auth_request_headers_value'></span></p>
					</div>
					<h4 id='basic_auth_response_text' style='display:none;'><b> Response: </b></h4>
					<pre id="json_basic_auth" class = 'mo_test_config_response'></pre>
					<h4 id='basic_display_text' style='display:none;'><img class="mo_oauth_rest_troubleshoot" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/trouble_2.png"><b style="margin-left:25px;"> TroubleShoot </b></h4>
					<pre style='padding: 15px 10px 15px 25px;' id="basic_display_troubleshoot" class='mo_test_config_response'>
					</pre>
					<br>	
					<br>
				</div>

			</div>
			<br><br>
		</form>
		</div>

		<script>
			var rest_basic_auth_endpoint_obj = document.getElementById('rest_basic_auth_endpoint');
			rest_basic_auth_endpoint_obj.style.width = ((rest_basic_auth_endpoint_obj.value.length + 1) * 7) + 'px';

			function MO_RAO_append_params_basic( endpoint, params ) {
					regex             = /.+\?.+=.+/i;
					regex1            = /.+\?/;
					if ( true == regex.test( endpoint ) ) { // URL already contains params.
						endpoint = endpoint + '&' + params;
					} else if ( true == regex1.test( endpoint ) ) { // URL contains "?" but no params.
						endpoint = endpoint + params;
					} else { // URL doesn't contains "?" and params.
						endpoint = endpoint + '?' + params;
					}
					return endpoint;
			}

			function moBasicAuthenticationMethodSave(action){

				var data = {
					'action': 'save_temporary_data',
					'auth_method' : 'basic_auth',
					'algo' : 'base64',
					'token_type' : localStorage.getItem('mo_api_basic_token_type'),
					'nonce': '<?php echo esc_attr( wp_create_nonce( 'mo_rest_api_temporal_data_nonce' ) ); ?>'
				};			

				jQuery.post(ajaxurl, data);

				div = document.getElementById('mo_api_basic_authentication_support_layout');
				div.style.display = "none";
				div2 = document.getElementById('mo_api_basicauth_finish');
				div2.style.display = "block";

				document.getElementById('basic_authentication_finish_stepper').classList.add('completed');

				if(localStorage.getItem('mo_api_basic_token_type') == 'uname_pass' || localStorage.getItem('mo_api_basic_token_type') == ''){
					document.getElementById('mo_api_basicauth_token_type').innerHTML = 'WordPress Username & Password';
				}
				else{
					document.getElementById('mo_api_basicauth_token_type').innerHTML = 'Client ID & Secret';
					div3 = document.getElementById('mo_api_basic_auth_show_client_creds');
					div3.style.display = "block";
				}
			}

			function moBasicAuthenticationMethodFinish(){
				document.getElementById("mo-api-basic-authentication-method-form").submit();
			}

			function moBasicAuthenticationMethodBack(){
				div = document.getElementById('mo_api_basic_authentication_support_layout');
				div.style.display = "block";
				div2 = document.getElementById('mo_api_basicauth_finish');
				div2.style.display = "none";
				document.getElementById('basic_authentication_finish_stepper').classList.remove('completed');
			}

			function moBasicAuthenticationClienCreds(type){
				div = document.getElementById('mo_api_basicauth_select_type1');
				div2 = document.getElementById('mo_api_basicauth_select_type2');

				if(type == 'cid_secret'){
					div.style.display = "none";
					div2.style.display = "block";
				}
				else{
					div.style.display = "block";
					if(div2 != null){
						div2.style.display = "none";
					}
				}

				localStorage.setItem('mo_api_basic_token_type', type);
			}

			function mo_rest_api_JWTtest_config_basic_auth() {
				var username = document.getElementById("mo_rest_api_basic_auth_username").value;
				var password = document.getElementById("mo_rest_api_rest_basic_auth_password").value;

				var b64string = username+":"+password;
				var b64string = btoa(unescape(encodeURIComponent(b64string)));

				if( b64string != 'Og==') {
					document.getElementById("basic_auth_request_headers_value").textContent = b64string;
				}

				var endpoint = document.getElementById("rest_basic_auth_endpoint").value;

				var myHeaders = new Headers();
				myHeaders.append("Authorization", "Basic "+b64string);
				var requestOptions = {
					method: 'GET',
					headers: myHeaders,
					redirect: 'follow'
				};

				endpoint = MO_RAO_append_params_basic( endpoint, 'mo_rest_api_test_config=basic_auth' );

				fetch(endpoint, requestOptions)
				.then(response => response.text())
				.then(result => mo_rest_api_display_basic_auth_data(result))
				.catch(error => console.log('error', error));
			}

			function mo_rest_api_output_basic_auth(inp) {
				document.getElementById("json_basic_auth").innerHTML = inp;
			}

			function mo_rest_api_syntaxHighlight_basic_auth(json) {
				json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
					var cls = 'mo_test_config_number';
					if (/^"/.test(match)) {
						if (/:$/.test(match)) {
							cls = 'mo_test_config_key';
						} else {
							cls = 'mo_test_config_string';
						}
					} else if (/true|false/.test(match)) {
						cls = 'mo_test_config_boolean';
					} else if (/null/.test(match)) {
						cls = 'mo_test_config_null';
					}
					return '<span class="' + cls + '">' + match + '</span>';

				});
			}

			function mo_rest_api_display_basic_auth_data(result) {
				var data = JSON.parse(result);
				var json = JSON.stringify(data, undefined, 4);
				var container = document.getElementById("mo_api_authentication_basic_test_config");

				mo_rest_api_output_basic_auth(mo_rest_api_syntaxHighlight_basic_auth(json));
				document.getElementById("json_basic_auth").style.display = "block";
				document.getElementById("basic_auth_request_headers").style.display = "block";
				document.getElementById("basic_auth_req_headers_text").style.display = "block";
				document.getElementById("basic_auth_response_text").style.display = "block";
				container.scrollTo({
					top: document.getElementById("basic_auth_response_text").offsetTop - container.offsetTop,
					behavior: "smooth"
				});

				if(data.error)
						mo_rest_api_troubleshootPrintBasic(data.error);
					else
						mo_rest_api_troubleshootHideBasic();
			}
			function mo_rest_api_troubleshootHideBasic(){

						document.getElementById("basic_display_troubleshoot").style.display = "none";
						document.getElementById("basic_display_text").style.display = "none";
						document.querySelector("#mo_api_basic_auth_message .mo_api_auth_note ").innerHTML = '<strong><i>Note: </i></strong>The Test has been done successfully. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.';
				document.querySelector("#mo_api_basic_auth_message .mo_api_auth_note").style.display = "block";
			}
			function mo_rest_api_troubleshootPrintBasic(err){
				if(err === "INVALID_PASSWORD")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = `<ul style="list-style: inside;"><li>Check if username and password entered are correct.</li><li>If yes try password without special characters.</li></ul>`;
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";

				}
				else if(err  === "INVALID_USERNAME")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = '<ul style="list-style: inside;"><li>Check if user with this username exists or the entered username spelling is correct.</li><li>Make sure that you are using WordPress username and not email, as Basic Authentication with email and password is available with the Premium plan only.</li></ul>';
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";

				}
				else if(err === "INVALID_CLIENT_CREDENTIALS")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = 'INVALID_CLIENT_CREDENTIALS';
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";

				}
				else if(err === "MISSING_AUTHORIZATION_HEADER")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = '<ul style="list-style: inside;"><li>Verify if you have added necessary headers.</li><li>Add below lines to your htaccess file(Apache server)</li><ul style="padding-inline-start: 19px;"><li>RewriteEngine On &NewLine;RewriteCond %{HTTP:Authorization} ^(.*) &NewLine;RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]</li></ul><li>Add below lines to your config file(NGINX server)</li><ul style="padding-inline-start: 19px;"><li>add_header Access-Control-Allow-Headers "Authorization";</li></ul></ul>';
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";

				}
				else if(err === "INVALID_AUTHORIZATION_HEADER_TOKEN_TYPE")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = 'INVALID_AUTHORIZATION_HEADER_TOKEN_TYPE';
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";
				}
				else if(err === "INVALID_TOKEN_FORMAT")
				{
					document.getElementById("basic_display_troubleshoot").innerHTML = 'INVALID_TOKEN_FORMAT';
					document.getElementById("basic_display_troubleshoot").style.display = "block";
					document.getElementById("basic_display_text").style.display = "inline-block";

				}
				document.querySelector("#mo_api_basic_auth_message .mo_api_auth_note ").innerHTML = '<strong><i>Note: </i></strong>You are currently in the testing mode and this authentication method is not yet enabled on your site. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.';
				document.querySelector("#mo_api_basic_auth_message .mo_api_auth_note").style.display = "block";
			}

			function mo_rest_api_display_basic_auth_password() {
				var field = document.getElementById("mo_rest_api_rest_basic_auth_password");
				var showButton = document.getElementById("mo_api_basic_eye_show_hide");
				if (field.type == "password") {
					field.type = "text";
					showButton.className = "fa fa-eye";
				} else {
					field.type = "password";
					showButton.className = "fa fa-eye-slash";
				}
			}

		</script>
		<?php
	}
}
