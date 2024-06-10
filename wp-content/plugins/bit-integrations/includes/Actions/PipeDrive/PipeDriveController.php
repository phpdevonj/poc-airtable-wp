<?php

/**
 * PipeDrive Integration
 */
namespace BitCode\FI\Actions\PipeDrive;

use BitCode\FI\Actions\PipeDrive\RecordApiHelper;
use WP_Error;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for PipeDrive integration
 */
class PipeDriveController
{
    private $baseUrl = 'https://api.pipedrive.com/v1/';

    public function getMetaData($requestParams)
    {
        if (empty($requestParams->api_key)) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }

        $apiEndpoints = $this->baseUrl . $requestParams->type . '?api_token=' . $requestParams->api_key;

        $response = HttpHelper::get($apiEndpoints, null);
        $formattedResponse = [];

        foreach ($response->data as $value) {
            if ($requestParams->type !== 'currencies') {
                $formattedResponse[] =
                [
                    'value'     => $value->id,
                    'label'     => $value->name,
                ];
            } else {
                $formattedResponse[] =
                [
                    'value'     => $value->code,
                    'label'     => $value->name,
                ];
            }
        }

        if (isset($response->success) && $response->success) {
            wp_send_json_success($formattedResponse, 200);
        } else {
            wp_send_json_error(
                'The token is invalid',
                400
            );
        }
    }

   public function getFields($requestParams)
   {
       if (empty($requestParams->api_key)) {
           wp_send_json_error(
               __(
                   'Requested parameter is empty',
                   'bit-integrations'
               ),
               400
           );
       }
       $module = $requestParams->module;

       $requestModule = '';
       if ($module === 'Leads' || $module === 'Deals') {
           $requestModule = 'dealFields';
       } elseif ($module === 'Products') {
           $requestModule = 'productFields';
       } elseif ($module === 'Activities') {
           $requestModule = 'activityFields';
       } elseif ($module === 'Notes') {
           $requestModule = 'noteFields';
       } elseif ($module === 'Persons') {
           $requestModule = 'personFields';
       }

       $unnecessaryFields = (object)[
           'Leads'     => ['creator_user_id', 'user_id', 'weighted_value', 'currency', 'weighted_value_currency', 'probability', 'org_id', 'pipeline', 'person_id', 'stage_id', 'label', 'status', 'add_time', 'update_time', 'stage_change_time', 'next_activity_date', 'last_activity_date', 'won_time', 'last_incoming_mail_time', 'last_outgoing_mail_time', 'lost_time', 'close_time', 'lost_reason', 'visible_to', 'id', 'activities_count', 'done_activities_count', 'undone_activities_count', 'email_messages_count', 'product_quantity', 'product_amount'],

           'Deals'     => ['creator_user_id', 'user_id', 'weighted_value', 'pipeline', 'currency',  'weighted_value_currency', 'probability', 'org_id', 'person_id', 'stage_id', 'label', 'status', 'add_time', 'update_time', 'stage_change_time', 'next_activity_date', 'last_activity_date', 'won_time', 'last_incoming_mail_time', 'last_outgoing_mail_time', 'lost_time', 'close_time', 'lost_reason', 'visible_to', 'id', 'activities_count', 'done_activities_count', 'undone_activities_count', 'email_messages_count', 'product_quantity', 'product_amount'],

           'Activities'=> ['created_by_user_id', 'last_notification_time', 'deal_id', 'type', 'busy_flag',  'marked_as_done_time', 'lead_id', 'org_id', 'person_id',  'user_id', 'id', 'done', 'add_time', 'update_time', 'location_subpremise', 'location_street_number', 'location_route', 'location_sublocality', 'location_locality', 'location_admin_area_level_1', 'location_admin_area_level_2', 'location_country', 'location_postal_code', 'location_formatted_address'],

           'Persons'   => ['label', 'last_name', 'first_name', 'add_time', 'update_time', 'org_id', 'owner_id', 'open_deals_count', 'label', 'status', 'next_activity_date', 'last_activity_date', 'last_incoming_mail_time', 'last_outgoing_mail_time',  'visible_to', 'id', 'activities_count', 'done_activities_count', 'undone_activities_count', 'email_messages_count', 'picture_id', 'won_deals_count', 'lost_deals_count', 'closed_deals_count'],

           'Products'  => ['creator_user_id', 'unit_prices', 'user_id', 'weighted_value', 'category', 'currency',  'weighted_value_currency',  'org_id', 'owner_id', 'person_id', 'selectable', 'label', 'status', 'add_time', 'update_time', 'stage_change_time', 'next_activity_date', 'last_activity_date', 'won_time', 'last_incoming_mail_time', 'last_outgoing_mail_time', 'lost_time', 'close_time', 'lost_reason', 'visible_to', 'id', 'activities_count', 'done_activities_count', 'undone_activities_count', 'email_messages_count'],

           'Notes'     => ['creator_user_id', 'user_id', 'weighted_value', 'deal_id', 'lead_id', 'pinned_to_lead_flag', 'pinned_to_deal_flag',  'pinned_to_organization_flag', 'pinned_to_person_flag', 'org_id', 'person_id', 'stage_id', 'label', 'status', 'add_time', 'update_time', 'stage_change_time', 'next_activity_date', 'last_activity_date', 'won_time', 'last_incoming_mail_time', 'last_outgoing_mail_time', 'lost_time', 'close_time', 'lost_reason', 'visible_to', 'id', 'activities_count', 'done_activities_count', 'undone_activities_count', 'email_messages_count', 'product_quantity', 'product_amount'],

       ];

       $apiEndpoints = $this->baseUrl . $requestModule . '?api_token=' . $requestParams->api_key;

       $response = HttpHelper::get($apiEndpoints, null);
       $formattedResponse = [];

       if (isset($response->success) && $response->success) {
           foreach ($response->data as $value) {
               $required = false;
               if (($module === 'Leads' || $module === 'Deals') && $value->key === 'title') {
                   $required = true;
               } elseif (($module === 'Persons' || $module === 'Products') && $value->key === 'name') {
                   $required = true;
               } elseif ($module === 'Notes' && $value->key === 'content') {
                   $required = true;
               } else {
                   $required = false;
               }
               if (!in_array($value->key, $unnecessaryFields->$module)) {
                   $formattedResponse[] = [
                       'key'      => $value->key,
                       'label'    => $value->name,
                       'required' => $required,
                   ];
               }
           }
           if ($module === 'Products') {
               $addFields = [
                   (object)[
                       'key'      => 'cost',
                       'label'    => 'Cost Per Unit',
                       'required' => false,
                   ], [
                       'key'      => 'overhead_cost',
                       'label'    => 'Direct Cost',
                       'required' => false,
                   ]
               ];
               array_push($formattedResponse, ...$addFields);
           }

           wp_send_json_success($formattedResponse, 200);
       } else {
           wp_send_json_error(
               'The token is invalid',
               400
           );
       }
   }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $api_key = $integrationDetails->api_key;
        $fieldMap = $integrationDetails->field_map;
        $module = strtolower($integrationDetails->moduleData->module);

        if (
            empty($fieldMap)
             || empty($api_key)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for PipeDrive api', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationDetails, $integId);
        $pipeDriveApiResponse = $recordApiHelper->execute(
            $fieldValues,
            $fieldMap,
            $module
        );

        if (is_wp_error($pipeDriveApiResponse)) {
            return $pipeDriveApiResponse;
        }

        if (isset($pipeDriveApiResponse->success) && isset($pipeDriveApiResponse->data) && $pipeDriveApiResponse->success && count($integrationDetails->relatedlists)) {
            $recordApiHelper->addRelatedList($pipeDriveApiResponse, $integrationDetails, $fieldValues, $module);
        }
        return $pipeDriveApiResponse;
    }
}
