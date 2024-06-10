<?php

/**
 * Acumbamail Integration
 */

namespace BitCode\FI\Actions\Acumbamail;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Trello integration
 */
class AcumbamailController
{
    private $baseUrl = 'https://acumbamail.com/api/1/';

    public function fetchAllLists($requestParams)
    {
        if (empty($requestParams->auth_token)) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }

        $apiEndpoints = $this->baseUrl . 'getLists/';

        $requestParams = [
            'auth_token' => $requestParams->auth_token,
        ];

        $response = HttpHelper::post($apiEndpoints, $requestParams);

        if ($response !== 'Unauthorized') {
            wp_send_json_success($response, 200);
        } else {
            wp_send_json_error(
                'The token is invalid',
                400
            );
        }
    }

    public function acumbamailAuthAndFetchSubscriberList($requestParams)
    {
        if (empty($requestParams->auth_token)) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $apiEndpoints = $this->baseUrl . 'getSubscribers/';

        $requestParams = [
            'auth_token' => $requestParams->auth_token,
        ];

        $response = HttpHelper::post($apiEndpoints, $requestParams);

        if ($response == 'Unauthorized' || $response == 'This endpoint is not available for non-paying customers' || $response == 'Your auth token has expired check /apidoc/ for the new one') {
            wp_send_json_error($response, 400);
        } else {
            wp_send_json_success($response, 200);
        }
    }

    public function acumbamailRefreshFields($refreshFieldsRequestParams)
    {
        if (empty($refreshFieldsRequestParams->auth_token) || empty($refreshFieldsRequestParams->list_id)) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $apiEndpoints = $this->baseUrl . 'getListFields/';

        $requestParams = [
            'auth_token' => $refreshFieldsRequestParams->auth_token,
            'list_id' => $refreshFieldsRequestParams->list_id,
        ];

        $response = HttpHelper::post($apiEndpoints, $requestParams);
        // error_log(print_r($response, true));
        // die;
        $formattedResponse = [];
        foreach ($response->fields as $value) {
            $formattedResponse[$value->name] = [
                "key"       => $value->tag,
                "label"     => $value->label,
                'required'  => $value->type === 'email' ? true : false,
            ];
        }

        if ($response !== 'Unauthorized') {
            wp_send_json_success($formattedResponse, 200);
        } else {
            wp_send_json_error(
                'The token is invalid',
                400
            );
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $auth_token = $integrationDetails->auth_token;
        $listId = $integrationDetails->listId;
        $mainAction = $integrationDetails->mainAction;
        $fieldMap = $integrationDetails->field_map;
        $doubleOptin = $integrationDetails->actions->double_optin;

        if (
            empty($listId)
            || empty($fieldMap)
            || empty($auth_token)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Acumbamail', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationDetails, $integId);
        $acumbamailApiResponse = $recordApiHelper->execute(
            $listId,
            $mainAction,
            $fieldValues,
            $fieldMap,
            $auth_token,
            $doubleOptin
        );

        if (is_wp_error($acumbamailApiResponse)) {
            return $acumbamailApiResponse;
        }
        return $acumbamailApiResponse;
    }
}
