<?php

/**
 * BitForm Integration
 */

namespace BitCode\FI\Actions\BitForm;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Actions\BitForm\RecordApiHelper;


/**
 * Provide functionality for BitForm integration
 */
class BitFormController
{

    public function bitFormAuthorization($requestParams)
    {
        if (
            empty($requestParams->app_domain)
            || empty($requestParams->api_key)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $authorizationHeader = [
            'Bitform-Api-Key' => $requestParams->api_key
        ];

        $apiEndpoint = $requestParams->app_domain . '/wp-json/bitform/v1/forms';
        $apiResponse = HttpHelper::get($apiEndpoint, null, $authorizationHeader, ['sslverify' => false]);

        if ($apiResponse->success) {
            $apiResponse;
            wp_send_json_success($apiResponse, 200);
        } else {
            wp_send_json_error(
                'There is an error .',
                400
            );
        }
    }

    public function bitFormAllFormList($requestParams)
    {
        if (
            empty($requestParams->app_domain)
            || empty($requestParams->api_key)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $authorizationHeader = [
            'Bitform-Api-Key' => $requestParams->api_key
        ];

        $apiEndpoint = $requestParams->app_domain . '/wp-json/bitform/v1/forms';
        $apiResponse = HttpHelper::get($apiEndpoint, null, $authorizationHeader, ['sslverify' => false]);

        if ($apiResponse->success) {
            wp_send_json_success($apiResponse, 200);
        } else {
            wp_send_json_error(
                'There is an error .',
                400
            );
        }
    }

    public function bitFormFetchSingleFormFields($requestParams)
    {
        if (
            empty($requestParams->app_domain)
            || empty($requestParams->api_key)
            || empty($requestParams->id)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $authorizationHeader = [
            'Bitform-Api-Key' => $requestParams->api_key
        ];

        $apiEndpoint = $requestParams->app_domain . '/wp-json/bitform/v1/fields/' . $requestParams->id;

        $apiResponse = HttpHelper::get($apiEndpoint, null, $authorizationHeader, ['sslverify' => false]);
        if ($apiResponse->success) {
            wp_send_json_success($apiResponse->fields, 200);
        } else {
            wp_send_json_error(
                'There is an error .',
                400
            );
        }
    }

    public function fetchAllBoards($queryParams)
    {
        if (
            empty($queryParams->accessToken)
            || empty($queryParams->clientId)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $response = [];
        $apiEndpoint = $this->baseUrl . "members/me?key=" . $queryParams->clientId . '&token=' . $queryParams->accessToken;
        $getUserInfoResponse = HttpHelper::get($apiEndpoint, null);
        $apiEndpoint = $this->baseUrl . 'members/' . $getUserInfoResponse->username . '/boards?key=' . $queryParams->clientId . '&token=' . $queryParams->accessToken;
        $allBoardResponse = HttpHelper::get($apiEndpoint, null);

        $allList = [];
        if (!is_wp_error($allBoardResponse) && empty($allBoardResponse->response->error)) {
            $boardLists = $allBoardResponse;
            foreach ($boardLists as $boardList) {
                $allList[] = (object) array(
                    'boardId' => $boardList->id,
                    'boardName' => $boardList->name
                );
            }
            uksort($allList, 'strnatcasecmp');
            $response['allBoardlist'] = $allList;
        } else {
            wp_send_json_error(
                $allBoardResponse->response->error->message,
                400
            );
        }
        wp_send_json_success($response, 200);
    }

    public function fetchAllLists($queryParams)
    {
        if (
            empty($queryParams->accessToken)
            || empty($queryParams->clientId)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $response = [];

        $apiEndpoint = $this->baseUrl  . "boards/" . $queryParams->boardId . "/lists?key=" . $queryParams->clientId . '&token=' . $queryParams->accessToken;
        $getListsResponse = HttpHelper::get($apiEndpoint, null);

        $allList = [];
        if (!is_wp_error($getListsResponse) && empty($getListsResponse->response->error)) {
            $singleBoardLists = $getListsResponse;
            foreach ($singleBoardLists as $singleBoardList) {
                $allList[] = (object) array(
                    'listId' => $singleBoardList->id,
                    'listName' => $singleBoardList->name
                );
            }
            uksort($allList, 'strnatcasecmp');
            $response['alllists'] = $allList;
        } else {
            wp_send_json_error(
                $allBoardResponse->response->error->message,
                400
            );
        }
        wp_send_json_success($response, 200);
    }

    /**
     * Save updated access_token to avoid unnecessary token generation
     *
     * @param Object $integrationData Details of flow
     * @param Array  $fieldValues     Data to send Mail Chimp
     *
     * @return null
     */
    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $formId = $integrationDetails->id;
        $api_key = $integrationDetails->api_key;
        $domainName = $integrationDetails->domainName;
        $integId = $integrationData->id;
        $fieldMap = $integrationDetails->field_map;
        $defaultDataConf = $integrationDetails->default;

        if (
            empty($fieldMap)
            || empty($defaultDataConf)
            || empty($api_key)
            || empty($domainName)
            || empty($formId)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Bit From api', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationDetails, $integId);
        $bitFormApiResponse = $recordApiHelper->execute(
            $defaultDataConf,
            $fieldValues,
            $fieldMap,
            $api_key,
            $domainName,
            $formId
        );

        if (is_wp_error($bitFormApiResponse)) {
            return $bitFormApiResponse;
        }
        return $bitFormApiResponse;
    }
}
