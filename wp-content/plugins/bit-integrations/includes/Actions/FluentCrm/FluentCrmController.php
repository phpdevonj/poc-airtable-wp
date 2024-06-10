<?php

/**
 * Fluent CRM Integration
 */

namespace BitCode\FI\Actions\FluentCrm;

use WP_Error;

use BitCode\FI\Actions\FluentCrm\RecordApiHelper;
use FluentCrm\App\Models\Lists;
use FluentCrm\App\Models\Tag;
use FluentCrm\App\Models\Subscriber;
use FluentCrm\App\Models\CustomContactField;

/**
 * Provide functionality for ZohoCrm integration
 */
class FluentCrmController
{

    private $_integrationID;

    public function __construct($integrationID)
    {

        $this->_integrationID = $integrationID;
    }

    /**
     * Fluent crm plugin is exists
     *
     * @return void
     */
    public static function checkedExistsFluentCRM()
    {
        if (!is_plugin_active('fluent-crm/fluent-crm.php')) {
            wp_send_json_error(
                __(
                    'Fluent CRM Plugin is not active or not installed',
                    'bit-integrations'
                ),
                400
            );
        } else {
            return true;
        }
    }

    /**
     * Fetch CRM lists
     *
     * @return Fluent CRM lists
     */
    public static function fluentCrmLists()
    {
        self::checkedExistsFluentCRM();
        $lists = Lists::get();
        $fluentCrmList = [];
        foreach ($lists as $list) {
            $fluentCrmList[$list->title] = (object) [
                'id' => $list->id,
                'title' => $list->title
            ];
        }
        $tags = Tag::get();
        $fluentCrmTags = [];
        foreach ($tags as $tag) {
            $fluentCrmTags[$tag->title] = (object) [
                'id' => $tag->id,
                'title' => $tag->title
            ];
        }
        $response['fluentCrmList'] = $fluentCrmList;
        $response['fluentCrmTags'] = $fluentCrmTags;
        wp_send_json_success($response, 200);
    }

    public static function fluentCrmTags()
    {
        self::checkedExistsFluentCRM();

        $tags = Tag::get();
        $fluentCrmTags = [];
        foreach ($tags as $tag) {
            $fluentCrmTags[$tag->title] = (object) [
                'id' => $tag->id,
                'title' => $tag->title
            ];
        }
        $response['fluentCrmTags'] = $fluentCrmTags;
        wp_send_json_success($response, 200);
    }

    public static function fluentCrmFields()
    {
        self::checkedExistsFluentCRM();
        $fieldOptions = [];
        $primaryField = ['first_name', 'last_name', 'full_name', 'email'];

        foreach (Subscriber::mappables() as $key => $column) {
            if (in_array($key, $primaryField)) {
                if ($key === 'email') {
                    $fieldOptions[$column] = (object) [
                        'key'     => $key,
                        'label'   => $column,
                        'type'    => 'primary',
                        'required' => true
                    ];
                } else {
                    $fieldOptions[$column] = (object) [
                        'key'     => $key,
                        'label'   => $column,
                        'type'    => 'primary'
                    ];
                }
            } else {
                $fieldOptions[$column] = (object) [
                    'key'       => $key,
                    'label'     => $column,
                    'type'      => 'custom'
                ];
            }
        }
        foreach ((new CustomContactField)->getGlobalFields()['fields'] as $field) {
            $fieldOptions[$field['label']] = (object) [
                'key'         => $field['slug'],
                'label'       => $field['label'],
                'type'        => 'custom'
            ];
        }
        $response['fluentCrmFlelds'] = $fieldOptions;
        wp_send_json_success($response, 200);
    }

    /**
     * @return True Fluent crm are exists
     */
    public static function fluentCrmAuthorize()
    {
        if (self::checkedExistsFluentCRM()) {
            wp_send_json_success(true);
        } else {
            wp_send_json_error(
                __(
                    'Please! Install Fluent CRM',
                    'bit-integrations'
                ),
                400
            );
        }
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;


        $fieldMap         = $integrationDetails->field_map;
        $defaultDataConf  = $integrationDetails->default;
        $list_id          = isset($integrationDetails->list_id) ? $integrationDetails->list_id : null;
        $tags             = $integrationDetails->tags;
        $actions          = $integrationDetails->actions;
        $actionName          = $integrationDetails->actionName;

        if (empty($fieldMap)) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Fluent CRM api', 'bit-integrations'));
        }

        $recordApiHelper = new RecordApiHelper($this->_integrationID);

        $fluentCrmApiResponse = $recordApiHelper->execute(
            $fieldValues,
            $fieldMap,
            $actions,
            $list_id,
            $tags,
            $actionName
        );

        if (is_wp_error($fluentCrmApiResponse)) {
            return $fluentCrmApiResponse;
        }
        return $fluentCrmApiResponse;
    }
}
