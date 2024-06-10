<?php

/**
 * Airtable Integration
 */

namespace BitCode\FI\Actions\Airtable;

use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Airtable integration
 */
class AirtableController
{
    protected $_defaultHeader;

    public function authentication($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $apiEndpoint = 'https://api.airtable.com/v0/meta/bases';
        $header      = [
            'Authorization' => "Bearer {$apiKey}"
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (isset($response->bases)) {
            foreach ($response->bases as $base) {
                if ($base->permissionLevel === 'create') {
                    $bases[] = [
                        'id'   => $base->id,
                        'name' => $base->name
                    ];
                }
            }
            wp_send_json_success($bases, 200);
        } else {
            wp_send_json_error('Authentication failed', 400);
        }
    }

    public function getAllTables($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->baseId)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $baseId      = $fieldsRequestParams->baseId;
        $apiEndpoint = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables/";
        $header      = [
            'Authorization' => "Bearer {$apiKey}"
        ];

        $response = HttpHelper::get($apiEndpoint, null, $header);

        if (isset($response->tables)) {
            foreach ($response->tables as $table) {
                $tables[] = [
                    'id'   => $table->id,
                    'name' => $table->name,
                ];
            }
            wp_send_json_success($tables, 200);
        } else {
            wp_send_json_error('Tables fetching failed', 400);
        }
    }

    public function getAllFields($fieldsRequestParams)
    {
        if (empty($fieldsRequestParams->auth_token) || empty($fieldsRequestParams->baseId) || empty($fieldsRequestParams->tableId)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $apiKey      = $fieldsRequestParams->auth_token;
        $baseId      = $fieldsRequestParams->baseId;
        $tableId     = $fieldsRequestParams->tableId;
        $apiEndpoint = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables/";
        $header      = [
            'Authorization' => "Bearer {$apiKey}"
        ];

        $response      = HttpHelper::get($apiEndpoint, null, $header);
        $acceptedTypes = ['singleLineText', 'multilineText', 'singleSelect', 'multipleSelects', 'multipleAttachments', 'date', 'phoneNumber', 'email', 'url', 'number', 'currency', 'percent', 'duration', 'rating', 'barcode'];

        if (isset($response->tables)) {
            foreach ($response->tables as $table) {
                if ($table->id === $tableId) {
                    foreach ($table->fields as $field) {
                        if (in_array($field->type, $acceptedTypes)) {
                            $fields[] = [
                                'key'      => $field->id . '{btcbi}' . $field->type,
                                'label'    => $field->name,
                                'required' => false
                            ];
                        }
                    }
                }
            }
            wp_send_json_success($fields, 200);
        } else {
            wp_send_json_error('Table fields fetching failed', 400);
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId            = $integrationData->id;
        $auth_token         = $integrationDetails->auth_token;
        $fieldMap           = $integrationDetails->field_map;

        if (empty($fieldMap) || empty($auth_token)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('fields are required for Airtable api', 'bit-integrations'));
        }

        $recordApiHelper     = new RecordApiHelper($integrationDetails, $integId);
        $airtableApiResponse = $recordApiHelper->execute($fieldValues, $fieldMap);

        if (is_wp_error($airtableApiResponse)) {
            return $airtableApiResponse;
        }
        return $airtableApiResponse;
    }
}
