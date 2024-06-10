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
 * [Description Mo_API_Authentication_Jwt_Auth_Config]
 */
class Mo_API_Authentication_Jwt_Auth_Config {

	/**
	 * JWT Authentication Configuration output.
	 *
	 * @return void
	 */
	public static function mo_api_auth_configuration_output() {
		?>
	<div id="mo_api_jwt_authentication_support_layout" class="mo_api_authentication_support_layout">

	<form>					
		<input type="hidden" name="action" id="mo_api_jwtauth_save_config_input" value="Save JWT Auth">
		<div id="mo_api_authentication_support_basicoauth" class="mo_api_authentication_common_div_css">

			<button type="button" onclick="moJWTAuthenticationMethodSave('save_jwt_auth')" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;">Next</button>
			<a href="admin.php?page=mo_api_authentication_settings"><button type="button" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;margin-right: 15px;">Back</button></a>
			<h4><a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration: none">Configure Methods</a> > JWT Authentication Method</h4>
			<h2 class="mo_api_authentication_method_head">JWT Authentication Method</h2>

			<p class="mo_api_authentication_method_description">WordPress REST API - JWT Authentication Method involves the REST APIs access on validation against the JWT token (JSON Web Token) generated based on the user’s username, password using highly secure encryption algorithm.</p>
			<br>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/youtube.png" height="25px" width="25px"></div>
				<a href="https://www.youtube.com/watch?v=XlbSVHR7ohQ" target="_blank" rel="noopener noreferrer"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Video guide</b></p></div></a>
			</div>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/user-guide.png" height="25px" width="25px"></div>
				<a href="https://plugins.miniorange.com/wordpress-rest-api-jwt-authentication-method#step_1" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Setup Guide</p></div></a>
			</div>
			<div class="mo_api_auth_setup_guide2">
				<div class="mo_api_auth_setup_guide1"><img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/document.png" height="25px" width="25px"></div>
				<a href="https://developers.miniorange.com/docs/rest-api-authentication/wordpress/jwt-authentication" target="_blank"><div class="mo_api_authentication_guide1"><p style="font-weight: 700;">Developer Doc</b></p></div></a>
			</div>
			<br><br>	
			<div class="mo_api_authentication_support_layout" style="border-width: 0px;padding-left: 2px">
				<br>
				<h3 style="margin-top: 40px">Select JWT Token generation types -</h3>
				<p><b>Tip: </b>With the current plan of the plugin, by default HS256 Encryption algorithm is configured.</p>
				<br>
				<div class="mo_api_authentication_card_layout_internal">

					<div class="mo_api_flex_child" id=mo_api_config_bauth>

						<div style="height: 30%">
							<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/select-all.png" height="25px" width="25px" style="float: right;padding-top: 0px;padding-right: 5px;">
						<div style="width: 20%;float: left;padding-top: 25px;padding-left: 80px;">
						<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/key.png" height="30px" width="30px"></div>
						</div>
						<div style="height: 60%;width: 80%;text-align: center;padding-top: 10%">
							<p style="font-size: 15px;font-weight: 500">JWT generation using HS256 Encryption</p>
						</div>

					</div>
					<div class="mo_api_flex_child mo_api_no_cursor">
						<div style="height: 30%">
							<div class="mo_api_auth_premium_label_jwt">
								<div class="mo_api_auth_premium_label_internal_jwt">
									<div class="mo_api_auth_premium_label_text_jwt">Premium</div>
								</div>
							</div>
							<div style="width: 20%;float: left;padding-top: 25px;padding-left: 80px;">
								<img src="<?php echo esc_url( plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) ); ?>/images/secure.png" height="30px" width="30px">
							</div>
						</div>
						<div style="height: 60%;width: 80%;text-align: center;padding-top: 10%">
							<p style="font-size: 15px;font-weight: 500">JWT generation using RS256 Encryption</p>
						</div>
					</div>
				</div>
				<br>
				<br>

				<div style="display: flex;">
					<div style="float: left"><h3>Signing Key/Certificate Configuration - </h3></div>
					<div style="float: left;margin: 10px;">
					<div class="mo_api_auth_inner_premium_label_jwt"><p style="font-size: 0.8em;">Premium</p></div>
					</div>
				</div>
			<p><b>Tip: </b>With the current plan of the plugin, by default a randomly generated secret key will be used.</p>
				<br>
				<div style="cursor:no-drop;">
					<textarea type="textbox" placeholder="Configure your certificate or secret key" disabled style="width: 70%;height: 100px;"></textarea>
				</div>

				<br>

			</div>
			<br>

		</div>
	</form>
</div>
<div class="mo_api_authentication_support_layout" id="mo_api_jwtauth_finish" style="display: none;">

	<form method="post" id="mo-api-jwt-authentication-method-form" action="">
					<input required type="hidden" name="option" value="mo_api_jwt_authentication_config_form" />
					<?php wp_nonce_field( 'mo_api_jwt_authentication_method_config', 'mo_api_jwt_authentication_method_config_fields' ); ?>	

			<div id="mo_api_basicauth_client_creds" style="margin-left: 20px;">
				<button type="button" onclick="moJWTAuthenticationMethodFinish()" class="mo_api_authentication_method_save_button2 button button-primary button-large" style="background: #473970;margin-right: 10px;">Finish</button>
				<button type="button" onclick="moJWTAuthenticationMethodBack()" class="mo_api_authentication_method_save_button button button-primary button-large" style="background: #473970;margin-right: 15px;">Back</button>
				<b><p><a href="admin.php?page=mo_api_authentication_settings&tab=config" style="text-decoration: none">Configure Methods</a> > JWT Authentication Method</p></b>
			<h2 style="font-size: 22px;">Configuration Overview</h2>
				<br>
				<div class="mo_api_authentication_support_layout" style="width: 90%;">
					<br>

					<table width="80%">
						<tr>
							<td>
								<p style="font-size: 15px;">JWT Token Generation Algorithm :</p>
							</td>
							<td>
								<p style="font-size: 15px;font-weight: 500">HS256
								</p>
							</td>
						</tr>

					</table>
				</div>
				<br>

			<h2 style="font-size: 22px;">Test Configuration</h2>
				<br>
				<div id="mo_api_authentication_jwt_test_config" class="mo_api_authentication_support_layout" style="width: 90%;">
					<table width="80%">
						<tr>
							<td>
								<p style='color:#2a2ea9; font-size: 1.1em;'><b>[1] Get User Token from the Token Endpoint: </b></p>
							</td>
						</tr>
						<tr>
							<td>
								<p>Username:</p>
								<input type="text" id='mo_rest_api_jwt_username' size="28" placeholder="Enter WordPress Username"  class='mo_test_config_input'>

								<p >Password:</p>
								<span id="mo_api_auth_test_password">
									<input type="password" id='mo_rest_api_jwt_password' size="28" placeholder="Enter WordPress Password"  class='mo_test_config_input'>
									<i class="fa fa-fw fa-eye-slash" id="mo_api_jwt_eye_show_hide" aria-hidden="true" onclick="mo_rest_api_display_jwt_auth_password()"></i>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<p>Token Endpoint: </p>
							</td>
						</tr>
						<tr>
							<td><input type='button' value="POST" class='mo_test_config_request_method'>&nbsp;<input type='text' id='rest_token_endpoint' value="<?php echo esc_url( get_rest_url() . 'api/v1/token' ); ?>" readonly class='mo_test_config_input'></td>
						</tr>
						<tr>
							<td>
								<br><input type='button' onclick="mo_JWT_test_config('token');" value="Fetch Token" class="mo_test_config_button"></button>
							</td>
						</tr>
					</table>
					<br>	
					<h4 id='jwt_token_response_text' style='display:none;'><b> Response: </b></h4>
					<pre id="json_jwt_token" class='mo_test_config_response'>
					</pre>
					<h4 id='jwt_token_troubleshoot_text' style='display:none;'><img class="mo_oauth_rest_troubleshoot" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/trouble_2.png"><b style="margin-left:25px;"> TroubleShoot </b></h4>
					<pre style='padding: 15px 10px 15px 25px;' id="json_jwt_token_troubleshoot" class='mo_test_config_response'>

					</pre>

					<table width="80%">
						<tr>
							<td>
								<p style='color:#2a2ea9; font-size: 1.1em;'><b>[2] Check if token is valid: </b></p>
							</td>
						</tr>
						<tr>
							<td>
								<p>Token:</p>
								<input type="text" id='rest_token_value' size="28" placeholder="Enter JWT Token"  class='mo_test_config_input'>
							</td>
						</tr>
						<tr>
							<td>
								<p>Token Validation Endpoint: </p>
							</td>
						</tr>
						<tr>
						<td><input type='button' value="GET" class='mo_test_config_request_method'>&nbsp;<input type='text' id='rest_validate_endpoint' value="<?php echo esc_url( get_rest_url() . 'api/v1/token-validate' ); ?>" readonly class='mo_test_config_input'></td>
						</tr>
						<tr>
							<td>
								<br><input type='button' onclick="mo_JWT_test_config('validate');" value="Check Token" class="mo_test_config_button"></button>
							</td>
						</tr>
					</table>
					<br>	
					<h4 id='jwt_token_validate_response_text' style='display:none;'><b> Response: </b></h4>
					<pre id="json_jwt_token_validate" class='mo_test_config_response'>
					</pre>
					<h4 id='jwt_token_validate_text' style='display:none;'><img class="mo_oauth_rest_troubleshoot" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/trouble_2.png"><b style="margin-left:25px;"> TroubleShoot </b></h4>
					<pre style='padding: 15px 10px 15px 25px;' id="json_jwt_token_validate_troubleshoot" class='mo_test_config_response'>

					</pre>


					<table>
						<tr>
							<td>
								<p style='color: #2a2ea9; font-size: 1.1em;'><b>[3] Access the protected REST APIs by using the jwt_token obtained from above Step[1]: </b></p>
							</td>
						</tr>
						<tr>
							<td>
								<p>REST API Endpoint: </p>
							</td>
						</tr>
						<tr>
							<!-- <td><b> GET </b></td> -->
							<td><input type='button' value="GET" class='mo_test_config_request_method'>&nbsp;<input type='text' id='rest_endpoint_jwt_auth' value="<?php echo esc_attr( get_rest_url() ) . 'wp/v2/posts'; ?>" size="40" class='mo_test_config_input' placeholder='Enter REST API Endpoint' /></td>
						</tr>
						<tr>
							<td>
								<p>Token:</p>
								<input type="text" id='rest_jwt_token' size="28" placeholder="Enter JWT Token"  class='mo_test_config_input'>
							</td>
						</tr>
						<tr>
							<td>
								<br><input type='button' onclick="mo_JWT_test_config('rest');" value="Test Configuration" class="mo_test_config_button" />
							</td>
						</tr>
					</table>
					<br><br>
					<div id="mo_api_jwt_auth_message">
						<p class="mo_api_auth_note"><strong><i>Note: </i></strong>The Test has been done successfully. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.</p>
					</div>
					<br>
					<h4 id='jwt_token_req_headers_text' style='display:none;'><b>Request Headers: </b></h4>
					<pre id="jwt_token_request_headers" class='mo_request_header_jwt_auth'>
						<p><span class='mo_test_config_key'>Authorization </span><span class='mo_test_config_key_string'>Bearer </span><span class='mo_test_config_key_string' id='jwt_request_headers_value'></span></p>
					</pre>
					<h4 id='jwt_token_api_response_text' style='display:none;'><b>Response: </b></h4>
					<pre id="json_jwt" class='mo_test_config_response'>
					</pre>
					<h4 id='data_display_text' style='display:none;'><img class="mo_oauth_rest_troubleshoot" src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) ); ?>/images/trouble_2.png"><b style="margin-left:25px;"> TroubleShoot </b></h4>
					<pre style='padding: 15px 10px 15px 25px;' id="data_display_troubleshoot" class='mo_test_config_response'>
					</pre>
					<br>	
					<br>
				</div>
			</div>
			<br><br>
			</form>
		</div>

			<script>
				var token_endpoint_obj = document.getElementById('rest_token_endpoint');
				token_endpoint_obj.style.width = ((token_endpoint_obj.value.length + 1) * 7) + 'px';
				var token_endpoint_obj = document.getElementById('rest_validate_endpoint');
				token_endpoint_obj.style.width = ((token_endpoint_obj.value.length + 1) * 7) + 'px';
				var token_endpoint_obj = document.getElementById('rest_endpoint_jwt_auth');
				token_endpoint_obj.style.width = ((token_endpoint_obj.value.length + 1) * 7) + 'px';			
				function MO_RAO_append_params_jwt( endpoint, params ) {
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

				function moJWTAuthenticationMethodSave(action){
					div = document.getElementById('mo_api_jwt_authentication_support_layout');
					div.style.display = "none";
					div2 = document.getElementById('mo_api_jwtauth_finish');
					div2.style.display = "block";
					document.getElementById('basic_authentication_finish_stepper').classList.add('completed');
				}

				function moJWTAuthenticationMethodFinish(){
					document.getElementById("mo-api-jwt-authentication-method-form").submit();
				}

				function moJWTAuthenticationMethodBack(){
					div = document.getElementById('mo_api_jwt_authentication_support_layout');
					div.style.display = "block";
					div2 = document.getElementById('mo_api_jwtauth_finish');
					div2.style.display = "none";
					document.getElementById('basic_authentication_finish_stepper').classList.remove('completed');
				}


				function mo_JWT_test_config(event) {
					if(event === 'token') {
						var token_endpoint = document.getElementById("rest_token_endpoint").value;
						var username = document.getElementById("mo_rest_api_jwt_username").value;
						var password = document.getElementById("mo_rest_api_jwt_password").value;
						var myHeaders = new Headers();

						var formdata = new FormData();
						formdata.append("username", username);
						formdata.append("password", password);

						var requestOptions = {
							method: 'POST',
							credentials: 'include',
							headers: myHeaders,
							body: formdata,
							redirect: 'follow'
						};



						fetch(token_endpoint, requestOptions)
						.then(response => response.text())
						.then(result => moJWTdisplay_jwt_data(result))
						.catch(error => console.log('error', error));
					}
					else if(event === "validate"){
						var validate_endpoint = document.getElementById("rest_validate_endpoint").value;
						var token_val = document.getElementById("rest_token_value").value;



						var myHeaders = new Headers();
						myHeaders.append('Content-Type', 'application/json');
						myHeaders.append('Authorization','Bearer '+ token_val);

						var requestOptions = {
							method: 'GET',
							headers: myHeaders,
							redirect: 'follow'
						};

						validate_endpoint = MO_RAO_append_params_jwt( validate_endpoint, 'mo_rest_api_test_config=jwt_auth');

						fetch(validate_endpoint, requestOptions)
						.then(response => response.text())
						.then(result => moJWTdisplay_token_val_data(result))
						.catch(error => console.log('error', error));

					}
					else {
						var token = document.getElementById("rest_jwt_token").value;
						var endpoint = document.getElementById("rest_endpoint_jwt_auth").value;

						var myHeaders = new Headers();

						myHeaders.append("Authorization", "Bearer "+token);
						document.getElementById("jwt_request_headers_value").textContent = token;

						var requestOptions = {
							method: 'GET',
							headers: myHeaders,
							redirect: 'follow'
						};
						endpoint = MO_RAO_append_params_jwt( endpoint, 'mo_rest_api_test_config=jwt_auth' );

						fetch(endpoint, requestOptions)
						.then(response => response.text())
						.then(result => moJWTdisplay_data(result))
						.catch(error => console.log('error', error));
					}
				}

				var container = document.getElementById("mo_api_authentication_jwt_test_config");

				function moJWTdisplay_jwt_data(result) {
					var data = JSON.parse(result);
					var json = JSON.stringify(data, undefined, 4);
					moJWToutput(moJWTsyntaxHighlight(json), 'token');
					document.getElementById("json_jwt_token").style.display = "block";
					document.getElementById("jwt_token_response_text").style.display = "block";
					container.scrollTo({
						top: document.getElementById("jwt_token_response_text").offsetTop - container.offsetTop,
						behavior: "smooth"
					});
					if(data.error)
						moJWTtroubleshootPrintJWT(data.error , 'token');
					else
						moJWTtroubleshootHideJWT('token');
				}
				function moJWTdisplay_token_val_data(result) {
					var data = JSON.parse(result);
					var json = JSON.stringify(data, undefined, 4);
					moJWToutput(moJWTsyntaxHighlight(json), 'validate');
					document.getElementById("json_jwt_token_validate").style.display = "block";
					document.getElementById("jwt_token_validate_response_text").style.display = "block";
					container.scrollTo({
						top: document.getElementById("jwt_token_validate_response_text").offsetTop - container.offsetTop,
						behavior: "smooth"
					});
					if(data.error)
						moJWTtroubleshootPrintJWT(data.error , 'valid');
					else
						moJWTtroubleshootHideJWT('valid');
				}
				function moJWTtroubleshootHideJWT(place){
					if(place === "token"){
						document.getElementById("json_jwt_token_troubleshoot").style.display = "none";
						document.getElementById("jwt_token_troubleshoot_text").style.display = "none";
					}
					else if(place === "valid"){
						document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "none";
						document.getElementById("jwt_token_validate_text").style.display = "none";
					}
					else{
						document.getElementById("data_display_troubleshoot").style.display = "none";
						document.getElementById("data_display_text").style.display = "none";
					}
				}
				function moJWTtroubleshootPrintJWT(err,place){
					if(err === "INVALID_CREDENTIALS")
					{
						document.getElementById("json_jwt_token_troubleshoot").innerHTML = `<ul style="list-style: inside;"><li>Check if username and password entered are correct. If yes, make sure that, the password does not consists of special characters.</li><li>Make sure that you are using WordPress username and not email, as JWT Authentication with email and password is available with the Premium plan only.</li></ul>`;
						document.getElementById("json_jwt_token_troubleshoot").style.display = "block";
						document.getElementById("jwt_token_troubleshoot_text").style.display = "inline-block";

					}
					else if(err === "BAD_REQUEST")
					{
						document.getElementById("json_jwt_token_troubleshoot").innerHTML = 'Username or Password is missing.';
						document.getElementById("json_jwt_token_troubleshoot").style.display = "block";
						document.getElementById("jwt_token_troubleshoot_text").style.display = "inline-block";

					}
					else if(err === "SEGMENT_FAULT")
					{
						if(place === "valid"){
							document.getElementById("json_jwt_token_validate_troubleshoot").innerHTML = 'JWT token you entered is of invalid format re-enter it properly.';
							document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "block";
							document.getElementById("jwt_token_validate_text").style.display = "block";
							}
						else{
							document.getElementById("data_display_troubleshoot").innerHTML = 'JWT token you entered is of invalid format re-enter it properly.';
							document.getElementById("data_display_troubleshoot").style.display = "block";
							document.getElementById("data_display_text").style.display = "block";
							}
					}
					else if(err === "INVALID_PASSWORD")
					{
						document.getElementById("json_jwt_token_validate_troubleshoot").innerHTML = '';
						document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "block";
						document.getElementById("jwt_token_validate_text").style.display = "block";

					}
					else if(err === "MISSING_AUTHORIZATION_HEADER")
					{

						if(place === "valid"){
							document.getElementById("json_jwt_token_validate_troubleshoot").innerHTML = '<ul style="list-style: inside;"><li>Verify if you have added necessary headers.</li><li>Add below lines to your htaccess file(Apache server)</li><ul style="padding-inline-start: 19px;"><li>RewriteEngine On &NewLine;RewriteCond %{HTTP:Authorization} ^(.*) &NewLine;RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]</li></ul><li>Add below lines to your config file(NGINX server)</li><ul style="padding-inline-start: 19px;"><li>add_header Access-Control-Allow-Headers "Authorization";</li></ul></ul>';
							document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "block";
							document.getElementById("jwt_token_validate_text").style.display = "block";

						}
						else{
							document.getElementById("data_display_troubleshoot").innerHTML = '<ul style="list-style: inside;"><li>Verify if you have added necessary headers.</li><li>Add below lines to your htaccess file(Apache server)</li><ul style="padding-inline-start: 19px;"><li>RewriteEngine On &NewLine;RewriteCond %{HTTP:Authorization} ^(.*) &NewLine;RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]</li></ul><li>Add below lines to your config file(NGINX server)</li><ul style="padding-inline-start: 19px;"><li>add_header Access-Control-Allow-Headers "Authorization";</li></ul></ul>';
							document.getElementById("data_display_troubleshoot").style.display = "block";
							document.getElementById("data_display_text").style.display = "block";

						}
					}
					else if(err === "INVALID_AUTHORIZATION_HEADER_TOKEN_TYPE")
					{
						if(place === "valid"){
							document.getElementById("json_jwt_token_validate_troubleshoot").innerHTML = 'JWT token is missing check the JWT token field.';
							document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "block";
							document.getElementById("jwt_token_validate_text").style.display = "block";

						}
						else{
							document.getElementById("data_display_troubleshoot").innerHTML = 'JWT token is missing check the JWT token field.';
							document.getElementById("data_display_troubleshoot").style.display = "block";
							document.getElementById("data_display_text").style.display = "block";

						}
					}
					else if(err === "UNAUTHORIZED")
					{
						if(place === "valid"){
							document.getElementById("json_jwt_token_validate_troubleshoot").innerHTML = `<ul style="list-style: inside;"><li>JWT token entered is either expired or is of different authorization flow.</li><li>Regenrate JWT token and copy past it properly.</li></ul>`;
							document.getElementById("json_jwt_token_validate_troubleshoot").style.display = "block";
							document.getElementById("jwt_token_validate_text").style.display = "block";

						}
						else{
							document.getElementById("data_display_troubleshoot").innerHTML = `<ul style="list-style: inside;"><li>JWT token entered is either expired or is of different authorization flow.</li><li>Regenrate JWT token and copy past it properly.</li></ul>`;
							document.getElementById("data_display_troubleshoot").style.display = "block";
							document.getElementById("data_display_text").style.display = "block";

						}
					}
					document.querySelector("#mo_api_jwt_auth_message .mo_api_auth_note ").innerHTML = '<strong><i>Note: </i></strong>You are currently in the testing mode and this authentication method is not yet enabled on your site. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.';
					document.querySelector("#mo_api_jwt_auth_message .mo_api_auth_note").style.display = "block";
				}


				function moJWToutput(inp, endpoint) {
					// document.body.appendChild(document.createElement('pre')).innerHTML = inp;
					if( endpoint === 'wp_rest_api') {
						document.getElementById("json_jwt").innerHTML = inp;
					}

					else if(endpoint === "token"){
						document.getElementById("json_jwt_token").innerHTML = inp;
					}
					else{
						document.getElementById("json_jwt_token_validate").innerHTML = inp;
					}
				}

				function moJWTsyntaxHighlight(json) {
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

				function moJWTdisplay_data(result) {
					var data = JSON.parse(result);
					var json = JSON.stringify(data, undefined, 4);
					document.getElementById("json_jwt").style.display = "block";
					document.getElementById("jwt_token_req_headers_text").style.display = "block";
					document.getElementById("jwt_token_request_headers").style.display = "block";
					document.getElementById("jwt_token_api_response_text").style.display = "block";
					container.scrollTo({
						top: document.getElementById("jwt_token_api_response_text").offsetTop - container.offsetTop,
						behavior: "smooth"
					});
					document.querySelector("#mo_api_jwt_auth_message .mo_api_auth_note ").innerHTML = '<strong><i>Note: </i></strong>The Test has been done successfully. Please click on <strong>"Finish"</strong> button on the top right corner of the screen to save the authentication method.';
					document.querySelector("#mo_api_jwt_auth_message .mo_api_auth_note").style.display = "block";
					moJWToutput(moJWTsyntaxHighlight(json), 'wp_rest_api');
					if(data.error)
						moJWTtroubleshootPrintJWT(data.error , 'wp_rest_api');
					else
						moJWTtroubleshootHideJWT('wp_rest_api');

				}

				function mo_rest_api_display_jwt_auth_password() {
					var field = document.getElementById("mo_rest_api_jwt_password");
					var showButton = document.getElementById("mo_api_jwt_eye_show_hide");
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
