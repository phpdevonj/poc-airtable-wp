<?php

/**
 * Zendesk Integration
 */

namespace BitCode\FI\Actions\Zendesk;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Zendesk integration
 */
class ZendeskController
{
    protected $_defaultHeader;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->apiEndpoint = "https://api.getbase.com/v2/";
    }

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."accounts/self";
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
        if ($action == 'contact' || $action == 'organization') {
            $apiEndpoint = $this->apiEndpoint."contact/custom_fields";
        } elseif ($action == 'lead') {
            $apiEndpoint = $this->apiEndpoint."lead/custom_fields";
        } elseif ($action == 'deal') {
            $apiEndpoint = $this->apiEndpoint."deal/custom_fields";
        }



        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);
        if (isset($response->items)) {
            foreach ($response->items as $customField) {
                $customFields[] = [
                    'key' => $customField->data->id,
                    'label' => $customField->data->name,
                    'required' => false,
                ];
            }
            wp_send_json_success($customFields, 200);
        } else {
            wp_send_json_error('Custom field fetching failed', 400);
        }
    }

    public function getAllLeads($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."/leads";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->leads)) {
            foreach ($response->leads as $lead) {
                $leads[] = [
                    'id'   => (string) $lead->id,
                    'name' => $lead->name
                ];
            }
            wp_send_json_success($leads, 200);
        } else {
            wp_send_json_error('Lead fetching failed', 400);
        }
    }

    public function getAllParentOrganizations($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."contacts";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->items)) {
            foreach ($response->items as $parentOrganization) {
                if ($parentOrganization->data->is_organization == true) {
                    $parentOrganizations[] = [
                        'id'   => (string) $parentOrganization->data->id,
                        'name' => $parentOrganization->data->name
                    ];
                }
            }
            wp_send_json_success($parentOrganizations, 200);
        } else {
            wp_send_json_error('ParentOrganizations fetching failed', 400);
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

    public function getAllStages($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."stages";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];


        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (isset($response->items)) {
            foreach ($response->items as $stage) {
                $stages[] = [
                    'id'   => (string) $stage->data->id,
                    'name' => $stage->data->name
                ];
            }
            wp_send_json_success($stages, 200);
        } else {
            wp_send_json_error('Stages fetching failed', 400);
        }
    }

    public function getAllCRMCompanies($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."contacts";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->items)) {
            foreach ($response->items as $company) {
                if ($company->data->is_organization == true) {
                    $companies[] = [
                        'id'   => $company->data->name,
                        'name' => $company->data->name
                    ];
                }
            }
            wp_send_json_success($companies, 200);
        } else {
            wp_send_json_error('Companies fetching failed', 400);
        }
    }

    public function getAllCRMContacts($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;
        $apiEndpoint = $this->apiEndpoint."contacts";
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->items)) {
            foreach ($response->items as $contact) {
                $contacts[] = [
                    'id'   => $contact->data->id,
                    'name' => $contact->data->name
                ];
            }
            wp_send_json_success($contacts, 200);
        } else {
            wp_send_json_error('Contacts fetching failed', 400);
        }
    }

    public function getAllCRMSources($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->api_key)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->api_key;

        if ($fieldsRequestParams->action_name == 'lead') {
            $apiEndpoint = $this->apiEndpoint."lead_sources";
        } elseif ($fieldsRequestParams->action_name == 'deal') {
            $apiEndpoint = $this->apiEndpoint."deal_sources";
        }
        $headers = [
            "Authorization" => 'Bearer ' . $apiKey,
        ];

        $response = HttpHelper::get($apiEndpoint, null, $headers);

        if (!empty($response->items)) {
            foreach ($response->items as $source) {
                $sources[] = [
                    'id'   => (string) $source->data->id,
                    'name' => $source->data->name
                ];
            }
            wp_send_json_success($sources, 200);
        } else {
            wp_send_json_error('Sources fetching failed', 400);
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
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Zendesk api', 'bit-integrations'));
        }

        $recordApiHelper   = new RecordApiHelper($integrationDetails, $integId);
        $zendeskApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap, $actionName);

        if (is_wp_error($zendeskApiResponse)) {
            return $zendeskApiResponse;
        }
        return $zendeskApiResponse;
    }
}
