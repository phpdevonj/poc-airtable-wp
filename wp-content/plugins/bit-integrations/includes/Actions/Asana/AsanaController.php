<?php

/**
 * Asana Integration
 */

namespace BitCode\FI\Actions\Asana;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Asana integration
 */
class AsanaController
{
    protected $_defaultHeader;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiEndpoint = "https://app.asana.com/api/1.0/";
    }

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."users/me";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->data)) {
            wp_send_json_success('Authentication successful', 200);
        } else {
            wp_send_json_error('Please enter valid API key', 400);
        }
    }

    public function getCustomFields($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $action      = $fieldsRequestParams->action;
        $projectId      = $fieldsRequestParams->project_id;
        if ($action == 'task') {
            $apiEndpoint = $this->apiEndpoint."projects/".$projectId."/custom_field_settings";
        }

        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);
        if (isset($response->data)) {
            foreach ($response->data as $customField) {
                $customFields[] = [
                    'key' => $customField->custom_field->gid,
                    'label' => $customField->custom_field->name,
                    'required' => false,
                ];
            }
            wp_send_json_success($customFields, 200);
        } else {
            wp_send_json_error('Custom field fetching failed', 400);
        }
    }

    public function getAllTasks($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/tasks";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->tasks)) {
            foreach ($response->tasks as $task) {
                $tasks[] = [
                    'id'   => (string) $task->id,
                    'name' => $task->name
                ];
            }
            wp_send_json_success($tasks, 200);
        } else {
            wp_send_json_error('Task fetching failed', 400);
        }
    }


    public function getAllProjects($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."projects";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->data)) {
            foreach ($response->data as $project) {
                $projects[] = [
                    'id'   => $project->gid,
                    'name' => $project->name
                ];
            }
            wp_send_json_success($projects, 200);
        } else {
            wp_send_json_error('Projects fetching failed', 400);
        }
    }


    public function getAllSections($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;

        $apiEndpoint = $this->apiEndpoint."projects/".$fieldsRequestParams->selected_project."/sections";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];
        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->data)) {
            foreach ($response->data as $section) {
                $sections[] = [
                    'id'   => (string) $section->gid,
                    'name' => $section->name
                ];
            }
            wp_send_json_success($sections, 200);
        } else {
            wp_send_json_error('Sections fetching failed', 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $authToken          = $integrationDetails->api_key;
        $fieldMap           = $integrationDetails->field_map;
        $actionName         = $integrationDetails->actionName;

        if (empty($fieldMap) || empty($authToken) || empty($actionName)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Asana api', 'bit-integrations'));
        }

        $recordApiHelper   = new RecordApiHelper($integrationDetails, $integId);
        $asanaApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap, $actionName);

        if (is_wp_error($asanaApiResponse)) {
            return $asanaApiResponse;
        }
        return $asanaApiResponse;
    }
}
