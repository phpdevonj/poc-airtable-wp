<?php

/**
 * SendGrid Integration
 */

namespace BitCode\FI\Actions\SendGrid;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for SendGrid integration
 */
class SendGridController
{
    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->apiKey)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiEndpoints = 'https://api.sendgrid.com/v3/marketing/field_definitions';
        $apiKey       = $fieldsRequestParams->apiKey;
        $header       = [
            'Authorization' => 'Bearer ' . $apiKey
        ];

        $response = HttpHelper::get($apiEndpoints, null, $header);

        if (!isset($response->errors)) {
            foreach ($response->custom_fields as $customField) {
                $customFields[] = [
                    'key'      => $customField->id,
                    'label'    => $customField->name,
                    'required' => false
                ];
            }
            wp_send_json_success($customFields, 200);
        } else {
            wp_send_json_error('Please enter valid API key', 400);
        }
    }

    public function getLists($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->apiKey)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiEndpoints = 'https://api.sendgrid.com/v3/marketing/lists';
        $apiKey       = $fieldsRequestParams->apiKey;
        $header       = [
            'Authorization' => 'Bearer ' . $apiKey
        ];

        $response = HttpHelper::get($apiEndpoints, null, $header);

        foreach ($response->result as $list) {
            $lists[] = [
                'id'   => $list->id,
                'name' => $list->name
            ];
        }

        if (!empty($lists)) {
            wp_send_json_success($lists, 200);
        } else {
            wp_send_json_error('Lists fetch failed', 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $apiKey             = $integrationDetails->apiKey;
        $selectedLists      = $integrationDetails->selectedLists;
        $fieldMap           = $integrationDetails->field_map;

        if (empty($fieldMap) || empty($apiKey)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for SendGrid api', 'bit-integrations'));
        }

        $recordApiHelper    = new RecordApiHelper($integrationDetails, $integId);
        $sendGridApiResponse = $recordApiHelper->execute(
            $selectedLists,
            $fieldValues,
            $fieldMap
        );

        if (is_wp_error($sendGridApiResponse)) {
            return $sendGridApiResponse;
        }
        return $sendGridApiResponse;
    }
}
