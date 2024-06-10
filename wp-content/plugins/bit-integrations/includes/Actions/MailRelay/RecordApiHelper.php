<?php

/**
 * MailRelay Record Api
 */

namespace BitCode\FI\Actions\MailRelay;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $_integrationID;
    private $_requestStoringTypes;

    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID      = $integId;
        $this->_domainName         = $this->_integrationDetails->domain;
        $this->_defaultHeader      = [
            'X-AUTH-TOKEN' => $this->_integrationDetails->auth_token,
            'Content-Type' =>  'application/json'
        ];
    }

    public function addSubscriber($selectedGroups, $finalData, $status)
    {
        $baseUrl      = "https://{$this->_domainName}.ipzmarketing.com/api/v1/";
        $apiEndpoints = $baseUrl . 'subscribers';
        $groups       = [];

        if (!empty($selectedGroups)) {
            $splitSelectedGroups = explode(',', $selectedGroups);
            foreach ($splitSelectedGroups as $group) {
                $groups[] = $group;
            }
        }

        if (empty($finalData['email'])) {
            return ['success' => false, 'message' => 'Required field Email is empty', 'code' => 400];
        }

        $isSubscriberExist = $this->isExist($baseUrl, $finalData['email']);
        $requestParams     = [
            'status' => $status
        ];

        $staticFieldsKeys = ['email', 'name', 'address', 'city', 'state', 'country', 'birthday', 'website', 'locale', 'timezone'];
        $customFields     = [];

        foreach ($finalData as $key => $value) {
            if (in_array($key, $staticFieldsKeys)) {
                $requestParams[$key] = $value;
            } else {
                $customFields[$key] = $value;
            }
        }

        if (!empty($customFields)) {
            $requestParams['custom_fields'] = (object)$customFields;
        }

        if (!empty($groups)) {
            $requestParams['group_ids'] = $groups;
        }

        $apiRequestBody = json_encode($requestParams);

        if ($isSubscriberExist && !empty($this->_integrationDetails->actions->update)) {
            $apiEndpoints = $baseUrl . 'subscribers/' . $isSubscriberExist;
            $this->_requestStoringTypes = 'updated';
            return HttpHelper::request($apiEndpoints, 'PATCH', $apiRequestBody, $this->_defaultHeader);
        }

        $this->_requestStoringTypes = 'created';
        return HttpHelper::post($apiEndpoints,  $apiRequestBody, $this->_defaultHeader);
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $value) {
            $triggerValue = $value->formField;
            $actionValue  = $value->mailRelayFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function execute($selectedGroups, $fieldValues, $fieldMap, $status)
    {
        $finalData   = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = $this->addSubscriber($selectedGroups,  $finalData, $status);

        if ($apiResponse->id) {
            $res = ['message' => 'Subscriber ' . $this->_requestStoringTypes . ' successfully'];
            LogHandler::save($this->_integrationID, json_encode(['type' => 'subscriber', 'type_name' => 'Subscriber ' . $this->_requestStoringTypes]), 'success', json_encode($res));
        } else {
            LogHandler::save($this->_integrationID, json_encode(['type' => 'subscriber', 'type_name' => 'Adding Subscriber']), 'error', json_encode($apiResponse));
        }
        return $apiResponse;
    }

    public function isExist($baseUrl, $email)
    {
        $queryEndpoints = $baseUrl . 'subscribers?q%5Bemail_eq%5D=';
        $encodedEmail   = urlencode($email);
        $apiEndpoints   = $queryEndpoints . $encodedEmail;
        $response       = HttpHelper::get($apiEndpoints, null, $this->_defaultHeader);

        if (isset($response[0]->id)) {
            return $response[0]->id;
        }
        return false;
    }
}
