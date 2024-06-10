<?php

namespace BitCode\FI\Actions\CampaignMonitor;

use WP_Error;
use BitCode\FI\Flow\FlowController;
use BitCode\FI\Actions\CampaignMonitor\RecordApiHelper;
use BitCode\FI\Core\Util\HttpHelper;

class CampaignMonitorController
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = "https://api.createsend.com/api/v3.3";
    }

    private function setHeader($apiKey)
    {
        return [
            "Authorization" => 'Basic ' . base64_encode("{$apiKey}:"),
            "Accept" => "application/json"
        ];
    }

    private function checkValidation($apiKey, $clientId, $customParam = "**")
    {
        if (empty($apiKey) || empty($clientId) || empty($customParam)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }
    }

    public function authorization($requestParams)
    {
        $this->checkValidation($requestParams->api_key, $requestParams->client_id);
        $apiEndpoint = $this->baseUrl . "/clients/{$requestParams->client_id}.json";
        $headers     = $this->setHeader($requestParams->api_key);
        $response    = HttpHelper::get($apiEndpoint, null, $headers);

        if (!isset($response->ApiKey)) {
            wp_send_json_error(
                empty($response) ? 'Unknown' : $response,
                400
            );
        }
        wp_send_json_success(true);
    }

    public function getAllLists($requestParams)
    {
        $this->checkValidation($requestParams->api_key, $requestParams->client_id);
        $headers     = $this->setHeader($requestParams->api_key);
        $apiEndpoint = $this->baseUrl . "/clients/{$requestParams->client_id}/lists.json";
        $apiResponse = HttpHelper::get($apiEndpoint, null, $headers);
        $lists       = [];

        foreach ($apiResponse as $item) {
            $lists[] = [
                'listId' => $item->ListID,
                'listName'   => $item->Name
            ];
        }

        if ((count($lists)) > 0) {
            wp_send_json_success($lists, 200);
        } else {
            wp_send_json_error('Lists fetching failed', 400);
        }
    }

    public function getCustomFields($requestParams)
    {
        $this->checkValidation($requestParams->api_key, $requestParams->client_id, $requestParams->listId);
        $headers     = $this->setHeader($requestParams->api_key);
        $apiEndpoint = $this->baseUrl . "/lists/{$requestParams->listId}/customfields.json";
        $apiResponse = HttpHelper::get($apiEndpoint, null, $headers);
        $fields       = [];

        foreach ($apiResponse as $field) {
            $fields[] = [
                'key' => $field->Key,
                'label'   => $field->FieldName
            ];
        }

        if (!isset($apiResponse->Code)) {
            wp_send_json_success($fields, 200);
        } else {
            wp_send_json_error("Field fetching failed: {$apiResponse->Message}", 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $selectedList       = $integrationDetails->listId;
        $actions            = $integrationDetails->actions;
        $fieldMap           = $integrationDetails->field_map;
        $apiKey             = $integrationDetails->api_key;

        if (empty($fieldMap) || empty($apiKey) || empty($selectedList)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for CampaignMonitor api', 'bit-integrations'));
        }

        $recordApiHelper    = new RecordApiHelper($integrationDetails, $integId, $apiKey);
        $campaignMonitorApiResponse = $recordApiHelper->execute(
            $selectedList,
            $fieldValues,
            $fieldMap,
            $actions
        );
        if (is_wp_error($campaignMonitorApiResponse) || !filter_var($campaignMonitorApiResponse, FILTER_VALIDATE_EMAIL)) {
            return $campaignMonitorApiResponse->Message;
        }

        return $campaignMonitorApiResponse;
    }
}
