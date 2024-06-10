<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<table class="form-table">
	<?php wp_nonce_field( 'air-wp-sync-ajax', 'air-wp-sync-ajax-nonce' ); ?>
    <tr valign="top">
        <th scope="row">
            <label for="api_key">
                <span><?php esc_html_e( 'Access Token', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-required" aria-hidden="true">*</span>
                <span class="screen-reader-text"><?php esc_html_e( '(required)', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-tooltip" aria-label="<?php echo esc_attr__('Create your access token from <a href="https://airtable.com/create/tokens" target="_blank">https://airtable.com/create/tokens</a>', 'air-wp-sync') ?>">?</span>
            </label>
        </th>
        <td>
            <div :class="'airwpsync-field ' + getValidationCssClass('apiKey')">
                <input
                        x-model="config.api_key"
                        type="text"
                        name="api_key" type="text"
                        class="regular-text ltr"
                        :class="{'airwpsync-field--invalid': hasErrors('api_key')}"
                        data-rules='["required"]'
                        @blur="loadAirtableBases"
                />
                <p x-show="serverValidation.apiKey && !serverValidation.apiKey.valid" x-html="serverValidation.apiKey && serverValidation.apiKey.message"></p>
                <template x-for="message in getErrorMessages('api_key')">
                    <p class="airwpsync-validation-message" x-text="message"></p>
                </template>
                <p class="description"><?php echo wp_kses_post( __( 'Make sure your token has the <code>data.records:read</code> and <code>schema.bases:read</code> scopes.', 'air-wp-sync' ) ); ?></p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="app_id">
                <span><?php esc_html_e( 'Base', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-required" aria-hidden="true">*</span>
                <span class="screen-reader-text"><?php esc_html_e( '(required)', 'air-wp-sync' ); ?></span>
            </label>
        </th>
        <td>
            <div class="airwpsync-field">
                <select name="app_id" x-cloak x-model="config.app_id" class="regular-text ltr" @change="loadAirtableTables" :disabled="bases.length === 0 || loadingBases">
                    <template x-show="!loadingBases" x-for="base in bases" :key="base.id">
                        <option :value="base.id" :selected="base.id === config.app_id" x-html="loadingBases ? '' : base.name"></option>
                    </template>
                </select>
            </div>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">
            <label for="table">
                <span><?php esc_html_e( 'Table', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-required" aria-hidden="true">*</span>
                <span class="screen-reader-text"><?php esc_html_e( '(required)', 'air-wp-sync' ); ?></span>
            </label>
        </th>
        <td>
            <div class="airwpsync-field">
                <select name="table" x-cloak x-model="config.table" class="regular-text ltr" :disabled="tables.length === 0 || loadingTables" @change="onTableChange">
                    <template x-show="!loadingTables" x-for="table in tables" :key="table.id">
                        <option :value="table.id" :selected="table.id === config.table" x-html="loadingTables ? '' : table.name"></option>
                    </template>
                </select>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="view">
                <span><?php esc_html_e( 'View', 'air-wp-sync' ); ?></span>
            </label>
        </th>
        <td>
            <div class="airwpsync-field">
                <select name="view" x-cloak x-model="config.view" class="regular-text ltr" :disabled="loadingTables" @change="checkFormulaFilter">
                    <option value="" x-text="!loadingTables ? 'No View (all records)' : ''"></option>
                    <template x-show="!loadingTables" x-for="view in views" :key="view.id">
                        <option :value="view.id" :selected="view.id === config.view" x-html="loadingTables ? '' : view.name"></option>
                    </template>
                </select>
            </div>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">
            <label for="formula_filter">
                <span><?php esc_html_e( 'Filter By Formula', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-tooltip" aria-label="<?php echo esc_attr__('Optionally enter an airtable formula used to filter records. The formula will be evaluated for each record, and if the result is not 0, false, "", NaN, [], or #Error! the record will be imported. We recommend testing your formula in the Formula field UI before using it.', 'air-wp-sync') ?>">?</span>
            </label>
        </th>
        <td>
            <div :class="'airwpsync-field ' + getValidationCssClass('formulaFilter')">
                <input class="regular-text ltr" name="formula_filter" type="text" x-model="config.formula_filter" @blur="checkFormulaFilter" />
                <p x-show="serverValidation.formulaFilter && !serverValidation.formulaFilter.valid" x-text="serverValidation.formulaFilter && serverValidation.formulaFilter.message"></p>
            </div>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">
            <label for="enable_link_to_another_record">
                <span><?php esc_html_e( 'Include "Link to another record" field(s)', 'air-wp-sync' ); ?></span>
                <span class="airwpsync-tooltip" aria-label="<?php echo esc_attr(wp_kses(__('The <a href="https://www.airtable.com/guides/build/connect-data-with-linked-records" target="_blank">"Link to another record"</a> feature in Airtable enables creating relationships between records in different tables.', 'air-wp-sync'), [ 'a' => [ 'href' => [], 'target' => [] ] ])); ?>">?</span>
            </label>
        </th>
        <td>
            <fieldset class="airwpsync-field airwpsync-radioinline" id="enable_link_to_another_record">
                <input class="regular-text ltr" id="enable_link_to_another_record_yes" name="enable_link_to_another_record" type="radio" x-model="config.enable_link_to_another_record" @change="loadAirtableTables" value="yes"  x-on:change="showNoticeHandler('link-to-another-record-warning')"/><label for="enable_link_to_another_record_yes"><?php esc_html_e('Yes', 'air-wp-sync'); ?></label>
                <input class="regular-text ltr" id="enable_link_to_another_record_no" name="enable_link_to_another_record" type="radio" x-model="config.enable_link_to_another_record" @change="loadAirtableTables" value="no" /><label for="enable_link_to_another_record_no"><?php esc_html_e('No', 'air-wp-sync'); ?></label>
            </fieldset>
        </td>
    </tr>
    <tr x-show="config.enable_link_to_another_record === 'yes' && config.notices['link-to-another-record-warning']">
        <td colspan="2">
            <div class="notice notice-warning inline airwpsync-connection-warning">
                <p>
					<?php
					echo wp_kses( __( '<strong>Warning:</strong> Including "Link to another record" field(s) may extend synchronization times.<br /> Be aware that this could <strong>significantly increase the processing time.</strong><br /> Therefore, it might generate timeouts and you may need to contact your hosting provider.', 'air-wp-sync' ), [ 'strong' => [], 'br' => []] );
					?>
                </p>
                <button @click="hideNoticeHandler('link-to-another-record-warning')" class="button button-primary" type="button"><?php esc_html_e( 'I understood', 'air-wp-sync' ); ?></button>
            </div>
        </td>
    </tr>

</table>
<input type="hidden" name="content" :value="JSON.stringify(config)"/>
