<?php
namespace BitCode\FI\Actions\Zoom;

use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Flow\FlowController;
use WP_Error;

class ZoomController
{
    private $integrationID;

    public function __construct($integrationID)
    {
        $this->integrationID = $integrationID;
    }

    public static function authorization($requestParams)
    {
        if (empty($requestParams->clientId) || empty($requestParams->clientSecret) || empty($requestParams->code) || empty($requestParams->redirectURI)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $body = [
            'redirect_uri' => urldecode($requestParams->redirectURI),
            'grant_type' => 'authorization_code',
            'code' => urldecode($requestParams->code)
        ];

        $apiEndpoint = 'https://zoom.us/oauth/token';
        $header['Content-Type'] = 'application/x-www-form-urlencoded';
        $header['Authorization'] = 'Basic ' . base64_encode("$requestParams->clientId:$requestParams->clientSecret");
        $apiResponse = HttpHelper::post($apiEndpoint, $body, $header);
        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            wp_send_json_error(empty($apiResponse->error_description) ? 'Unknown' : $apiResponse->error_description, 400);
        }
        $apiResponse->generates_on = \time();
        wp_send_json_success($apiResponse, 200);
    }

    public static function zoomFetchAllMeetings($requestParams)
    {
        if (empty($requestParams->accessToken)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }
        $header = [
            'Authorization' => 'Bearer ' . $requestParams->accessToken,
            'Content-Type' => 'application/json'
        ];

        $apiEndpoint = 'https://api.zoom.us/v2/users/me/meetings';
        $apiResponse = HttpHelper::get($apiEndpoint, null, $header);

        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            wp_send_json_error(empty($apiResponse->error) ? 'Unknown' : $apiResponse->error, 400);
        }

        $response['allMeeting'] = $apiResponse->meetings;
        wp_send_json_success($response, 200);
    }

    public static function getAllFolders($queryParams)
    {
        if (empty($queryParams->tokenDetails) || empty($queryParams->clientId) || empty($queryParams->clientSecret)) {
            wp_send_json_error(__('Requested parameter is empty', 'bit-integrations'), 400);
        }

        $token = self::tokenExpiryCheck($queryParams->tokenDetails, $queryParams->clientId, $queryParams->clientSecret, null);
        if ($token->access_token !== $queryParams->tokenDetails->access_token) {
            self::saveRefreshedToken($queryParams->flowID, $token);
        }

        $folders = self::getOneDriveFoldersList($token->access_token);
        $foldersOnly = $folders->value;

        $data = [];
        if (is_array($foldersOnly)) {
            foreach ($foldersOnly as $folder) {
                if (property_exists($folder, 'folder')) {
                    $data[] = $folder;
                }
            }
        }
        $response['oneDriveFoldersList'] = $data;
        $response['tokenDetails'] = $token;
        wp_send_json_success($response, 200);
    }

    private static function tokenExpiryCheck($token, $clientId, $clientSecret)
    {
        if (!$token) {
            return false;
        }

        if ((intval($token->generates_on) + (55 * 60)) < time()) {
            $refreshToken = self::refreshToken($token->refresh_token, $clientId, $clientSecret);
            if (is_wp_error($refreshToken) || !empty($refreshToken->error)) {
                return false;
            }

            if (isset($refreshToken->access_token)) {
                $token->access_token = $refreshToken->access_token;
                $token->expires_in = $refreshToken->expires_in;
                $token->generates_on = $refreshToken->generates_on;
                $token->refresh_token = $refreshToken->refresh_token;
            }
        }
        return $token;
    }

    private static function refreshToken($refresh_token, $clientId, $clientSecret)
    {
        $header = [
            'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $requestParams = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];
        $apiEndpoint = 'https://zoom.us/oauth/token';
        $apiResponse = HttpHelper::post($apiEndpoint, $requestParams, $header);

        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            return false;
        }
        $token = $apiResponse;
        $token->generates_on = \time();

        return $token;
    }

    private static function saveRefreshedToken($integrationID, $tokenDetails)
    {
        if (empty($integrationID)) {
            return;
        }

        $flow = new FlowController();
        $zoomDetails = $flow->get(['id' => $integrationID]);
        if (is_wp_error($zoomDetails)) {
            return;
        }

        $newDetails = json_decode($zoomDetails[0]->flow_details);
        $newDetails->tokenDetails = $tokenDetails;
        $flow->update($integrationID, ['flow_details' => \json_encode($newDetails)]);
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $meetingId = $integrationDetails->id;
        $fieldMap = $integrationDetails->field_map;
        $actions = $integrationDetails->actions;
        $defaultDataConf = $integrationDetails->default;
        $selectedAction = $integrationDetails->selectedActions;
        $oldToken = $integrationDetails->tokenDetails->access_token;
        $tokenDetails = self::tokenExpiryCheck($integrationDetails->tokenDetails, $integrationDetails->clientId, $integrationDetails->clientSecret);
        if ($tokenDetails->access_token !== $oldToken) {
            self::saveRefreshedToken($this->integrationID, $tokenDetails);
        }
        if (
            empty($meetingId)
            || empty($fieldMap)
            || empty($defaultDataConf)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Zoom api', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationDetails, $integId);
        $zoomApiResponse = $recordApiHelper->execute(
            $meetingId,
            $defaultDataConf,
            $fieldValues,
            $fieldMap,
            $actions,
            $tokenDetails,
            $selectedAction
        );

        if (is_wp_error($zoomApiResponse)) {
            return $zoomApiResponse;
        }
        return $zoomApiResponse;
    }
}
