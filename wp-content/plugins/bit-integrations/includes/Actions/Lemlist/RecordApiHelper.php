<?php

namespace BitCode\FI\Actions\Lemlist;

use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

class RecordApiHelper
{
    private $_integrationID;
    private $_integrationDetails;
    private $_defaultHeader;

    public function __construct($integrationDetails, $integId, $apiKey)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID      = $integId;
        $this->_defaultHeader      = [
            'Authorization' => 'Basic ' . base64_encode(":$apiKey"),
            'Content-Type'  => 'application/json'
        ];
    }

    public function updateLead($email, $data, $selectedCampaign)
    {
        $contactData = $data;
        $apiEndpoints = "https://api.lemlist.com/api/campaigns/{$selectedCampaign}/leads/{$email}";
        return  HttpHelper::request($apiEndpoints, 'PATCH', json_encode($contactData), $this->_defaultHeader);
    }

    public function addLead($selectedCampaign, $finalData)
    {
        $apiEndpoints = "https://api.lemlist.com/api/campaigns/{$selectedCampaign}/leads";
        $res =  HttpHelper::post($apiEndpoints, json_encode($finalData), $this->_defaultHeader);
        return $res;
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $value) {
            $triggerValue = $value->formField;
            $actionValue  = $value->lemlistField;

            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = $value->customValue;
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }

        return $dataFinal;
    }

    private function existLead($selectedCampaign, $email)
    {
        $apiEndpoints = "https://api.lemlist.com/api/leads/{$email}?campaignId={$selectedCampaign}";
        return HttpHelper::get($apiEndpoints, null, $this->_defaultHeader);
    }

    public function execute($selectedCampaign, $fieldValues, $fieldMap, $actions)
    {
        $finalData   = (object) $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $existLead = $this->existLead($selectedCampaign, $finalData->email);

        if (!$existLead->_id) {
            $apiResponse = $this->addLead($selectedCampaign, $finalData);

            if ($apiResponse->_id) {
                $res = ['message' => 'Lead added successfully'];
                LogHandler::save($this->_integrationID, json_encode(['type' => 'Lead', 'type_name' => 'Lead added']), 'success', json_encode($res));
            } else {
                LogHandler::save($this->_integrationID, json_encode(['type' => 'Lead', 'type_name' => 'Adding Lead']), 'error', json_encode($apiResponse));
            }
        } else {
            if ($actions->update) {
                $apiResponse = $this->updateLead($existLead->email, $finalData, $selectedCampaign);

                if ($apiResponse->_id) {
                    $res = ['message' => 'Lead updated successfully'];
                    LogHandler::save($this->_integrationID, json_encode(['type' => 'Lead', 'type_name' => 'Lead updated']), 'success', json_encode($res));
                } else {
                    LogHandler::save($this->_integrationID, json_encode(['type' => 'Lead', 'type_name' => 'updating Lead']), 'error', json_encode($apiResponse));
                }
            } else {
                LogHandler::save($this->_integrationID, ['type' => 'Lead', 'type_name' => 'Adding Lead'], 'error', 'Email address already exists in the system');
                wp_send_json_error('Email address already exists in the system', 400);
            }
        }

        return $apiResponse;
    }
}
