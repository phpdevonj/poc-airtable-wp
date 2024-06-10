<?php

/**
 * PipeDrive    Record Api
 */
namespace BitCode\FI\Actions\PipeDrive;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $_integrationDetails;
    private $_integrationID;
    private $_defaultHeader;
    private $baseUrl = 'https://api.pipedrive.com/v1/';

    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        $this->_integrationID = $integId;
        $this->_defaultHeader = [
            'content-type' => 'application/json'
        ];
    }

    public function insertRecord(
        $module,
        $finalData
    ) {
        $moduleData = $this->_integrationDetails->moduleData;
        $apiEndpoints = $this->baseUrl . $module . '?api_token=' . $this->_integrationDetails->api_key;
        $actions = $this->_integrationDetails->actions;

        if ($module !== 'products') {
            if (isset($moduleData->organization_id)) {
                if ($module !== 'leads') {
                    $finalData['org_id'] = $moduleData->organization_id;
                } else {
                    $finalData['organization_id'] = $moduleData->organization_id;
                }
            }
            if (isset($moduleData->person_id)) {
                $finalData['person_id'] = $moduleData->person_id;
            }
            if ($module === 'leads' && isset($actions->currency) && !empty($actions->currency)) {
                $finalData['value'] = (object)[
                    'amount'  => isset($finalData['value']) ? (int) $finalData['value'] : 0,
                    'currency'=> $moduleData->currency,
                ];
                unset($finalData['currency']);
            }
            if ($module === 'leads' && !isset($actions->currency) && isset($finalData['value'])) {
                $finalData['value'] = (object)[
                    'amount'  => (int) $finalData['value']
                ];
                unset($finalData['value']);
            }
        }
        if (isset($moduleData->owner) && !empty($moduleData->owner)) {
            if (in_array($module, ['activites', 'notes', 'deals'])) {
                $finalData['user_id'] = (int) $moduleData->owner;
            } else {
                $finalData['owner_id'] = (int) $moduleData->owner;
            }
        }
        if (isset($moduleData->lead_label) && !empty($moduleData->lead_label)) {
            $finalData['label_ids'] = explode(',', $moduleData->lead_label);
        }
        if (isset($moduleData->deal_stage) && !empty($moduleData->deal_stage)) {
            $finalData['stage_id'] = (int) $moduleData->deal_stage;
        }
        if (isset($moduleData->activities_type) && !empty($moduleData->activities_type)) {
            $finalData['type'] = $moduleData->activities_type;
        }
        if (isset($actions->busy_flag) && !empty($actions->busy_flag)) {
            $finalData['busy_flag'] = true;
        }
        if (isset($actions->active_flag) && !empty($actions->active_flag)) {
            $finalData['active_flag'] = 0;
        }

        if (isset($actions->currency) && !empty($actions->currency)) {
            if ($module === 'deals') {
                $finalData['currency'] = $moduleData->currency;
            }

            if ($module === 'products') {
                $finalData['prices'] = [(object) [
                    'currency'               => $moduleData->currency,
                    'price'                  => isset($finalData['price']) ? (int) $finalData['price'] : 0,
                    'cost'                   => isset($finalData['cost']) ? (int) $finalData['cost'] : 0,
                    'overhead_cost'          => isset($finalData['overhead_cost']) ? (int) $finalData['overhead_cost'] : 0,
                ]];
                unset($finalData['price'], $finalData['cost'],$finalData['overhead_cost']);
            }
        }
        if ($module === 'products' && !isset($actions->currency)) {
            $finalData['prices'] = [(object) [
                'price'                  => isset($finalData['price']) ? (int) $finalData['price'] : 0,
                'cost'                   => isset($finalData['cost']) ? (int) $finalData['cost'] : 0,
                'overhead_cost'          => isset($finalData['overhead_cost']) ? (int) $finalData['overhead_cost'] : 0,
            ]];
            unset($finalData['price'], $finalData['cost'],$finalData['overhead_cost']);
        }
        if (isset($actions->deal_status) && !empty($actions->deal_status)) {
            $finalData['status'] = $moduleData->deal_status;
        }

        if (isset($actions->visible_to) && !empty($actions->visible_to)) {
            $finalData['visible_to'] = $moduleData->visible_to;
        }

        if (isset($actions->activities_participants) && !empty($actions->activities_participants)) {
            $participants = explode(',', $moduleData->activities_participants);
            $allParticipants = [];
            foreach ($participants as $participant) {
                array_push($allParticipants, (object)[
                    'person_id'   => (int) $participant,
                    'primary_flag'=> false
                ]);
            };
            $finalData['participants'] = $allParticipants;
        }
        $response = HttpHelper::post($apiEndpoints, wp_json_encode($finalData), $this->_defaultHeader);
        return $response;
    }

    public function addRelatedList($pipeDriveApiResponse, $integrationDetails, $fieldValues, $parentModule)
    {
        $parendId = $pipeDriveApiResponse->data->id;

        foreach ($integrationDetails->relatedlists as $item) {
            $fieldMap = $item->field_map;
            $module = strtolower($item->module);
            $moduleData = $item->moduleData;
            $actions = $item->actions;
            $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
            if (isset($moduleData->activities_type) && !empty($moduleData->activities_type)) {
                $finalData['type'] = $moduleData->activities_type;
            }
            if (isset($actions->busy_flag) && !empty($actions->busy_flag)) {
                $finalData['busy_flag'] = true;
            }
            if (isset($actions->active_flag) && !empty($actions->active_flag)) {
                $finalData['active_flag'] = 0;
            }
            if (isset($actions->activities_participants) && !empty($actions->activities_participants)) {
                $participants = explode(',', $moduleData->activities_participants);
                $allParticipants = [];
                foreach ($participants as $participant) {
                    array_push($allParticipants, (object)[
                        'person_id'   => (int) $participant,
                        'primary_flag'=> false
                    ]);
                };
                $finalData['participants'] = $allParticipants;
            }
            $apiEndpoints = $this->baseUrl . $module . '?api_token=' . $this->_integrationDetails->api_key;

            if ($parentModule === 'leads') {
                $finalData['lead_id'] = $parendId;
            } else {
                $finalData['deal_id'] = (int) $parendId;
            }

            $response = HttpHelper::post($apiEndpoints, wp_json_encode($finalData), $this->_defaultHeader);
            return $response;
        }
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];
        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->pipeDriveFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }

        return $dataFinal;
    }

    public function execute(
        $fieldValues,
        $fieldMap,
        $module
    ) {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = $this->insertRecord(
            $module,
            $finalData
        );

        if (isset($apiResponse->error)) {
            LogHandler::save($this->_integrationID, json_encode(['type' => $module, 'type_name' => 'add-' . $module]), 'error', json_encode($apiResponse));
        } else {
            LogHandler::save($this->_integrationID, json_encode(['type' => $module, 'type_name' => 'add-' . $module]), 'success', json_encode($apiResponse));
        }

        return $apiResponse;
    }
}
