<?php

/**
 * trello Record Api
 */
namespace BitCode\FI\Actions\Affiliate;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private static $integrationID;
    private $_integrationDetails;

    public function __construct($integrationDetails, $integId)
    {
        $this->_integrationDetails = $integrationDetails;
        self::$integrationID = $integId;
    }

    public static function getIntegrationId()
    {
        return $integrationID = self::$integrationID;
    }

    public function getAssignmentList()
    {
        return $assignment_list = $this->assignment_list;
    }

    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->affiliateFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public static function createAffiliateWithSpecificId($affiliateId, $statusId, $referralId, $finalData)
    {
        switch ($statusId) {
            case '1':
                $status = 'paid';
                break;
            case '2':
                $status = 'unpaid';
                break;
            case '3':
                $status = 'pending';
                break;
            case '4':
                $status = 'reject';
                break;
        }
        switch ($referralId) {
            case '1':
                $referral = 'sale';
                break;
            case '2':
                $referral = 'opt-in';
                break;
            case '3':
                $referral = 'lead';
                break;
        }

        $user_id = get_current_user_id();
        $user = get_user_by('id', $user_id);
        $finalData['user_id'] = $user_id;
        $finalData['type'] = $referral;
        $finalData['status'] = $status;
        $finalData['custom'] = 'this is custom field';
        $finalData['user_name'] = $user->user_login;
        $finalData['affiliate_id'] = $affiliateId;

        $affiliate_user_id = affwp_get_affiliate_user_id($affiliateId);
        if ($affiliate_user_id && affwp_is_affiliate($affiliate_user_id)) {
            return affwp_add_referral($finalData);
        } else {
            LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'create-referral']), 'error', json_encode('User are not affiliate'));
        }
    }

    public static function createAffiliateFortheUser($statusId, $referralId, $finalData)
    {
        switch ($statusId) {
            case '1':
                $status = 'paid';
                break;
            case '2':
                $status = 'unpaid';
                break;
            case '3':
                $status = 'pending';
                break;
            case '4':
                $status = 'reject';
                break;
        }
        switch ($referralId) {
            case '1':
                $referral = 'sale';
                break;
            case '2':
                $referral = 'opt-in';
                break;
            case '3':
                $referral = 'lead';
                break;
        }

        $user_id = get_current_user_id();
        $affiliateId = affwp_get_affiliate_id($user_id);
        $user = get_user_by('id', $user_id);
        $finalData['user_id'] = $user_id;
        $finalData['type'] = $referral;
        $finalData['status'] = $status;
        $finalData['custom'] = 'this is custom field';
        $finalData['user_name'] = $user->user_login;
        $finalData['affiliate_id'] = $affiliateId;

        $affiliate_user_id = affwp_get_affiliate_user_id($affiliateId);
        if ($affiliate_user_id && affwp_is_affiliate($affiliate_user_id)) {
            return affwp_add_referral($finalData);
        } else {
            LogHandler::save(self::$integrationID, json_encode(['type' => 'referral', 'type_name' => 'create-referral']), 'error', json_encode('User are not affiliate'));
        }
    }

    public function execute(
        $mainAction,
        $fieldValues,
        $integrationDetails,
        $integrationData
    ) {
        $fieldData = [];
        if ($mainAction === '1') {
            $fieldMap = $integrationDetails->field_map;
            $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
            $affiliateId = $integrationDetails->affiliate_id;
            $referralId = $integrationDetails->referralId;
            $statusId = $integrationDetails->statusId;
            $apiResponse = self::createAffiliateWithSpecificId(
                $affiliateId,
                $statusId,
                $referralId,
                $finalData
            );
            if ($apiResponse !== 0) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'referral', 'type_name' => 'create-referral']), 'success', json_encode('Created Referral id ' . $apiResponse));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'referral', 'type_name' => 'create-referral']), 'error', json_encode('Error in creating referral'));
            }
            return $apiResponse;
        }
        if ($mainAction === '2') {
            $fieldMap = $integrationDetails->field_map;
            $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
            $referralId = $integrationDetails->referralId;
            $statusId = $integrationDetails->statusId;
            $apiResponse = self::createAffiliateFortheUser(
                $statusId,
                $referralId,
                $finalData
            );
            if ($apiResponse !== 0) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'referral', 'type_name' => 'create-referral']), 'success', json_encode('Created Referral id ' . $apiResponse));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'referral', 'type_name' => 'create-referral']), 'error', json_encode('Error in creating referral'));
            }
            return $apiResponse;
        }
    }
}
