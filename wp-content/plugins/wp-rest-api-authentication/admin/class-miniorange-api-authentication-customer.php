<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       miniorange
 * @package    Miniorange_Api_Authentication
 */

/** MINIORANGE provides to functionality to protect WP REST APIs from anonymous user and provide an authorized access to different WP APIs.
Copyright (C) 2015  miniOrange

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

 * @package         miniOrange OAuth
 * @license         https://docs.miniorange.com/mit-license MIT/Expat
 */

/**
This library is miniOrange Authentication Service.
Contains Request Calls to Customer service.
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * This library is miniOrange Authentication Service.
 * Contains Request Calls to Customer service.
 */
class Miniorange_API_Authentication_Customer {

	/**
	 * Customers miniOrange email address.
	 *
	 * @var email customer email.
	 */
	public $email;
	/**
	 * Customers miniOrange phone number.
	 *
	 * @var phone customer phone.
	 */
	public $phone;
	/**
	 * Customers miniOrange customer key.
	 *
	 * @var phone customer key.
	 */
	private $default_customer_key = '16555';
	/**
	 * Customers miniOrange customer api key.
	 *
	 * @var phone customer api key.
	 */
	private $default_api_key = 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq';


	/**
	 * Create customer.
	 *
	 * @param mixed $password miniOrange password.
	 * @return array
	 */
	public function create_customer( $password ) {
		$url         = get_option( 'host_name' ) . '/moas/rest/customer/add';
		$this->email = get_option( 'mo_api_authentication_admin_email' );
		$this->phone = get_option( 'mo_api_authentication_admin_phone' );
		$first_name  = get_option( 'mo_api_authentication_admin_fname' );
		$last_name   = get_option( 'mo_api_authentication_admin_lname' );
		$company     = get_option( 'mo_api_authentication_admin_company' );

		$fields       = array(
			'companyName'    => $company,
			'areaOfInterest' => 'WP REST API Authentication',
			'firstname'      => $first_name,
			'lastname'       => $last_name,
			'email'          => $this->email,
			'phone'          => $this->phone,
			'password'       => $password,
		);
		$field_string = wp_json_encode( $fields );
		$headers      = array(
			'Content-Type'  => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic',
		);
		$args         = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '15',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,

		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Check customer.
	 *
	 * @return array
	 */
	public function check_customer() {
		$url   = get_option( 'host_name' ) . '/moas/rest/customer/check-if-exists';
		$email = get_option( 'mo_api_authentication_admin_email' );

		$fields       = array(
			'email' => $email,
		);
		$field_string = wp_json_encode( $fields );
		$headers      = array(
			'Content-Type'  => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic',
		);
		$args         = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '5',
			'redirection' => '15',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,
		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Get timestamp
	 *
	 * @return array
	 */
	public function get_timestamp() {
		$url     = get_option( 'host_name' ) . '/moas/rest/mobile/get-timestamp';
		$headers = array(
			'Content-Type'  => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic',
		);
		$args    = array(
			'method'      => 'POST',
			'body'        => array(),
			'timeout'     => '5',
			'redirection' => '15',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,
		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return wp_remote_retrieve_body( $response );
	}


	/**
	 * Send OTP token.
	 *
	 * @param mixed $email customer email.
	 * @param mixed $phone customer phone number.
	 * @param bool  $send_to_email receiver email.
	 * @param bool  $send_to_phone receiver phone.
	 * @return array
	 */
	public function send_otp_token( $email, $phone, $send_to_email = true, $send_to_phone = false ) {
		$url = get_option( 'host_name' ) . '/moas/api/auth/challenge';

		$customer_key = $this->default_customer_key;
		$api_key      = $this->default_api_key;

		$username = get_option( 'mo_api_authentication_admin_email' );
		$phone    = get_option( 'mo_api_authentication_admin_phone' );
		/* Current time in milliseconds since midnight, January 1, 1970 UTC. */
		$current_time_in_millis = self::get_timestamp();

		/* Creating the Hash using SHA-512 algorithm */
		$string_to_hash = $customer_key . $current_time_in_millis . $api_key;
		$hash_value     = hash( 'sha512', $string_to_hash );

		$customer_key_header  = 'Customer-Key: ' . $customer_key;
		$timestamp_header     = 'Timestamp: ' . $current_time_in_millis;
		$authorization_header = 'Authorization: ' . $hash_value;

		if ( $send_to_email ) {
			$fields = array(
				'customerKey' => $customer_key,
				'email'       => $username,
				'authType'    => 'EMAIL',
			);} else {
			$fields = array(
				'customerKey' => $customer_key,
				'phone'       => $phone,
				'authType'    => 'SMS',
			);
			}
			$field_string = wp_json_encode( $fields );

			$headers                  = array( 'Content-Type' => 'application/json' );
			$headers['Customer-Key']  = $customer_key;
			$headers['Timestamp']     = $current_time_in_millis;
			$headers['Authorization'] = $hash_value;
			$args                     = array(
				'method'      => 'POST',
				'body'        => $field_string,
				'timeout'     => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,

			);

			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo 'Something went wrong: ' . esc_html( $error_message );
				exit();
			}

			return wp_remote_retrieve_body( $response );
	}

	/**
	 * Get customer key.
	 *
	 * @param mixed $password miniOrange password.
	 * @return array
	 */
	public function get_customer_key( $password ) {
		$url          = get_option( 'host_name' ) . '/moas/rest/customer/key';
		$email        = get_option( 'mo_api_authentication_admin_email' );
		$fields       = array(
			'email'    => $email,
			'password' => $password,
		);
		$field_string = wp_json_encode( $fields );

		$headers = array(
			'Content-Type'  => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic',
		);
		$args    = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,

		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Submit Contact us.
	 *
	 * @param mixed $email customer email.
	 * @param mixed $phone customer phone number.
	 * @param mixed $query customer query.
	 * @return array
	 */
	public function submit_contact_us( $email, $phone, $query ) {
		global $current_user;

		$last_requested_api = get_option( 'mo_api_authentication_last_requested_api' );
		$site_url           = site_url();
		$apis               = '';
		$version            = get_option( 'mo_api_authentication_current_plugin_version' );
		wp_get_current_user();
		$query = '[WordPress REST API Authentication plugin] version ' . $version . ' - ' . $query;
		if ( ! empty( $last_requested_api ) ) {
			foreach ( $last_requested_api as $api => $method ) {
				$apis .= $method . ' ' . $api . '<br>';
			}
		}

		$fields       = array(
			'firstName' => $current_user->user_firstname,
			'lastName'  => $current_user->user_lastname,
			'company'   => ! empty( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '',
			'email'     => $email,
			'ccEmail'   => 'apisupport@xecurify.com',
			'phone'     => $phone,
			'query'     => $query,
		);
		$field_string = wp_json_encode( $fields );

		$url     = get_option( 'host_name' ) . '/moas/rest/customer/contact-us';
		$headers = array(
			'Content-Type'  => 'application/json',
			'charset'       => 'UTF - 8',
			'Authorization' => 'Basic',
		);
		$args    = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '15',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,

		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Send Email alert.
	 *
	 * @param mixed $email customer email.
	 * @param mixed $phone customer phone number.
	 * @param mixed $reply customer reply.
	 * @param mixed $message customer message.
	 * @param mixed $subject Email subject.
	 * @return bool
	 */
	public function mo_api_authentication_send_email_alert( $email, $phone, $reply, $message, $subject ) {

		$url = get_option( 'host_name' ) . '/moas/api/notify/send';

		$last_requested_api = get_option( 'mo_api_authentication_last_requested_api' );
		$customer_key       = $this->default_customer_key;
		$api_key            = $this->default_api_key;

		$current_time_in_millis = self::get_timestamp();
		$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
		$hash_value             = hash( 'sha512', $string_to_hash );
		$customer_key_header    = 'Customer-Key: ' . $customer_key;
		$timestamp_header       = 'Timestamp: ' . $current_time_in_millis;
		$authorization_header   = 'Authorization: ' . $hash_value;
		$from_email             = $email;
		$site_url               = site_url();
		$apis                   = '';
		$plugin_version         = MINIORANGE_API_AUTHENTICATION_VERSION;

		if ( ! empty( $last_requested_api ) ) {
			foreach ( $last_requested_api as $api => $method ) {
				$apis .= $method . ' ' . $api . '<br>';
			}
		}
		global $user;
		$user  = wp_get_current_user();
		$query = '[WP REST API Authentication: ' . $plugin_version . '] : ' . $message;

		$content = '<div >Hello, <br><br>First Name :' . $user->user_firstname . '<br><br>Last  Name :' . $user->user_lastname . '   <br><br>Company :<a href="' . $site_url . '" target="_blank" >' . $site_url . '</a><br><br>Phone Number :' . $phone . '<br><br>Email :<a href="mailto:' . $from_email . '" target="_blank">' . $from_email . '</a><br><br>' . $reply . '<br><br>Query :' . $query . '</div>';

		$fields                   = array(
			'customerKey' => $customer_key,
			'sendEmail'   => true,
			'email'       => array(
				'customerKey' => $customer_key,
				'fromEmail'   => $from_email,
				'bccEmail'    => 'apisupport@xecurify.com',
				'fromName'    => 'miniOrange',
				'toEmail'     => 'apisupport@xecurify.com',
				'toName'      => 'apisupport@xecurify.com',
				'subject'     => $subject,
				'content'     => $content,
			),
		);
		$field_string             = wp_json_encode( $fields );
		$headers                  = array( 'Content-Type' => 'application/json' );
		$headers['Customer-Key']  = $customer_key;
		$headers['Timestamp']     = $current_time_in_millis;
		$headers['Authorization'] = $hash_value;
		$args                     = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,

		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}

		return true;
	}

	/**
	 * Send demo alert.
	 *
	 * @param mixed $email customer email.
	 * @param mixed $demo_plan demo plan requested.
	 * @param mixed $message demo message.
	 * @param mixed $subject email subject.
	 * @return void
	 */
	public function mo_api_auth_send_demo_alert( $email, $demo_plan, $message, $subject ) {

		if ( ! $this->mo_api_authentication_check_internet_connection() ) {
			return;
		}
		$url = get_option( 'host_name' ) . '/moas/api/notify/send';

		$customer_key = $this->default_customer_key;
		$api_key      = $this->default_api_key;

		$current_time_in_millis = self::get_timestamp();
		$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
		$hash_value             = hash( 'sha512', $string_to_hash );
		$customer_key_header    = 'Customer-Key: ' . $customer_key;
		$timestamp_header       = 'Timestamp: ' . $current_time_in_millis;
		$authorization_header   = 'Authorization: ' . $hash_value;
		$from_email             = $email;
		$site_url               = site_url();

		global $user;
		$user = wp_get_current_user();

		$content = '<div >Hello, </a><br><br><b>Email :</b><a href="mailto:' . $from_email . '" target="_blank">' . $from_email . '</a><br><br><b>Requested Demo for :</b> ' . $demo_plan . '<br><br><b>Requirements (Usecase) :</b> ' . $message . '</div>';

		$fields                   = array(
			'customerKey' => $customer_key,
			'sendEmail'   => true,
			'email'       => array(
				'customerKey' => $customer_key,
				'fromEmail'   => $from_email,
				'bccEmail'    => 'apisupport@xecurify.com',
				'fromName'    => 'miniOrange',
				'toEmail'     => 'apisupport@xecurify.com',
				'toName'      => 'apisupport@xecurify.com',
				'subject'     => $subject,
				'content'     => $content,
			),
		);
		$field_string             = wp_json_encode( $fields );
		$headers                  = array( 'Content-Type' => 'application/json' );
		$headers['Customer-Key']  = $customer_key;
		$headers['Timestamp']     = $current_time_in_millis;
		$headers['Authorization'] = $hash_value;
		$args                     = array(
			'method'      => 'POST',
			'body'        => $field_string,
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => $headers,

		);

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo 'Something went wrong: ' . esc_html( $error_message );
			exit();
		}
	}

	/**
	 * Check internet connection.
	 *
	 * @return bool
	 */
	public function mo_api_authentication_check_internet_connection() {
		return (bool) @fsockopen( 'login.xecurify.com', 443, $errno, $errstr, 5 ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fsockopen, WordPress.PHP.NoSilencedErrors.Discouraged -- Using default PHP function for checking internet connection.
	}
}
