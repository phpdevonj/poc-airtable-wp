<?php

/**
 * Mailjet Integration
 */

namespace BitCode\FI\Actions\Mailjet;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Mailjet integration
 */
class MailjetController
{
    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->secretKey) && empty($fieldsRequestParams->apiKey)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiEndpoints = 'https://api.mailjet.com/v3/REST/contactslist/';
        $apiKey       = $fieldsRequestParams->apiKey;
        $secretKey    = $fieldsRequestParams->secretKey;
        $header       = [
            'Authorization' => 'Basic ' . base64_encode("$apiKey:$secretKey")
        ];

        $response = HttpHelper::get($apiEndpoints, null, $header);

        if (!empty($response)) {
            foreach ($response->Data as $list) {
                $lists[] = [
                    'id'   => (string) $list->ID,
                    'name' => $list->Name
                ];
            }
            wp_send_json_success($lists, 200);
        } else {
            wp_send_json_error('Please enter valid API key', 400);
        }
    }

    public function getCustomFields($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->secretKey) && empty($fieldsRequestParams->apiKey)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiEndpoints = 'https://api.mailjet.com/v3/REST/contactmetadata?Limit=1000';
        $apiKey       = $fieldsRequestParams->apiKey;
        $secretKey    = $fieldsRequestParams->secretKey;
        $header       = [
            'Authorization' => 'Basic ' . base64_encode("$apiKey:$secretKey")
        ];

        $response = HttpHelper::get($apiEndpoints, null, $header);

        foreach ($response->Data as $customField) {
            $customFields[] = [
                'key'      => $customField->Name,
                'label'    => ucfirst(str_replace("_", " ", $customField->Name)),
                'required' => false
            ];
        }

        if (!empty($customFields)) {
            wp_send_json_success($customFields, 200);
        } else {
            wp_send_json_error('Custom fields fetch failed', 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $apiKey             = $integrationDetails->apiKey;
        $secretKey          = $integrationDetails->secretKey;
        $selectedLists      = $integrationDetails->selectedLists;
        $fieldMap           = $integrationDetails->field_map;

        if (empty($fieldMap) || empty($secretKey) || empty($apiKey) || empty($selectedLists)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Mailjet api', 'bit-integrations'));
        }

        $recordApiHelper    = new RecordApiHelper($integrationDetails, $integId, $apiKey, $secretKey);
        $mailjetApiResponse = $recordApiHelper->execute(
            $selectedLists,
            $fieldValues,
            $fieldMap
        );

        if (is_wp_error($mailjetApiResponse)) {
            return $mailjetApiResponse;
        }
        return $mailjetApiResponse;
    }
}
