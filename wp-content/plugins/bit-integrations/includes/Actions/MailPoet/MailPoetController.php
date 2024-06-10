<?php

/**
 * ZohoSheet Integration
 */

namespace BitCode\FI\Actions\MailPoet;

use WP_Error;
use BitCode\FI\Actions\MailPoet\RecordApiHelper;

/**
 * Provide functionality for ZohoCrm integration
 */
class MailPoetController
{
    //BitCode\FI\Actions\MailPoet\MailPoetController



    /**
     * Validate if Mail Poet plugin exists or not. If not exits then terminate
     * request and send an error response.
     *
     * @return void
     */
    public static function isExists()
    {
        if (!class_exists(\MailPoet\API\API::class)) {
            wp_send_json_error(
                __(
                    'MailPoet is not activate or not installed',
                    'bit-integrations'
                ),
                400
            );
        }
    }
    /**
     * Process ajax request for generate_token
     *
     * @return JSON zoho crm api response and status
     */
    public static function mailPoetAuthorize()
    {
        self::isExists();
        wp_send_json_success(true);
    }
    /**
     * Process ajax request for refresh crm modules
     *
     * @return JSON crm module data
     */

    public function refreshNeswLetter()
    {
        self::isExists();
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $newsletterList = $mailpoet_api->getLists();
       
        $allList = [];

        foreach ($newsletterList as $newsletter) {
            $allList[$newsletter['name']] = (object) [
            'newsletterId' => $newsletter['id'],
            'newsletterName' => $newsletter['name']
            ];
        }
        $response['newsletterList'] = $allList;
        wp_send_json_success($response, 200);
    }
    public static function mailPoetListHeaders()
    {
        self::isExists();
        $mailpoet_api = \MailPoet\API\API::MP('v1');
        $subscriber_form_fields = $mailpoet_api->getSubscriberFields();

        $allList = [];

        foreach ($subscriber_form_fields as $fields) {
            $allList[$fields['name']] = (object) [
            'id' => $fields['id'],
            'name' => $fields['name'],
            'required' => $fields['params']['required']
            ];
        }
        $response['mailPoetFields'] = $allList;
        wp_send_json_success($response, 200);
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $fieldMap = $integrationDetails->field_map;
        $defaultDataConf = $integrationDetails->default;
        $lists = $integrationDetails->lists;
        
        if (empty($fieldMap)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Google sheet api', 'bit-integrations'));
        }

        $recordApiHelper = new RecordApiHelper($integId);

        $maiPoetApiResponse = $recordApiHelper->execute(
            $fieldValues,
            $fieldMap,
            $lists
        );

        if (is_wp_error($maiPoetApiResponse)) {
            return $maiPoetApiResponse;
        }
        return $maiPoetApiResponse;
    }
}
