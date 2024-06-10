<?php

/**
 * SendGrid Record Api
 */

namespace BitCode\FI\Actions\SendGrid;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, update
 */

class RecordApiHelper
{
    private $_integrationID;
    private $_responseType;

    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID      = $integId;
        $this->_defaultHeader      = [
            'Authorization' => 'Bearer ' . $integrationDetails->apiKey,
            'Content-Type'  => 'application/json'
        ];
    }

    public function addContact($selectedLists, $finalData)
    {
        $apiEndpoints = 'https://api.sendgrid.com/v3/marketing/contacts';

        if (empty($finalData['email'])) {
            return ['success' => false, 'message' => 'Required field Email is empty', 'code' => 400];
        }

        $this->_responseType = $this->isExist($finalData['email']);

        if (!empty($selectedLists)) {
            $lists = explode(',', $selectedLists);
            $requestParams['list_ids'] = $lists;
        }

        $staticFieldsKeys = [
            'email', 'first_name', 'last_name', 'alternate_emails', 'address_line_1', 'address_line_2', 'city',
            'state_province_region', 'postal_code', 'country', 'phone_number', 'whatsapp', 'line', 'facebook', 'unique_name'
        ];

        foreach ($finalData as $key => $value) {
            if (in_array($key, $staticFieldsKeys)) {
                $contacts[$key] = $value;
            } else {
                $customFields[$key] = $value;
            }
        }

        if (!empty($customFields)) {
            $contacts['custom_fields'] = (object) $customFields;
        }

        $requestParams['contacts'][] = (object) $contacts;

        return HttpHelper::request($apiEndpoints, 'PUT', json_encode($requestParams), $this->_defaultHeader);
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $value) {
            $triggerValue = $value->formField;
            $actionValue  = $value->sendGridFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function execute($selectedLists, $fieldValues, $fieldMap)
    {
        $finalData   = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = $this->addContact($selectedLists,  $finalData);

        if (!isset($apiResponse->errors)) {
            $res = ['message' => 'Contact ' . $this->_responseType . ' successfully'];
            LogHandler::save($this->_integrationID, json_encode(['type' => 'contact', 'type_name' => 'Contact ' . $this->_responseType]), 'success', json_encode($res));
        } else {
            LogHandler::save($this->_integrationID, json_encode(['type' => '', 'type_name' => 'Adding contact']), 'error', json_encode($apiResponse));
        }
        return $apiResponse;
    }

    private function isExist($email)
    {
        $apiEndpoint      = 'https://api.sendgrid.com/v3/marketing/contacts/search/emails';
        $emails['emails'] = (array) $email;
        $response         = HttpHelper::post($apiEndpoint, json_encode($emails), $this->_defaultHeader);

        return empty($response) ? 'created' : 'updated';
    }
}
