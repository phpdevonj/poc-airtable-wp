<?php
namespace BitCode\FI\Actions\SureCart;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

class RecordApiHelper
{
    private $_integrationID;

    public function __construct($integrationId)
    {
        $this->_integrationID = $integrationId;
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->SureCartFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function createCustomer($finalData, $api_key)
    {
        $requestData = [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'User-Agent' => 'bit-integrations',
                'Content-Type' => 'application/json',
            ],
            'timeout' => 60,
            'sslverify' => false,
            'data_format' => 'body',
            'body' => wp_json_encode(
                [
                    'customer' => [
                        'name' => $finalData['customer_first_name'] . ' ' . $finalData['customer_last_name'],
                        'email' => $finalData['customer_email'],
                        'phone' => $finalData['customer_phone'],
                        'live_mode' => true,
                    ],
                ]
            ),
        ];

        $request = wp_remote_post('https://api.surecart.com/v1/customers', $requestData);
        $response_code = wp_remote_retrieve_response_code($request);
        $response_body = wp_remote_retrieve_body($request);

        return [$response_body, $response_code];
    }

    public function execute(
        $api_key,
        $fieldValues,
        $fieldMap,
        $integrationDetails,
        $mainAction
    ) {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);

        if ($mainAction == '1') {
            $apiResponse = $this->createCustomer($finalData, $api_key);
            if ($apiResponse[1] === 200) {
                LogHandler::save($this->_integrationID, json_encode(['type' => 'create', 'type_name' => 'create-customer']), 'success', $apiResponse[0]);
            } else {
                LogHandler::save($this->_integrationID, json_encode(['type' => 'create', 'type_name' => 'create-customer']), 'error', $apiResponse[0]);
            }
        }
        return $apiResponse;
    }
}
