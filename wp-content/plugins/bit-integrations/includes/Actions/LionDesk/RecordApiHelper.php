<?php

/**
 * LionDesk Record Api
 */

namespace BitCode\FI\Actions\LionDesk;

use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $integrationDetails;
    private $integrationId;
    private $tokenDetails;
    private $apiUrl;
    private $defaultHeader;
    private $type;
    private $typeName;

    public function __construct($integrationDetails, $integId, $tokenDetails)
    {
        $this->integrationDetails = $integrationDetails;
        $this->integrationId      = $integId;
        $this->tokenDetails       = $tokenDetails;
        $this->apiUrl             = "https://api-v2.liondesk.com/";
        $this->defaultHeader      = [
            "Authorization"     => "Bearer $tokenDetails->access_token",
            "Content-Type"      => "application/json"
        ];
    }

    public function addCampaign($finalData)
    {
        if (empty($finalData['name'])) {
            return ['success' => false, 'message' => 'Required field Name is empty', 'code' => 400];
        }
        
        $this->type     = 'Campaign';
        $this->typeName = 'Campaign created';
        $apiEndpoint = $this->apiUrl . "/campaigns";
        return HttpHelper::post($apiEndpoint, json_encode($finalData), $this->defaultHeader);
    }

    public function addContact($finalData)
    {
        if (empty($finalData['email'])) {
            return ['success' => false, 'message' => 'Required field Email is empty', 'code' => 400];
        }
        
        $staticFieldKeys = ['first_name', 'last_name', 'email', 'mobile_phone','home_phone', 'office_phone', 'fax', 'company', 'birthday', 'anniversary', 'spouse_name', 'spouse_email', 'spouse_phone', 'spouse_birthday', 'type', 'street_address_1', 'street_address_2', 'zip', 'city', 'state'];
        $address         = [];
        $requestParams   = [];
        $customParams    = [];

        foreach($finalData as $key => $value){
            if(in_array($key, $staticFieldKeys)){
                if($key === "type" ||$key === "street_address_1" ||$key === "street_address_2" ||$key === "zip" ||$key === "city" ||$key === "state" ){
                    $address[$key] = $value;
                }else{
                    $requestParams[$key] = $value;
                }
            }else{
                array_push($customParams, 
                (object)[
                    'id'    => $key,
                    'value' => $value
                ]);
            }
        }
        if (isset($this->integrationDetails->selectedTag) && !empty($this->integrationDetails->selectedTag)) {
            $requestParams['tags'] = ($this->integrationDetails->selectedTag);
        }
        if(count($customParams)){
            $requestParams["custom_fields"] = $customParams;
        }

        $this->type     = 'Contact';
        $this->typeName = 'Contact created';
        $apiEndpoint = $this->apiUrl . "/contacts";
        $apiResponse =  HttpHelper::post($apiEndpoint, json_encode($requestParams), $this->defaultHeader);
        
        if(isset($apiResponse->id) && count($address) > 0){
            $apiEndpoint = $this->apiUrl . "/contacts/$apiResponse->id/addresses";
            return HttpHelper::post($apiEndpoint, json_encode($address), $this->defaultHeader);
        }else{
            return $apiResponse;
        }
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $value) {
            $triggerValue = $value->formField;
            $actionValue  = $value->lionDeskFormField;
            $dataFinal[$actionValue] = ($triggerValue === 'custom') ? $value->customValue : $data[$triggerValue];
        }
        return $dataFinal;
    }

    public function execute($fieldValues, $fieldMap, $actionName)
    {
        $finalData   = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        if ($actionName === "campaign") {
            $apiResponse = $this->addCampaign($finalData);
        } else{
            $apiResponse = $this->addContact($finalData);
        }
        
        if (isset($apiResponse->id)) {
            $res = [$this->typeName . ' successfully'];
            LogHandler::save($this->integrationId, json_encode(['type' => $this->type, 'type_name' => $this->typeName]), 'success', json_encode($res));
        } else {
            LogHandler::save($this->integrationId, json_encode(['type' => $this->type, 'type_name' => $this->type . ' creating']), 'error', json_encode($apiResponse->message));
        }
        return $apiResponse;
    }
}
