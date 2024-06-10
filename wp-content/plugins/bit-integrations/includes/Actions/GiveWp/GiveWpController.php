<?php
namespace BitCode\FI\Actions\GiveWp;

use WP_Error;

class GiveWpController
{
    public static function pluginActive($option = null)
    {
        if (is_plugin_active('give/give.php')) {
            return $option === 'get_name' ? 'give/give.php' : true;
        }
        return false;
    }

    public static function authorizeGiveWp()
    {
        if (self::pluginActive()) {
            wp_send_json_success(true, 200);
        }
        wp_send_json_error(__('GiveWp must be activated!', 'bit-integrations'));
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $mainAction = $integrationDetails->mainAction;
        $fieldMap = $integrationDetails->field_map;
        if (
            empty($integId) ||
            empty($mainAction)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for GiveWp api', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper();
        $giveWpApiResponse = $recordApiHelper->execute(
            $mainAction,
            $fieldValues,
            $fieldMap,
            $integrationDetails,
            $integId
        );

        if (is_wp_error($giveWpApiResponse)) {
            return $giveWpApiResponse;
        }
        return $giveWpApiResponse;
    }
}
