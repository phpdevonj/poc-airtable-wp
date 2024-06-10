<?php

/**
 * Clickup Integration
 */

namespace BitCode\FI\Actions\Clickup;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Clickup integration
 */
class ClickupController
{
    protected $_defaultHeader;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiEndpoint = "https://api.clickup.com/api/v2/";
    }

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."user";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->user)) {
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
        $listId      = $fieldsRequestParams->list_id;
        if ($action == 'task') {
            $apiEndpoint = $this->apiEndpoint."list/".$listId."/field";
        }

        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);
        if (isset($response->fields)) {
            foreach ($response->fields as $customField) {
                $customFields[] = [
                    'key' => $customField->id,
                    'label' => $customField->name,
                    'type' => $customField->type,
                    'required' => $customField->required,
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
            "Authorization" =>$apiKey,
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


    public function getAllTeams($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."team";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);


        if (!empty($response->teams)) {
            foreach ($response->teams as $team) {
                $teams[] = [
                    'id'   => $team->id,
                    'name' => $team->name
                ];
            }
            wp_send_json_success($teams, 200);
        } else {
            wp_send_json_error('Teams fetching failed', 400);
        }
    }

    public function getAllSpaces($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $teamId     = $fieldsRequestParams->team_id;
        $apiEndpoint = $this->apiEndpoint."team/".$teamId."/space";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->spaces)) {
            foreach ($response->spaces as $space) {
                $spaces[] = [
                    'id'   => $space->id,
                    'name' => $space->name
                ];
            }
            wp_send_json_success($spaces, 200);
        } else {
            wp_send_json_error('Spaces fetching failed', 400);
        }
    }

    public function getAllFolders($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $spaceId     = $fieldsRequestParams->space_id;
        $apiEndpoint = $this->apiEndpoint."space/".$spaceId."/folder";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);


        if (!empty($response->folders)) {
            foreach ($response->folders as $folder) {
                $folders[] = [
                    'id'   => $folder->id,
                    'name' => $folder->name
                ];
            }
            wp_send_json_success($folders, 200);
        } else {
            wp_send_json_error('Folders fetching failed', 400);
        }
    }


    public function getAllLists($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $folderId     = $fieldsRequestParams->folder_id;
        $apiEndpoint = $this->apiEndpoint."folder/".$folderId."/list";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->lists)) {
            foreach ($response->lists as $list) {
                $lists[] = [
                    'id'   => $list->id,
                    'name' => $list->name
                ];
            }
            wp_send_json_success($lists, 200);
        } else {
            wp_send_json_error('Lists fetching failed', 400);
        }
    }

    public function getAllTags($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $spaceId     = $fieldsRequestParams->space_id;
        $apiEndpoint = $this->apiEndpoint."space/".$spaceId."/tag";
        $headers = [
            "Authorization" =>$apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);
        if (!empty($response->tags)) {
            foreach ($response->tags as $tag) {
                $tags[] = [
                    'id'   => $tag->id,
                    'name' => $tag->name
                ];
            }
            wp_send_json_success($tags, 200);
        } else {
            wp_send_json_error('Tags fetching failed', 400);
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
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Clickup api', 'bit-integrations'));
        }

        $recordApiHelper   = new RecordApiHelper($integrationDetails, $integId);
        $clickupApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap, $actionName);

        if (is_wp_error($clickupApiResponse)) {
            return $clickupApiResponse;
        }
        return $clickupApiResponse;
    }
}
