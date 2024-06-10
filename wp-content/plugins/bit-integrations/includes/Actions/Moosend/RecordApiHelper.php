<?php

/**
 * Moosend Record Api
 */

namespace BitCode\FI\Actions\Moosend;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record Subscribe , Unsubscribe, Unsubscribe from list
 */
class RecordApiHelper
{
  private $_integrationID;
  private $baseUrl = 'https://api.moosend.com/v3/';


  public function __construct($integrationDetails, $integId)
  {
    $this->_integrationDetails = $integrationDetails;
    $this->_integrationID = $integId;
  }

  public function generateReqDataFromFieldMap($data, $field_map)
  {
    $dataFinal = [];

    foreach ($field_map as $key => $value) {
      $triggerValue = $value->formFields;
      $actionValue = $value->moosendFormFields;
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
    $res = ['success' => $code===200? true : false, 'message' => $apiResponse, 'code' => $code];
    LogHandler::save($this->_integrationID, json_encode(['type' => $type, 'type_name' => $typeName]), $status, json_encode($res));
    return $res;
  }

  public function subscribe($authKey,$listId,$formData)
  {
    $apiEndpoints = "{$this->baseUrl}subscribers/{$listId}/subscribe.json?apikey={$authKey}";
    
    $headers = [
      'Content-Type' => 'application/json'
    ];

    return HttpHelper::post($apiEndpoints, json_encode($formData), $headers);
  }
  public function unsubscribe($authKey,$formData)
  {
    $apiEndpoints = "{$this->baseUrl}subscribers/unsubscribe.json?apikey={$authKey}";
    $headers = [
      'Content-Type' => 'application/json'
    ];
    return HttpHelper::post($apiEndpoints, json_encode($formData), $headers);
  }
  public function unsubscribeFromList($authKey,$listId, $formData)
  {
    $apiEndpoints = "{$this->baseUrl}subscribers/{$listId}/unsubscribe.json?apikey={$authKey}";
    $headers = [
      'Content-Type' => 'application/json'
    ];
    return HttpHelper::post($apiEndpoints, json_encode($formData), $headers);
  }

  public function execute(
    $listId,
    $method,
    $fieldValues,
    $field_map,
    $authKey
  ) {
    $finalData = (object) $this->generateReqDataFromFieldMap($fieldValues, $field_map);

    switch ($method) {
      case 1:
        $apiResponse = $this->subscribe($authKey,$listId,$finalData);
        if ($apiResponse->Code!==0) {
          $this->response('error', 400, 'subscribe', 'Active-contact', $apiResponse);
        } else {
          $this->response('success', 200, 'subscribe', 'Active-contact', $apiResponse);
        }
        break;
        case 2:
          $apiResponse = $this->unsubscribeFromList($authKey,$listId,$finalData);
          if ($apiResponse->Code===300) {
            $this->response('error', 400, 'unsubscribe', 'unsubscribe-from-list', $apiResponse);
          } else {
            $this->response('success', 200, 'unsubscribe', 'unsubscribe-from-list', $apiResponse);
          }
          break;
      case 0:
        $apiResponse = $this->unsubscribe($authKey,$finalData);
        if ($apiResponse->Code===300) {
          $this->response('error', 400, 'unsubscribe', 'unsubscribe-contact', $apiResponse);
        } else {
          $this->response('success', 200, 'unsubscribe', 'unsubscribe-contact', $apiResponse);
        }
        break;
    }
    return $apiResponse;
  }
}
