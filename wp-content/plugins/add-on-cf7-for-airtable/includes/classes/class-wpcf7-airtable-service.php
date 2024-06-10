<?php

/**
 * WCF7 Airtable service class.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT;

defined('ABSPATH') || exit;

use WPC_WPCF7_AT\Options;
use function WPC_WPCF7_AT\Helpers\tooltip;

/**
 * WCF7 Airtable service class.
 * Manages service registration and Airtable api key.
 */
class WPCF7_Airtable_Service extends \WPCF7_Service
{

	/**
	 * WPCF7_Airtable_Service instance
	 *
	 * @var WPCF7_Airtable_Service $instance
	 */
	private static $instance;

	/**
	 * Airtable Api Key
	 *
	 * @var string|mixed $api_key
	 */
	private $api_key = '';

	/**
	 * Returns WPCF7_Airtable_Service instance
	 *
	 * @return WPCF7_Airtable_Service
	 */
	public static function get_instance()
	{
		if (empty(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Fill $api_key & $app_id properties with the one saved in the WPCF7 options
	 * Also adds actions to display notices in the admin dashboard.
	 */
	private function __construct()
	{
		$option = \WPCF7::get_option(Options\get_option_key('airtable_service'));

		if (isset($option['api_key'])) {
			$this->api_key = $option['api_key'];
		}

		if ($this->uses_api_key() || empty($option['api_key'])) {
			add_action('admin_notices', array($this, 'display_deprecated_key_notice'));
		}
	}

	/**
	 * Returns service title
	 *
	 * @return mixed
	 */
	public function get_title()
	{
		return __('Airtable', 'add-on-cf7-for-airtable');
	}

	/**
	 * Returns true if the api key is defined
	 *
	 * @return bool
	 */
	public function is_active()
	{
		return (bool) $this->get_api_key();
	}

	/**
	 * Returns the api key
	 *
	 * @return mixed|string
	 */
	public function get_api_key()
	{
		return $this->api_key;
	}

	/**
	 * Returns the service categories
	 *
	 * @return string[]
	 */
	public function get_categories()
	{
		return array('collaboration_platform');
	}

	/**
	 * Returns the service icon
	 *
	 * @return string
	 */
	public function icon()
	{
		return '';
	}

	/**
	 * Returns the link to the Airtable website
	 *
	 * @return string|void
	 */
	public function link()
	{
		echo wp_kses_post(
			wpcf7_link(
				'https://airtable.com',
				'airtable.com'
			)
		);
	}

	/**
	 * Sends a debug information for a remote request to the PHP error log.
	 *
	 * @param string         $url URL to retrieve.
	 * @param array          $request Request arguments.
	 * @param array|WP_Error $response The response or WP_Error on failure.
	 * @return void
	 */
	protected function log($url, $request, $response)
	{
		wpcf7_log_remote_request($url, $request, $response);
	}

	/**
	 * Returns the integration admin page.
	 *
	 * @param string|array|object $args Args.
	 * @return mixed
	 */
	protected function menu_page_url($args = '')
	{
		$args = wp_parse_args($args, array());

		$url = menu_page_url('wpcf7-integration', false);
		$url = add_query_arg(array('service' => 'wpc_airtable'), $url);

		if (!empty($args)) {
			$url = add_query_arg($args, $url);
		}

		return $url;
	}

	/**
	 * Saves integration form data.
	 *
	 * @return void
	 */
	protected function save_data()
	{
		\WPCF7::update_option(
			Options\get_option_key('airtable_service'),
			array(
				'api_key' => $this->api_key,
			)
		);
	}

	/**
	 * Reset service data.
	 *
	 * @return void
	 */
	protected function reset_data()
	{
		$this->api_key = null;
		$this->save_data();
	}

	/**
	 * Integration form handler.
	 *
	 * @param string $action Action.
	 * @return void
	 */
	public function load($action = '')
	{
		if ('setup' === $action && isset($_SERVER['REQUEST_METHOD']) && 'POST' === $_SERVER['REQUEST_METHOD']) {
			check_admin_referer('wpc-wpcf7-airtable-setup');

			if (!empty($_POST['reset'])) {
				$this->reset_data();
				$redirect_to = $this->menu_page_url('action=setup');
			} else {
				$this->api_key = isset($_POST['api_key'])
					? trim(sanitize_text_field(wp_unslash($_POST['api_key'])))
					: '';

				$confirmed = !empty($this->api_key);
				Helpers\process_airtable_test_request_response(
					$confirmed ? true : new \WP_Error(__('Invalid key values.', 'add-on-cf7-for-airtable'))
				);

				if (true === $confirmed) {
					$redirect_to = $this->menu_page_url(
						array(
							'message' => 'success',
						)
					);

					$this->save_data();
				} elseif (false === $confirmed) {
					$redirect_to = $this->menu_page_url(
						array(
							'action'  => 'setup',
							'message' => 'unauthorized',
						)
					);
				} else {
					$redirect_to = $this->menu_page_url(
						array(
							'action'  => 'setup',
							'message' => 'invalid',
						)
					);
				}
			}

			wp_safe_redirect($redirect_to);
			exit();
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param string $message Admin notice message.
	 * @return void
	 */
	public function admin_notice($message = '')
	{
		if ('unauthorized' === $message) {
			echo sprintf(
				'<div class="notice notice-error"><p><strong>%1$s</strong>: %2$s</p></div>',
				esc_html(__('Error', 'add-on-cf7-for-airtable')),
				esc_html(__('You have not been authenticated. Make sure the provided API key is correct.', 'add-on-cf7-for-airtable'))
			);
		}

		if ('invalid' === $message) {
			echo sprintf(
				'<div class="notice notice-error"><p><strong>%1$s</strong>: %2$s</p></div>',
				esc_html(__('Error', 'add-on-cf7-for-airtable')),
				esc_html(__('Invalid key values.', 'add-on-cf7-for-airtable'))
			);
		}

		if ('success' === $message) {
			echo sprintf(
				'<div class="notice notice-success"><p>%s</p></div>',
				esc_html(__('Settings saved.', 'add-on-cf7-for-airtable'))
			);
		}
	}

	/**
	 * Displays information / service state.
	 *
	 * @param string $action Action.
	 * @return void
	 */
	public function display($action = '')
	{
		echo '<p>' . sprintf(
			/* translators: %s: html link */
			esc_html(__('Store form submissions in Airtable table. For details, see %s.', 'add-on-cf7-for-airtable')),
			wp_kses_post(
				str_replace(
					'<a',
					'<a target="_blank"',
					wpcf7_link(
						__('https://wordpress.org/plugins/add-on-cf7-for-airtable/#installation', 'add-on-cf7-for-airtable'),
						__('Airtable integration', 'add-on-cf7-for-airtable')
					)
				)
			)
		) . '</p>';

		if ($this->is_active()) {
			echo sprintf(
				'<p class="dashicons-before dashicons-yes">%s</p>',
				esc_html(__('Airtable is active on this site.', 'add-on-cf7-for-airtable'))
			);
			echo sprintf(
				'<p><b>%1$s</b>%2$s</p>',
				esc_html(__('Creating a connection: ', 'add-on-cf7-for-airtable')),
				esc_html(__(' Contact Forms ➜ Edit ➜ Airtable tab', 'add-on-cf7-for-airtable'))
			);
		}

		if ('setup' === $action) {
			$this->display_setup();
		} else {
			echo sprintf(
				'<p><a href="%1$s" class="button">%2$s</a></p>',
				esc_url($this->menu_page_url('action=setup')),
				esc_html(__('Setup integration', 'add-on-cf7-for-airtable'))
			);
		}
	}

	/**
	 * Returns whether a user uses an API key instead of an access token
	 * 
	 * @return  bool
	 */
	public function uses_api_key()
	{
		$token = $this->get_api_key();
		return 0 === strpos($token, 'key');
	}

	public function display_deprecated_key_notice()
	{
		$token_url     = 'https://airtable.com/create/tokens/';
		$settings_url = admin_url('admin.php?page=wpcf7-integration&service=wpc_airtable&action=setup');
		$message       = sprintf(
			/* Translators: %1$s = Access token URL; %2$s = Contact Form 7 Airtable settings page URL  */
			__('<strong>Contact Form 7 Airtable Add-On:</strong> Airtable API Keys will be deprecated by the end of January 2024. To ensure the security of your data and access all the features of our add-on, we recommend that you replace your API key with a personal access token. You can generate a new access token by <a href="%1$s" target="_blank" rel="noopener noreferer">following this link</a>, and then update your <a href="%2$s">Contact Form 7 Airtable settings</a> with the new token.', 'add-on-cf7-for-airtable'),
			esc_url($token_url),
			esc_url($settings_url)
		);
		printf('<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post($message));
	}

	/**
	 * Displays service form.
	 *
	 * @return void
	 */
	public function display_setup()
	{
		$api_key = $this->get_api_key();


?>
		<form method="post" action="<?php echo esc_url($this->menu_page_url('action=setup')); ?>">
			<?php wp_nonce_field('wpc-wpcf7-airtable-setup'); ?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="api_or_token">
								<?php
								echo esc_html(__('Airtable Access token', 'add-on-cf7-for-airtable'));
								echo tooltip(
									sprintf(
										/* Translators: %s = Airtable account URL; */
										__('Visit the <a href="%s" target="_blank">Account Overview</a> page in your Airtable account to generate an Access token.', 'add-on-cf7-for-airtable'),
										esc_url('https://airtable.com/account')
									)
								);
								?>
							</label>
						</th>
						<td>
							<?php
							if ($this->is_active()) {
								echo esc_html(wpcf7_mask_password($api_key, 4, 8));
								echo sprintf(
									'<input type="hidden" value="%s" id="api_key" name="api_key" />',
									esc_attr($api_key)
								);
							} else {
								echo sprintf(
									'<input type="text" aria-required="true" value="%s" id="api_key" name="api_key" class="regular-text code"/>',
									esc_attr($api_key)
								);
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
			echo sprintf('<p>%s</p>', __('Access tokens should at least be given the <code>data.records:write</code> and <code>schema.bases:read</code> scopes.', 'add-on-cf7-for-airtable'));

			if ($this->uses_api_key() || empty($api_key)) {
				$token_url     = 'https://airtable.com/create/tokens/';
				$settings_url = admin_url('admin.php?page=wpcf7-integration&service=wpc_airtable&action=setup');
				$message       = sprintf(
					/* Translators: %1$s = Access token URL; %2$s = Contact Form 7 Airtable settings page URL  */
					__('<strong>Contact Form 7 Airtable Add-On:</strong> Airtable API Keys will be deprecated by the end of January 2024. To ensure the security of your data and access all the features of our add-on, we recommend that you replace your API key with a personal access token. You can generate a new access token by <a href="%1$s" target="_blank" rel="noopener noreferer">following this link</a>, and then update your <a href="%2$s">Contact Form 7 Airtable settings</a> with the new token.', 'add-on-cf7-for-airtable'),
					esc_url($token_url),
					esc_url($settings_url)
				);
				printf('<div class="notice inline notice-warning"><p>%s</p></div>', wp_kses_post($message));
			}
			?>
			<?php
			if ($this->is_active()) {
				submit_button(
					_x('Remove key', 'API keys', 'add-on-cf7-for-airtable'),
					'small',
					'reset'
				);
			} else {
				submit_button(__('Save changes', 'add-on-cf7-for-airtable'));
			}
			?>
		</form>
<?php
	}
}
