<?php

/**
 * Mailercloud Record Api
 */

namespace BitCode\FI\Actions\Mailercloud;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record Add Contact
 */
class RecordApiHelper
{
    private $_integrationID;
    private $_integrationDetails;
    private $baseUrl = 'https://cloudapi.mailercloud.com/v1/';


    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID = $integId;
    }

    public function addContact($authKey, $data)
    {
        if (empty($data->email)) {
            return ['success' => false, 'message' => 'Required field opportunity name is empty', 'code' => 400];
        }
        $staticFieldsKeys = ['city', 'country', "details", 'department', 'dob', 'email', 'industry', 'job_title', 'last_name', 'lead_source', 'middle_name', 'name', 'organization', 'phone', 'salary', 'state', 'zip','contact_type', 'list_id'];

        foreach ($data as $key => $value) {
            if (in_array($key, $staticFieldsKeys)) {
                $finalData[$key] = $value;
            } else {
                $finalData['custom_fields'][$key] =$value;
            }
        }


        $apiEndpoints = "{$this->baseUrl}contacts";
        $headers = [
          'Content-Type' => 'application/json',
          'Authorization' => $authKey
        ];

        return HttpHelper::post($apiEndpoints, json_encode($finalData), $headers);
    }

    public function generateReqDataFromFieldMap($data, $field_map)
    {
        $dataFinal = [];

        foreach ($field_map as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->mailercloudFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }
    public function response($status, $code, $type, $typeName, $apiResponse)
    {
        $res = ['success' =>$code===200 ? true : false, 'message' => $apiResponse, 'code' => $code];
        LogHandler::save($this->_integrationID, json_encode(['type' => $type, 'type_name' => $typeName]), $status, json_encode($res));
        return $res;
    }

    public function execute(
        $listId,
        $contactType,
        $fieldValues,
        $field_map,
        $authKey
    ) {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $field_map);
        $data = (object)$finalData;
        $data->list_id = $listId;
        $data->contact_type = $contactType;
        $apiResponse = $this->addContact($authKey, $data);
        if ($apiResponse->errors) {
            $this->response('error', 400, 'contact', 'add-contact', $apiResponse);
        } else {
            $this->response('success', 200, 'contact', 'add-contact', $apiResponse);
        }
        return $apiResponse;
    }
}
