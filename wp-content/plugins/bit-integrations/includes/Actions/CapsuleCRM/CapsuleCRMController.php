<?php

/**
 * CapsuleCRM Integration
 */

namespace BitCode\FI\Actions\CapsuleCRM;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for CapsuleCRM integration
 */
class CapsuleCRMController
{
    protected $_defaultHeader;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiEndpoint = "https://api.capsulecrm.com/api/v2";
    }

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/users";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->users)) {
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
        if ($action == 'person' || $action == 'organisation') {
            $apiEndpoint = $this->apiEndpoint."/parties/fields/definitions";
        } elseif ($action == 'opportunity') {
            $apiEndpoint = $this->apiEndpoint."/opportunities/fields/definitions";
        } elseif ($action == 'project') {
            $apiEndpoint = $this->apiEndpoint."/kases/fields/definitions";
        }

        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->definitions)) {
            foreach ($response->definitions as $customField) {
                $customFields[] = [
                    'key' => $customField->id,
                    'label' => $customField->name,
                    'required' => $customField->important,
                ];
            }
            wp_send_json_success($customFields, 200);
        } else {
            wp_send_json_error('Custom field fetching failed', 400);
        }
    }

    public function getAllOpportunities($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/opportunities";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->opportunities)) {
            foreach ($response->opportunities as $opportunity) {
                $opportunities[] = [
                    'id'   => (string) $opportunity->id,
                    'name' => $opportunity->name
                ];
            }
            wp_send_json_success($opportunities, 200);
        } else {
            wp_send_json_error('Opportunity fetching failed', 400);
        }
    }

    public function getAllOwners($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/users";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->users)) {
            foreach ($response->users as $owner) {
                $owners[] = [
                    'id'   => (string) $owner->id,
                    'name' => $owner->name
                ];
            }
            wp_send_json_success($owners, 200);
        } else {
            wp_send_json_error('Owners fetching failed', 400);
        }
    }

    public function getAllTeams($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/teams";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->teams)) {
            foreach ($response->teams as $team) {
                $teams[] = [
                    'id'   => (string) $team->id,
                    'name' => $team->name
                ];
            }
            wp_send_json_success($teams, 200);
        } else {
            wp_send_json_error('Teams fetching failed', 400);
        }
    }

    public function getAllCurrencies($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/currencies";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];


        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->currencies)) {
            foreach ($response->currencies as $currency) {
                $currencies[] = [
                    'id'   => (string) $currency->code,
                    'name' => $currency->code
                ];
            }
            wp_send_json_success($currencies, 200);
        } else {
            wp_send_json_error('Currencies fetching failed', 400);
        }
    }

    public function getAllCRMParties($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/parties";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];


        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->parties)) {
            foreach ($response->parties as $party) {
                if ($party->type == "organisation") {
                    $parties[] = [
                        'id'   => (string) $party->id,
                        'name' => $party->name
                    ];
                } else {
                    $parties[] = [
                        'id'   => (string) $party->id,
                        'name' => $party->firstName." ".$party->lastName
                    ];
                }
            }
            wp_send_json_success($parties, 200);
        } else {
            wp_send_json_error('Parties fetching failed', 400);
        }
    }

    public function getAllCRMMilestones($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/milestones";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->milestones)) {
            foreach ($response->milestones as $milestone) {
                $milestones[] = [
                    'id'   => (string) $milestone->id,
                    'name' => $milestone->name
                ];
            }
            wp_send_json_success($milestones, 200);
        } else {
            wp_send_json_error('Milestones fetching failed', 400);
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
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for CapsuleCRM api', 'bit-integrations'));
        }

        $recordApiHelper   = new RecordApiHelper($integrationDetails, $integId);
        $capsulecrmApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap, $actionName);

        if (is_wp_error($capsulecrmApiResponse)) {
            return $capsulecrmApiResponse;
        }
        return $capsulecrmApiResponse;
    }
}
