<?php

/**
 * BitForm Record Api
 */

namespace BitCode\FI\Actions\BitForm;

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

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->BitFormMapField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } else if (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function insertRecord($finalData, $api_key, $domainName,$formId)
    {
        if (
            empty($domainName)
            || empty($api_key)
            || empty($formId)
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
            'Bitform-Api-Key' => $api_key
        ];

        $apiEndpoint = $domainName . '/wp-json/bitform/v1/entry/' . $formId;

        return HttpHelper::post($apiEndpoint, $finalData, $authorizationHeader);
        
    }

    public function execute(
        $defaultDataConf,
        $fieldValues,
        $fieldMap,
        $api_key,
        $domainName,
        $formId
    ) {
        $fieldData = [];
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        
        $apiResponse = $this->insertRecord($finalData, $api_key, $domainName,$formId);
   
        if (property_exists($apiResponse, 'errors')) {
            LogHandler::save($this->_integrationID, json_encode(['type' =>  'contact', 'type_name' => 'add-contact']), 'error', json_encode($apiResponse));
        } else {
            LogHandler::save($this->_integrationID, json_encode(['type' =>  'record', 'type_name' => 'add-contact']), 'success', json_encode($apiResponse));
        }
        return $apiResponse;
    }
}
