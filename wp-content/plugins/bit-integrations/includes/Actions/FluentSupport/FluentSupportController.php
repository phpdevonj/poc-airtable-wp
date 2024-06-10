<?php

/**
 * Fluent Support Integration
 */

namespace BitCode\FI\Actions\FluentSupport;

use WP_Error;
use BitCode\FI\Core\Util\IpTool;
use FluentSupport\App\Models\Agent;
use FluentSupport\App\Models\MailBox;

use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Actions\FluentSupport\RecordApiHelper;

/**
 * Provide functionality for Fluent Support integration
 */
class FluentSupportController
{
    public function checkAuthorization()
    {
        if (!is_plugin_active('fluent-support/fluent-support.php')) {
            wp_send_json_error(
                __(
                    'Fluent Support Plugin is not active or not installed',
                    'bit-integrations'
                ),
                400
            );
        } else {
            return true;
        }
    }

    public function getAllSupportStaff($tokenRequestParams)
    {
        $supportStaff = Agent::get();

        if (is_wp_error($supportStaff)) {
            wp_send_json_error(
                empty($supportStaff->error) ? 'Unknown' : $supportStaff->error,
                400
            );
        }
        wp_send_json_success(is_string($supportStaff) ? json_decode($supportStaff) : $supportStaff, 200);
    }

    public function getAllBusinessInboxes()
    {
        $businessInboxes = MailBox::all();

        if (is_wp_error($businessInboxes)) {
            wp_send_json_error(
                empty($businessInboxes->error) ? 'Unknown' : $businessInboxes->error,
                400
            );
        }
        wp_send_json_success(is_string($businessInboxes) ? json_decode($businessInboxes) : $businessInboxes, 200);
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integrationId = $integrationData->id;
        $fieldMap = $integrationDetails->field_map;

        if (empty($integrationDetails)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, required fields are empty', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationId);
        $fluentSupportApiResponse = $recordApiHelper->execute(
            $fieldValues,
            $fieldMap,
            $integrationDetails
        );

        if (is_wp_error($fluentSupportApiResponse)) {
            return $fluentSupportApiResponse;
        }
        return $fluentSupportApiResponse;
    }
}
