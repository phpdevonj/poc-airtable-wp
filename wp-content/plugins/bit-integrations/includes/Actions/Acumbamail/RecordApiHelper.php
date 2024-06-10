<?php

/**
 * trello Record Api
 */

namespace BitCode\FI\Actions\Acumbamail;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $_integrationID;

    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID = $integId;
    }

    public function addSubscriber($auth_token, $listId, $finalData, $doubleOptin)
    {
        $apiEndpoints = 'https://acumbamail.com/api/1/addSubscriber/';
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $requestParams = [
            'auth_token' => $auth_token,
            'list_id' => $listId,
            'welcome_email' => 1,
            'update_subscriber' => 1,
            'merge_fields' => $finalData,
            'double_optin' => $doubleOptin ? 1 : 0,

        ];
        return HttpHelper::post($apiEndpoints, $requestParams, $header);
    }

    public function deleteSubscriber($auth_token, $listId, $finalData)
    {
        $apiEndpoints = 'https://acumbamail.com/api/1/deleteSubscriber/';

        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $requestParams = [
            'auth_token' => $auth_token,
            'list_id' => $listId,
            'email' => $finalData['email'],
        ];

        return HttpHelper::post($apiEndpoints, $requestParams, $header);
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->acumbamailFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } else if (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function execute(
        $listId,
        $mainAction,
        $fieldValues,
        $fieldMap,
        $auth_token,
        $doubleOptin
    ) {
        $fieldData = [];
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        if ($mainAction === '1') {
            $apiResponse = $this->addSubscriber($auth_token, $listId, $finalData, $doubleOptin);
        } elseif ($mainAction === '2') {
            $apiResponse = $this->deleteSubscriber($auth_token, $listId, $finalData);
        }
        if (property_exists($apiResponse, 'error')) {
            LogHandler::save($this->_integrationID, json_encode(['type' =>  'contact', 'type_name' => 'add-contact']), 'error', json_encode($apiResponse));
        } else {
            LogHandler::save($this->_integrationID, json_encode(['type' =>  'record', 'type_name' => 'add-contact']), 'success', json_encode($apiResponse));
        }
        return $apiResponse;
    }
}
