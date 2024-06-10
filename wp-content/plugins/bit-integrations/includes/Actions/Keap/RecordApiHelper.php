<?php

/**
 * Keap Record Api
 */

namespace BitCode\FI\Actions\Keap;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert,upsert
 */
class RecordApiHelper
{
    private $_defaultHeader;
    private $_tokenDetails;
    private $_integrationID;

    public function __construct($tokenDetails, $integId)
    {
        $this->_defaultHeader['Content-Type'] = "application/json";
        $this->_tokenDetails = $tokenDetails;
        $this->_integrationID = $integId;
    }


    public function insertCard($data)
    {
        $data = \is_string($data) ? $data : \json_encode((object)$data);

        $header["Authorization"] = "Bearer {$this->_tokenDetails->access_token}";
        $header["Content-Type"] = "application/json";
        $insertRecordEndpoint = 'https://api.infusionsoft.com/crm/rest/v1/contact';
        return HttpHelper::post($insertRecordEndpoint, $data, $header);

    }

    public function insertTag($contactId, $tags)
    {
        $tagIds = explode(',', $tags);
        $allTagIds = [];
        foreach ($tagIds as $tag) {
            $allTagIds[] = (int)$tag;
        }

        $data['tagIds'] = $allTagIds;

        $header["Authorization"] = "Bearer {$this->_tokenDetails->access_token}";
        $header["Content-Type"] = "application/json";
        $insertTagEndpoint = 'https://api.infusionsoft.com/crm/rest/v1/contacts/' . $contactId . '/tags';

        return $response = HttpHelper::post($insertTagEndpoint, json_encode($data), $header);


    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        $billing_address = [
            "field" => "BILLING",
        ];
        $shipping_address = [
            "field" => "SHIPPING",
        ];
        $restOfdata = [];
        $anotherData = [];

        foreach ($fieldMap as $key => $value) {

            $triggerValue = $value->formField;
            $actionValue = $value->keapField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                if ($actionValue === 'billing_country_code') {
                    $billing_address = $billing_address + ["country_code" => $data[$triggerValue]];
                } elseif ($actionValue === 'billing_locality') {
                    $billing_address = $billing_address + ["locality" => $data[$triggerValue]];
                } elseif ($actionValue === 'billing_first_address_street') {
                    $billing_address = $billing_address + ["line1" => $data[$triggerValue]];
                } elseif ($actionValue === 'billing_second_address_street') {
                    $billing_address = $billing_address + ["line2" => $data[$triggerValue]];
                } elseif ($actionValue === 'billing_zip_code') {
                    $billing_address = $billing_address + ["zip_code" => $data[$triggerValue]];
                } elseif ($actionValue === 'shipping_country_code') {
                    $shipping_address = $shipping_address + ["country_code" => $data[$triggerValue]];
                } elseif ($actionValue === 'shipping_locality') {
                    $shipping_address = $shipping_address + ["locality" => $data[$triggerValue]];
                } elseif ($actionValue === 'shipping_first_address_street') {
                    $shipping_address = $shipping_address + ["line1" => $data[$triggerValue]];
                } elseif ($actionValue === 'shipping_second_address_street') {
                    $shipping_address = $shipping_address + ["line2" => $data[$triggerValue]];
                } elseif ($actionValue === 'shipping_zip_code') {

                    $shipping_address = $shipping_address + ["zip_code" => $data[$triggerValue]];
                } elseif ($actionValue === 'email_addresses') {
                    $restOfdata[$actionValue] = [(object) array(
                        "email" => $data[$triggerValue],
                        "field" => "EMAIL1"
                    )];
                } elseif ($actionValue === 'fax_numbers') {
                    $restOfdata[$actionValue] = [(object) array(
                        "field" => "FAX1",
                        "number" => $data[$triggerValue],
                        "type" => "string"
                    )];
                } elseif ($value->keapField === 'phone_numbers') {
                    $restOfdata[$actionValue] = [(object) array(
                        "extension" => "string",
                        "field" => "PHONE1",
                        "number" => $data[$triggerValue],
                    )];
                } else {
                    $anotherData[$actionValue] = $data[$triggerValue];
                }
            }
        }
        $addressMergeData["addresses"][0] = (object)$billing_address;
        $addressMergeData["addresses"][1] = (object)$shipping_address;

        $dataFinal = $addressMergeData + $restOfdata + $anotherData;
        return $dataFinal;
    }

    public function execute($defaultConf, $fieldValues, $fieldMap, $actions)
    {
        $fieldData = [];
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = $this->insertCard($finalData);

        if ($defaultConf->actions->tags || isset($apiResponse->id)) {
            $tagResponse = $this->insertTag($apiResponse->id, $defaultConf->selectedTags);
        }

        if (!(isset($apiResponse->id))) {
            LogHandler::save($this->_integrationID, ['type' =>  'contact', 'type_name' => 'add-contact'], 'error', $apiResponse);
        } else {
            LogHandler::save($this->_integrationID, ['type' =>  'record', 'type_name' => 'add-contact'], 'success', $apiResponse);
        }
        return $apiResponse;
    }
}
