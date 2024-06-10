<?php

/**
 * Plugin's WPCF7 contact form properties.
 *
 * @package add-on-cf7-for-airtable
 */

namespace WPC_WPCF7_AT\CFP;

use WPC_WPCF7_AT\WPCF7_Airtable_Service;
use WPC_WPCF7_AT\Helpers;
use WPC_WPCF7_AT\WPCF7_Field_Mapper;

defined('ABSPATH') || exit;

/**
 * Registers the wpc_airtable contact form property.
 *
 * @param array $properties A list of WPCF7 properties.
 * @see 'wpcf7_pre_construct_contact_form_properties' filter hook
 */
function register_property($properties): array
{
	$service = WPCF7_Airtable_Service::get_instance();

	if ($service->is_active()) {
		$properties += array(
			'wpc_airtable' => array(),
		);
	}

	return $properties;
}


/**
 * Saves the wpc_airtable property value.
 *
 * @param WPCF7_ContactForm $contact_form A WPCF7_ContactForm instance.
 * @see 'wpcf7_save_contact_form' action hook
 */
function save_contact_form($contact_form)
{
	$service = WPCF7_Airtable_Service::get_instance();

	if (!$service->is_active()) {
		return;
	}

	// Nonce checked by WPCF7 {@see wpcf7_load_contact_form_admin}.
	$prop = array();
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$prop['enabled'] = isset($_POST['wpc-wpcf7-airtable']['enabled']);
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$prop['app_id_selected'] = isset($_POST['wpc-wpcf7-airtable']['app_id_selected']) ? sanitize_text_field(wp_unslash($_POST['wpc-wpcf7-airtable']['app_id_selected'])) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$prop['table_selected'] = isset($_POST['wpc-wpcf7-airtable']['table_selected']) ? sanitize_text_field(wp_unslash($_POST['wpc-wpcf7-airtable']['table_selected'])) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$prop['mapping'] = isset($_POST['wpc-wpcf7-airtable']['mapping']) ? array_map('sanitize_text_field', wp_unslash($_POST['wpc-wpcf7-airtable']['mapping'])) : array();
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$prop['map_types'] = isset($_POST['wpc-wpcf7-airtable']['map_types']) ? array_map('sanitize_text_field', wp_unslash($_POST['wpc-wpcf7-airtable']['map_types'])) : array();


	$contact_form->set_properties(
		array(
			'wpc_airtable' => $prop,
		)
	);
}


/**
 * Builds the editor panel for the wpc_airtable property.
 *
 * @param array $panels Contact Form 7 panels.
 * @see 'wpcf7_editor_panels' filter hook.
 */
function editor_panels($panels)
{
	$service = WPCF7_Airtable_Service::get_instance();

	if (!$service->is_active()) {
		return $panels;
	}

	$contact_form = \WPCF7_ContactForm::get_current();

	$prop = wp_parse_args(
		$contact_form->prop('wpc_airtable'),
		array(
			'enabled'         => true,
			'app_id_selected' => '',
			'table_selected'  => '',
			'mapping'         => array(),
			'map_types'       => array(),
		)
	);

	$editor_panel = function () use ($prop, $service, $contact_form) {
		$description = sprintf(
			/* translators: %s: html link */
			esc_html(__('You can set up the Airtable integration here. For details, see %s.', 'add-on-cf7-for-airtable')),
			str_replace(
				'<a',
				'<a target="_blank"',
				wpcf7_link(
					__('https://wordpress.org/plugins/add-on-cf7-for-airtable/#installation', 'add-on-cf7-for-airtable'),
					__('Airtable integration', 'add-on-cf7-for-airtable')
				)
			)
		);
		$app_id_selected = $prop['app_id_selected'];
		$table_selected  = $prop['table_selected'];
		$enabled         = $prop['enabled'];
		$mappings_selected = $prop['mapping'];

		$script_data = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('my-ajax-nonce'),
			'table_selected' => esc_js($table_selected)
		);

		wp_localize_script('wpcf7-airtable-js', 'MyScriptData', $script_data);

?>
		<?php
		$service = WPCF7_Airtable_Service::get_instance();
		$api_key = $service->get_api_key();; ?>
		<div class="wpc-wpcf7-airtable-wpco-icon">
			<a href="https://wpconnect.co/" target="_blank" rel="noopener noreferrer">
				<img src="<?php echo esc_url(WPCONNECT_WPCF7_AT_URL . 'assets/img/logo-wpconnect.png'); ?>" alt="icon wpconnect">
			</a>
		</div>
		<h2><?php echo esc_html(__('Airtable', 'add-on-cf7-for-airtable')); ?></h2>
		<fieldset>
			<legend><?php echo wp_kses_post($description); ?></legend>

			<table id="wpc-wpcf7-airtable-setup-table" class="form-table <?php echo !$enabled ? ' is-disabled' : ''; ?>" role="presentation">
				<tbody>
					<tr class="wpc-wpcf7-airtable-enabled-field-block">
						<th scope="row">
							<?php
							echo esc_html(
								__('Add form submissions to your table', 'add-on-cf7-for-airtable')
							);
							?>
						</th>
						<td>
							<input type="checkbox" name="wpc-wpcf7-airtable[enabled]" id="wpc-wpcf7-airtable-enabled" value="1" <?php checked($enabled); ?> />
						</td>
					</tr>
					<?php
					if (strpos($api_key, 'key') === 0) { ?>
						<tr class="">
							<th scope="row">
								<p>
									<?php
									echo esc_html(__('Table lookup', 'add-on-cf7-for-airtable'));
									Helpers\tooltip(__('Paste full Airtable table URL, it will populate the Base ID and Table ID fields.', 'add-on-cf7-for-airtable'));
									?>
								</p>
							</th>
							<td>
								<input type="search" name="wpc-wpcf7-airtable[table_lookup]" id="wpc-wpcf7-airtable-table-lookup" value="" placeholder="Paste Airtable table URL here" />
							</td>
						</tr>
					<?php };
					if (strpos($api_key, 'key') === 0) { ?>
						<tr>
							<th scope="row">
								<p>
									<?php
									echo esc_html(__('Base ID', 'add-on-cf7-for-airtable'));
									Helpers\tooltip(
										esc_html__('Use the Table lookup field above or visit the link below to find your Base ID', 'add-on-cf7-for-airtable')
											. '<br /><a href="https://airtable.com/api" target="_blank">https://airtable.com/api</a>'
									);
									?>
								</p>
							</th>
							<td>
								<input type="text" name="wpc-wpcf7-airtable[app_id_selected]" id="wpc-wpcf7-airtable-app-id-selected" value="<?php echo esc_attr($app_id_selected); ?>" />
							</td>
						</tr>
					<?php } else { ?>

						<tr>
							<th scope="row">
								<p>
									<?php
									echo esc_html(__('Base name', 'add-on-cf7-for-airtable'));
									Helpers\tooltip(
										esc_html__('Select the target database from the options below', 'add-on-cf7-for-airtable')
									);
									?>
								</p>
							</th>
							<td>
								<?php
								$bases = Helpers\get_airtable_bases();
								?>
								<select name="wpc-wpcf7-airtable[app_id_selected]" id="wpc-wpcf7-airtable-app-id-selected" onchange="fetchAirtableTables(this.value)">
									<option value="" selected><?php echo esc_html__('Choose a base', 'add-on-cf7-for-airtable'); ?></option>
									<?php foreach ($bases as $base_id => $base_name) : ?>
										<option value="<?php echo esc_attr($base_id); ?>" <?php selected($base_id, $app_id_selected); ?>>
											<?php echo esc_html($base_name['name']); ?>
										</option>
									<?php endforeach; ?>
								</select>

							</td>
						</tr>
					<?php } ?>
					<?php
					if (strpos($api_key, 'key') === 0) { ?>
						<tr>
							<th scope="row">
								<p>
									<?php
									echo esc_html(__('Table ID', 'add-on-cf7-for-airtable'));
									Helpers\tooltip(
										esc_html__('Use the Table lookup field above or visit the link below to find your Table ID', 'add-on-cf7-for-airtable')
											. '<br /><a href="https://airtable.com/api" target="_blank">https://airtable.com/api</a>'
									);
									?>
								</p>
							</th>
							<td>
								<input type="text" name="wpc-wpcf7-airtable[table_selected]" id="wpc-wpcf7-airtable-table-selected" value="<?php echo esc_attr($table_selected); ?>" />
							</td>
						</tr>
					<?php
					} else { ?>
						<tr>
							<th scope="row">
								<p>
									<?php
									echo esc_html(__('Table name', 'add-on-cf7-for-airtable'));
									Helpers\tooltip(
										esc_html__('Select the target table from the options below.', 'add-on-cf7-for-airtable')
									);
									?>
								</p>
							</th>

							<td>
								<select name="wpc-wpcf7-airtable[table_selected]" id="wpc-wpcf7-airtable-table-id-selected">
									<option value="-1" selected><?php echo esc_html__('Choose a table', 'add-on-cf7-for-airtable'); ?></option>
								</select>
							</td>
						</tr>
					<?php } ;?>
				</tbody>
			</table>
			<?php if (strpos($api_key, 'key') !== 0) { ?>
				<div class="notice inline notice-error">
					<p><?php echo esc_html(__('Please save your settings before mapping your fields.', 'add-on-cf7-for-airtable'));
						?></p>
				</div>
			<?php };

			if ($table_selected) {
				$field_mapper = WPCF7_Field_Mapper::get_instance();

				if (strpos($api_key, 'key') === 0) {
					$columns = Helpers\get_airtable_table_columns($app_id_selected, $table_selected);
				} else {
					$columns = Helpers\get_airtable_table_columns_token($app_id_selected, $table_selected);
				}

				$mapped_tags = Helpers\get_mapped_tags_from_contact_form($contact_form);
			?>
				<div id="wpc-wpcf7-airtable-fields-table" class="<?php echo !$enabled ? ' is-disabled' : '';
																	?>">
					<h3><?php echo esc_html(__('Table fields', 'add-on-cf7-for-airtable'));
						?></h3>
						<?php if (strpos($api_key, 'key') === 0) {?>
					<p>
						<?php echo esc_html(__('Enter an Airtable field name for each Contact Form 7 field to map them.', 'add-on-cf7-for-airtable'));
						?><br />
						<?php echo esc_html(__('Be careful, field names should be exactly the same (case sensitive) or the form won\'t be saved.', 'add-on-cf7-for-airtable'));
						?>
					</p><?php }?>

					<?php
					$first_field = current($mapped_tags);
					if ($first_field && $first_field['column_type_was_empty']) {

					?>
						<p><strong><?php echo esc_html(__('Starting from the 1.1.0 version, you can now specify the Airtable field type in the mapping below, please double check all types are fine.', 'add-on-cf7-for-airtable'));
									?></strong></p>
					<?php
					}
					?>

					<table class="widefat fixed striped" style="max-width: 700px;">
						<thead>
							<tr>
								<th><?php echo esc_html(__('Contact Form 7 field', 'add-on-cf7-for-airtable'));
									?></th>
								<th><?php echo esc_html(__('Airtable field name', 'add-on-cf7-for-airtable'));
									?></th>
								<th><?php echo esc_html(__('Airtable field type', 'add-on-cf7-for-airtable'));
									?></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$mapped_columns         = array();
							$available_columns_name = array_map(
								function ($column) {
									return $column['name'];
								},
								$columns
							);

							foreach ($contact_form->scan_form_tags() as $tag) {
								if (empty($tag->name)) {
									continue;
								}

							?>
								<tr>
									<?php
									$tag_name             = $tag->name;
									$selected_column_name = '';
									$mapped_class         = '';
									$mapped_text          = $tag_name;
									$mapped_error_desc    = '';
									$selected_column_type = '';
									if (isset($mapped_tags[$tag_name]) && in_array($mapped_tags[$tag_name]['airtable_field_name'], $available_columns_name)) {
										$selected_column_name = $mapped_tags[$tag_name]['airtable_field_name'];
										$selected_column_type = $mapped_tags[$tag_name]['airtable_field_type'];

										$mapped_class = 'is-mapped';
										/* translators: %s: tag name */
										$mapped_text = sprintf(__('%s: mapped', 'add-on-cf7-for-airtable'), $tag_name);
									}
									if (!empty($selected_column_name)) {
										$mapped_columns[] = $selected_column_name;
									}

									// Reverse the types keys (the last one should be the default one), get labels from get_airtable_fields_types.
									$options_keys   = array_flip(array_reverse($field_mapper->get_field_compatible_airtable_types($tag->basetype, Helpers\tag_has_multiple_value($tag))));
									$options_labels = array_intersect_key($field_mapper->get_airtable_fields_types(), $options_keys);
									$options        = array_merge($options_keys, $options_labels);

									$has_available_mapping = count($options) > 0;


									?>
									<td class="<?php echo esc_attr($mapped_class);
												?>">
										<?php
										echo esc_html($tag_name);

										?>
										<div class="screen-reader-text"><?php echo esc_html($mapped_text);
																		?></div>
										<?php
										if (!empty($mapped_error_desc)) {

										?>
											<div class="wpc-wpcf7-airtable-error"><?php echo esc_html($mapped_error_desc);
																					?></div>
										<?php
										}

										?>
									</td>
									
										<?php if (strpos($api_key, 'key') === 0) { ?>
											<td>
											<input name="wpc-wpcf7-airtable[mapping][<?php echo esc_attr($tag_name); ?>]" value="<?php echo esc_attr($selected_column_name); ?>" />
											</td>
										<?php
										} else {
											echo '<td>';
											echo Helpers\generate_airtable_fields_select($app_id_selected, $table_selected, $tag_name, $mappings_selected);
											echo '</td>';
										} ?>
									
									<td>
										<?php
										if ($has_available_mapping) {
											printf('<select class="wpc-wpf-at-field-mapper-type" name="wpc-wpcf7-airtable[map_types][%s]">', esc_attr($tag_name));
											foreach ($options as $option_value => $option_text) {
												printf('<option value="%s" %s>%s</option>', esc_attr($option_value), ($selected_column_type === $option_value ? 'selected="selected"' : ''), esc_html($option_text));
											}
											printf('</select>');
										}

										?>
									</td>
								</tr>
							<?php
							}

							?>
						</tbody>
						<tr></tr>
					</table>

					<?php

					$unmapped_columns_name = array_diff($available_columns_name, $mapped_columns);
					if (count($available_columns_name) > 0 && count($unmapped_columns_name) > 0) {
					?>
						<p class="unmapped-columns"><strong>
								<?php
								echo esc_html(_n('The Airtable\'s field name below is not mapped yet:', 'The Airtable\'s fields name below are not mapped yet:', count($unmapped_columns_name), 'add-on-cf7-for-airtable'));
								echo '<br />' . esc_html(implode(', ', $unmapped_columns_name));
								?>
							</strong></p>
					<?php
					}
					?>
				</div>
			<?php
			}
			?>
		</fieldset>
<?php
	};

	$panels += array(
		'wpc-airtable-panel' => array(
			'title'    => __('Airtable', 'add-on-cf7-for-airtable'),
			'callback' => $editor_panel,
		),
	);

	return $panels;
}
