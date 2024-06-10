<?php

namespace BitCode\FI\Actions\Getgist;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;


class RecordApiHelper
{
    private $_defaultHeader;

    public function __construct($api_key, $integId)
    {
        $this->_defaultHeader["Content-Type"] = 'application/json';
        $this->_defaultHeader["Authorization"] = "Bearer $api_key";
        $this->_integrationID = $integId;
    }

    public function createContact($data)
    {
        $data = \is_string($data) ? $data : \json_encode((object)$data);
        $insertRecordEndpoint = "https://api.getgist.com/contacts";
        return HttpHelper::post($insertRecordEndpoint, $data, $this->_defaultHeader);
    }

    public function generateReqDataFromFieldMap($data, $fieldMap, $integrationDetails)
    {

        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->getgistFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } else if (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        
        if (property_exists($integrationDetails, 'user_type') && property_exists($integrationDetails, 'userId') && $integrationDetails->user_type == 'User') {
            $dataFinal['user_id'] = $integrationDetails->userId;
        }
        return $dataFinal;
    }
    
    public function execute($integId,$fieldValues, $fieldMap,$integrationDetails)
    {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap,$integrationDetails);
        $apiResponse = $this->createContact($finalData);

        if (!property_exists($apiResponse, 'contact')) {
            LogHandler::save($integId, wp_json_encode(['type' => 'contacts', 'type_name' => "contact_add"]), 'error', wp_json_encode($apiResponse));
        } else {
            LogHandler::save($integId, wp_json_encode(['type' => 'contacts', 'type_name' => "contact_add"]), 'success', wp_json_encode($apiResponse));
        }
        return $apiResponse;
    }
}