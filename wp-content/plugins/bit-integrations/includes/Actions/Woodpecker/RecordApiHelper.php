<?php

/**
 * Woodpecker Record Api
 */

namespace BitCode\FI\Actions\Woodpecker;

use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $integrationDetails;
    private $integrationId;
    private $apiUrl;
    private $defaultHeader;
    private $type;
    private $typeName;

    public function __construct($integrationDetails, $integId, $apiKey)
    {
        $this->integrationDetails = $integrationDetails;
        $this->integrationId      = $integId;
        $this->apiUrl             = "https://api.woodpecker.co/rest/v1";
        $this->defaultHeader      = [
            "Authorization" => "Basic $apiKey",
            "Content-type"  => "application/json",
        ];
    }

    public function addProspects($finalData, $actionName, $actions)
    {
        if (empty($finalData['email'])) {
            return ['success' => false, 'message' => 'Required field Email is empty', 'code' => 400];
        }

        $requestData = [];
        if ($actionName === "adding_prospects_to_the_prospects_list") {
            $apiEndpoint    = $this->apiUrl . "/add_prospects_list";
            $this->typeName = 'Prospects created into Prospects List';
        } else {
            if (!isset($this->integrationDetails->selectedCampaign) || empty($this->integrationDetails->selectedCampaign)) {
                return ['success' => false, 'message' => 'Required Campaign field is empty', 'code' => 400];
            }

            $apiEndpoint    = $this->apiUrl . "/add_prospects_campaign";
            $requestData['campaign'] = (object) [
                "campaign_id" => $this->integrationDetails->selectedCampaign
            ];
            $this->typeName = 'Prospects created into Campaign List';
        }

        $requestData['update']      = $actions->update ? true : false;
        $requestData['prospects']   = [(object) $finalData];
        $this->type                 = 'Prospects';
        return HttpHelper::post($apiEndpoint, json_encode($requestData), $this->defaultHeader);
    }

    public function addCompany($finalData)
    {
        if (empty($finalData['name'])) {
            return ['success' => false, 'message' => 'Required field Company Name is empty', 'code' => 400];
        }

        $this->type     = 'Company';
        $this->typeName = 'Company created';
        $apiEndpoint    = $this->apiUrl . "/agency/companies/add";
        return HttpHelper::post($apiEndpoint, json_encode($finalData), $this->defaultHeader);
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $value) {
            $triggerValue = $value->formField;
            $actionValue  = $value->woodpeckerFormField;
            $dataFinal[$actionValue] = ($triggerValue === 'custom') ? $value->customValue : $data[$triggerValue];
        }
        return $dataFinal;
    }

    public function execute($fieldValues, $fieldMap, $actionName, $actions)
    {
        $finalData   = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        if ($actionName === "adding_prospects_to_the_prospects_list" || $actionName === "adding_prospects_to_the_campaign") {
            $apiResponse = $this->addProspects($finalData, $actionName, $actions);
        } else {
            $apiResponse = $this->addCompany($finalData);
        }

        if (isset($apiResponse->status) && $apiResponse->status->status === "ERROR") {
            LogHandler::save($this->integrationId, json_encode(['type' => $this->type, 'type_name' => $this->type . ' creating']), 'error', json_encode($apiResponse));
        } else {
            $res = [$this->typeName . '  successfully'];
            LogHandler::save($this->integrationId, json_encode(['type' => $this->type, 'type_name' => $this->typeName]), 'success', json_encode($res));
        }
        return $apiResponse;
    }
}
