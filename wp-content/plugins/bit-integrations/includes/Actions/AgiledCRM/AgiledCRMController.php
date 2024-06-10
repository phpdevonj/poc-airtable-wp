<?php

/**
 * AgiledCRM Integration
 */

namespace BitCode\FI\Actions\AgiledCRM;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for AgiledCRM integration
 */
class AgiledCRMController
{
    protected $_defaultHeader;

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $brand       = $fieldsRequestParams->brand;
        $apiKey      = $fieldsRequestParams->auth_token;
        $apiEndpoint = "https://my.agiled.app/api/v1/users?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (isset($response->data[0]->id)) {
            wp_send_json_success('Authentication successful', 200);
        } else {
            wp_send_json_error('Please enter valid Brand name & API key', 400);
        }
    }

    public function getAllOwners($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/sales-agents?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (isset($response->data[0]->id)) {
            foreach ($response->data as $owner) {
                $owners[] = [
                    'id'   => (string) $owner->id,
                    'name' => $owner->user->name . ' ' . $owner->user->last_name
                ];
            }
            wp_send_json_success($owners, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllAccounts($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/accounts?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $account) {
                $accounts[] = [
                    'id'   => (string) $account->id,
                    'name' => $account->name
                ];
            }
            wp_send_json_success($accounts, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllSources($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/crm-sources?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $source) {
                $sources[] = [
                    'id'   => (string) $source->id,
                    'name' => $source->type
                ];
            }
            wp_send_json_success($sources, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllStatuses($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/crm-statuses?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $status) {
                $statuses[] = [
                    'id'   => (string) $status->id,
                    'name' => $status->type
                ];
            }
            wp_send_json_success($statuses, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllLifeCycleStage($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/crm-stages?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $lifeCycleStage) {
                $lifeCycleStages[] = [
                    'id'   => (string) $lifeCycleStage->id,
                    'name' => $lifeCycleStage->type
                ];
            }
            wp_send_json_success($lifeCycleStages, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllCRMPipelines($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $apiEndpoint = "https://my.agiled.app/api/v1/crm/pipelines?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $pipeline) {
                $pipelines[] = [
                    'id'   => (string) $pipeline->id,
                    'name' => $pipeline->pipeline_name
                ];
            }
            wp_send_json_success($pipelines, 200);
        } else {
            wp_send_json_error('Pipelines fetching failed', 400);
        }
    }

    public function getAllCRMPipelineStages($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->brand) || empty($fieldsRequestParams->selectedCRMPipeline)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $brand       = $fieldsRequestParams->brand;
        $pipeline    = $fieldsRequestParams->selectedCRMPipeline;
        $apiEndpoint = "https://my.agiled.app/api/v1/crm/pipeline-stages?api_token=$apiKey";
        $header      = [
            'Brand' => $brand
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (!empty($response->data)) {
            foreach ($response->data as $pipelineStage) {
                if ($pipelineStage->pipeline_id == $pipeline) {
                    $pipelineStages[] = [
                        'id'   => (string) $pipelineStage->id,
                        'name' => $pipelineStage->stage_name
                    ];
                }
            }
            wp_send_json_success($pipelineStages, 200);
        } else {
            wp_send_json_error('Pipeline stages fetching failed', 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $authToken          = $integrationDetails->auth_token;
        $fieldMap           = $integrationDetails->field_map;
        $actionName         = $integrationDetails->actionName;

        if (empty($fieldMap) || empty($authToken) || empty($actionName)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Agiled CRM api', 'bit-integrations'));
        }

        $recordApiHelper   = new RecordApiHelper($integrationDetails, $integId);
        $agiledApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap, $actionName);

        if (is_wp_error($agiledApiResponse)) {
            return $agiledApiResponse;
        }
        return $agiledApiResponse;
    }
}
