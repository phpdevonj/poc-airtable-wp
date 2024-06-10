<?php



namespace BitCode\FI\Actions\Rapidmail;

use WP_Error;
use BitCode\FI\Log\LogHandler;
use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Core\Util\DateTimeHelper;

/**
 * Provide functionality for Record insert,upsert
 */
class RecordApiHelper
{
    protected $_defaultHeader;
    public static $apiBaseUri = 'https://apiv3.emailsys.net/v1';

    public function __construct($integrationDetails, $username, $password)
    {
        $this->integrationDetails = $integrationDetails;
        $this->_defaultHeader = [
            'Authorization' => 'Basic ' . base64_encode("$username:$password"),
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'verify' => false
        ];
    }

    public function insertRecipientRecord($data, $send_activationmail)
    {
        $send_activationmail    = $send_activationmail ? 'yes' : 'no';
        $insertRecordEndpoint   = self::$apiBaseUri . "/recipients?send_activationmail={$send_activationmail}";
        $data                   = \is_string($data) ? $data : \json_encode((object)$data);
        $response               = HttpHelper::post($insertRecordEndpoint, $data, $this->_defaultHeader);
        return $response;
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->rapidmailFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } else if (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        $selectedRecipientList = $this->integrationDetails->recipient_id;
        $dataFinal['recipientlist_id'] = (int)$selectedRecipientList;
        return $dataFinal;
    }
    public function executeRecordApi($integId, $defaultConf, $recipientLists, $fieldValues, $fieldMap, $actions, $isRelated = false)
    {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = $this->insertRecipientRecord($finalData, $actions->send_activationmail);


        if (!isset($apiResponse->id)) {
            LogHandler::save($integId, wp_json_encode(['type' => 'recipient', 'type_name' => "recipient_add"]), 'error', wp_json_encode($apiResponse));
        } else {
            LogHandler::save($integId, wp_json_encode(['type' => 'recipient', 'type_name' => "recipient_add"]), 'success', wp_json_encode($apiResponse));
        }
        return $apiResponse;
    }



    public function formatFieldValue($value, $formatSpecs)
    {
        if (empty($value)) {
            return $value;
        }

        switch ($formatSpecs->json_type) {
            case 'jsonarray':
                $apiFormat = 'array';
                break;
            case 'jsonobject':
                $apiFormat = 'object';
                break;

            default:
                $apiFormat = $formatSpecs->json_type;
                break;
        }
        $formatedValue = '';
        $fieldFormat = gettype($value);
        if ($fieldFormat === $apiFormat && $formatSpecs->data_type !== 'datetime') {
            $formatedValue = $fieldFormat === 'string' ? html_entity_decode($value) : $value;
        } else {
            if ($apiFormat === 'array' || $apiFormat === 'object') {
                if ($fieldFormat === 'string') {
                    if (strpos($value, ',') === -1) {
                        $formatedValue = json_decode($value);
                    } else {
                        $formatedValue = explode(',', $value);
                    }
                    $formatedValue = is_null($formatedValue) && !is_null($value) ? [$value] : $formatedValue;
                } else {
                    $formatedValue = $value;
                }

                if ($apiFormat === 'object') {
                    $formatedValue = (object) $formatedValue;
                }
            } elseif ($apiFormat === 'string' && $formatSpecs->data_type !== 'datetime' && $formatSpecs->data_type !== 'date') {
                $formatedValue = !is_string($value) ? json_encode($value) : html_entity_decode($value);
            } elseif ($formatSpecs->data_type === 'datetime') {
                if (is_array($value)) {
                    if (isset($value['date'])) {
                        $value = $value['date'];
                        $date_format = 'm/d/Y';
                    } elseif (isset($value['time'])) {
                        $value = $value['time'];
                        $date_format = 'H:i A';
                    } elseif (isset($value['time']) && isset($value['date'])) {
                        $value = isset($value['date']) . ' ' . $value['time'];
                        $date_format = 'm/d/Y H:i A';
                    } else {
                        $value = '0000-00-00T00:00';
                        $date_format = 'Y-m-d\TH:i';
                    }
                } else {
                    $date_format = 'Y-m-d\TH:i';
                }
                $dateTimeHelper = new DateTimeHelper();
                $formatedValue = $dateTimeHelper->getFormated($value, $date_format, wp_timezone(), 'Y-m-d\TH:i:sP', null);
                $formatedValue = !$formatedValue ? null : $formatedValue;
            } elseif ($formatSpecs->data_type === 'date') {
                if (is_array($value)) {
                    if (isset($value['date'])) {
                        $value = $value['date'];
                        $date_format = 'm/d/Y';
                    } elseif (isset($value['time'])) {
                        $value = $value['time'];
                        $date_format = 'H:i A';
                    } elseif (isset($value['time']) && isset($value['date'])) {
                        $value = isset($value['date']) . ' ' . $value['time'];
                        $date_format = 'm/d/Y H:i A';
                    } else {
                        $value = '0000-00-00T00:00';
                        $date_format = 'Y-m-d\TH:i';
                    }
                } else {
                    $date_format = 'Y-m-d\TH:i';
                }
                $dateTimeHelper = new DateTimeHelper();
                $formatedValue = $dateTimeHelper->getFormated($value, $date_format, wp_timezone(), 'Y-m-d', null);
                $formatedValue = !$formatedValue ? null : $formatedValue;
            } else {
                $stringyfieldValue = !is_string($value) ? json_encode($value) : $value;

                switch ($apiFormat) {
                    case 'double':
                        $formatedValue = (float) $stringyfieldValue;
                        break;

                    case 'boolean':
                        $formatedValue = (bool) $stringyfieldValue;
                        break;

                    case 'integer':
                        $formatedValue = (int) $stringyfieldValue;
                        break;
                    default:
                        $formatedValue = $stringyfieldValue;
                        break;
                }
            }
        }
        if ($apiFormat === 'array' || $apiFormat === 'object') {
            $formatedValueLenght = is_countable($formatedValue) ? \count($formatedValue) : count(get_object_vars($formatedValue));
        } else {
            $formatedValueLenght =  \strlen($formatedValue);
        }
        if ($formatedValueLenght > $formatSpecs->length) {
            $formatedValue = $apiFormat === 'array' || $apiFormat === 'object' ? array_slice($formatedValue, 0, $formatSpecs->length) : substr($formatedValue, 0, $formatSpecs->length);
        }

        return $formatedValue;
    }
}
