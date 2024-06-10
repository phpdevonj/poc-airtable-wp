<?php

/**
 * ZohoSheet Integration
 */

namespace BitCode\FI\Actions\GoogleSheet;

use WP_Error;
use BitCode\FI\Core\Util\IpTool;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Actions\GoogleSheet\RecordApiHelper;
use BitCode\FI\Flow\FlowController;

/**
 * Provide functionality for ZohoCrm integration
 */
class GoogleSheetController
{
    
    private $_integrationID;

    public function __construct($integrationID)
    {
        $this->_integrationID = $integrationID;
    }

    /**
     * Helps to register ajax function's with wp
     *
     * @return null
     */
    public static function registerAjax()
    {
        add_action('wp_ajax_gsheet_generate_token', array(__CLASS__, 'generateTokens'));
        add_action('wp_ajax_gsheet_refresh_spreadsheets', array(__CLASS__, 'refreshSpreadsheetsAjaxHelper'));
        add_action('wp_ajax_gsheet_refresh_worksheets', array(__CLASS__, 'refreshWorksheetsAjaxHelper'));
        add_action('wp_ajax_gsheet_refresh_worksheet_headers', array(__CLASS__, 'refreshWorksheetHeadersAjaxHelper'));
    }

    /**
     * Process ajax request for generate_token
     *
     * @param Object $requestsParams 
     * 
     * @return JSON zoho crm api response and status
     */
    public static function generateTokens($requestsParams)
    {
        if (empty($requestsParams->clientId)
            || empty($requestsParams->clientSecret)
            || empty($requestsParams->redirectURI)
            || empty($requestsParams->code)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }

        $apiEndpoint = 'https://oauth2.googleapis.com/token';
        $authorizationHeader["Content-Type"] = 'application/x-www-form-urlencoded';
        $requestParams = array(
            "grant_type" => "authorization_code",
            "client_id" => $requestsParams->clientId,
            "client_secret" => $requestsParams->clientSecret,
            "redirect_uri" => \urldecode($requestsParams->redirectURI),
            "code" => urldecode($requestsParams->code)
        );
        $apiResponse = HttpHelper::post($apiEndpoint, $requestParams, $authorizationHeader);

        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            wp_send_json_error(
                empty($apiResponse->error) ? 'Unknown' : $apiResponse->error,
                400
            );
        }
        $apiResponse->generates_on = \time();
        wp_send_json_success($apiResponse, 200);
    }
    /**
     * Process ajax request for refresh crm modules
     *
     * @param Object $queryParams Request Params
     * 
     * @return JSON crm module data
     */
    public static function refreshSpreadsheetsAjaxHelper($queryParams)
    {
        if (empty($queryParams->tokenDetails)
            || empty($queryParams->clientId)
            || empty($queryParams->clientSecret)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $response = [];
        if ((intval($queryParams->tokenDetails->generates_on) + (55 * 60)) < time()) {
            $response['tokenDetails'] = GoogleSheetController::refreshAccessToken($queryParams);
        }

        $workSheets = "https://www.googleapis.com/drive/v3/files?q=mimeType%20%3D%20'application%2Fvnd.google-apps.spreadsheet'";

        $authorizationHeader["Authorization"] = "Bearer {$queryParams->tokenDetails->access_token}";
        $workSheetResponse = HttpHelper::get($workSheets, null, $authorizationHeader);

        $allSpreadsheet = [];
        if (!is_wp_error($workSheetResponse) && empty($workSheetResponse->response->error)) {
            $spreadsheets = $workSheetResponse->files;
            foreach ($spreadsheets as $spreadsheet) {
                $allSpreadsheet[$spreadsheet->name] = (object) array(
                    'spreadsheetId' => $spreadsheet->id,
                    'spreadsheetName' => $spreadsheet->name
                );
            }
            uksort($allSpreadsheet, 'strnatcasecmp');
            $response['spreadsheets'] = $allSpreadsheet;
        } else {
            wp_send_json_error(
                $workSheetResponse->response->error->message,
                400
            );
        }
        if (!empty($response['tokenDetails']) && !empty($queryParams->id)) {
            GoogleSheetController::saveRefreshedToken($queryParams->id, $response['tokenDetails'], $response['$spreadsheets']);
        }
        wp_send_json_success($response, 200);
    }
    /**
     * Process ajax request for refesh crm layouts
     *
     * @param Object $queryParams Request Params
     * 
     * @return JSON crm layout data
     */
    public static function refreshWorksheetsAjaxHelper($queryParams)
    {

        if (empty($queryParams->clientId)
            || empty($queryParams->clientSecret)
            || empty($queryParams->spreadsheetId)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $response = [];
        if ((intval($queryParams->tokenDetails->generates_on) + (55 * 60)) < time()) {
            $response['tokenDetails'] = GoogleSheetController::refreshAccessToken($queryParams);
        }

        $worksheetsMetaApiEndpoint = "https://sheets.googleapis.com/v4/spreadsheets/$queryParams->spreadsheetId?&fields=sheets.properties";

        $authorizationHeader["Authorization"] = "Bearer {$queryParams->tokenDetails->access_token}";
        $worksheetsMetaResponse = HttpHelper::get($worksheetsMetaApiEndpoint, null, $authorizationHeader);

        if (!is_wp_error($worksheetsMetaResponse)) {
            $worksheets = $worksheetsMetaResponse->sheets;
            $response['worksheets'] = $worksheets;
            // wp_send_json_success($response, 200);
        } else {
            wp_send_json_error(
                $worksheetsMetaResponse->status === 'error' ? $worksheetsMetaResponse->message : 'Unknown',
                400
            );
        }
        if (!empty($response['tokenDetails']) && $response['tokenDetails'] && !empty($queryParams->id)) {
            $response["queryWorkbook"] = $queryParams->workbook;
            GoogleSheetController::saveRefreshedToken($queryParams->id, $response['tokenDetails'], $response);
        }
        wp_send_json_success($response, 200);
    }

    /**
     * Process ajax request for refesh crm layouts
     * 
     * @param Object $queryParams Request Params
     * 
     * @return JSON crm layout data
     */
    public static function refreshWorksheetHeadersAjaxHelper($queryParams)
    {
        if (empty($queryParams->worksheetName)
            || empty($queryParams->tokenDetails)
            || empty($queryParams->clientId)
            || empty($queryParams->clientSecret)
            || empty($queryParams->header)
            || empty($queryParams->headerRow)
        ) {
            wp_send_json_error(
                __(
                    'Requested parameter is empty',
                    'bit-integrations'
                ),
                400
            );
        }
        $response = [];
        if ((intval($queryParams->tokenDetails->generates_on) + (55 * 60)) < time()) {
            $response['tokenDetails'] = GoogleSheetController::refreshAccessToken($queryParams);
        }
        $headerRow = $queryParams->headerRow;
        if ($queryParams->header === 'ROWS') {
            $rangeNumber = preg_replace('/[^0-9]/', '', $headerRow);
            $range = "{$headerRow}:ZZ{$rangeNumber}";
        } else {
            $columnLetter = preg_replace('/\d/', '', $headerRow);
            $range = "{$headerRow}:{$columnLetter}1005";
        }

        $worksheetHeadersMetaApiEndpoint = "https://sheets.googleapis.com/v4/spreadsheets/{$queryParams->spreadsheetId}/values/{$queryParams->worksheetName}!{$range}?majorDimension={$queryParams->header}";

        $authorizationHeader["Authorization"] = "Bearer {$queryParams->tokenDetails->access_token}";
        $worksheetHeadersMetaResponse = HttpHelper::get($worksheetHeadersMetaApiEndpoint, null, $authorizationHeader);

        // wp_send_json_success($worksheetHeadersMetaResponse, 200);


        if (!is_wp_error($worksheetHeadersMetaResponse)) {

            $allHeaders = $worksheetHeadersMetaResponse->values[0];

            if ($allHeaders === null) {
                $response['worksheet_headers'] = [];
            } else {
                $response['worksheet_headers'] = $allHeaders;
            }
        } else {
            wp_send_json_error(
                $worksheetHeadersMetaResponse->status === 'error' ? $worksheetHeadersMetaResponse->message : 'Unknown',
                400
            );
        }
        if (!empty($response['tokenDetails']) && $response['tokenDetails'] && !empty($queryParams->id)) {
            $response["queryModule"] = $queryParams->module;
            GoogleSheetController::saveRefreshedToken($queryParams->id, $response['tokenDetails'], $response);
        }
        wp_send_json_success($response, 200);
    }

    /**
     * Helps to refresh zoho crm access_token
     *
     * @param Array $apiData Contains required data for refresh access token
     * 
     * @return JSON  $tokenDetails API token details
     */
    protected static function refreshAccessToken($apiData)
    {
        if (empty($apiData->clientId)
            || empty($apiData->clientSecret)
            || empty($apiData->tokenDetails)
        ) {
            return false;
        }
        $tokenDetails = $apiData->tokenDetails;

        $apiEndpoint = "https://oauth2.googleapis.com/token";
        $requestParams = array(
            "grant_type" => "refresh_token",
            "client_id" => $apiData->clientId,
            "client_secret" => $apiData->clientSecret,
            "refresh_token" => $tokenDetails->refresh_token,
        );

        $apiResponse = HttpHelper::post($apiEndpoint, $requestParams);
        if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
            return false;
        }
        $tokenDetails->generates_on = \time();
        $tokenDetails->access_token = $apiResponse->access_token;
        return $tokenDetails;
    }

    /**
     * Save updated access_token to avoid unnecessary token generation
     *
     * @param Integer $integrationID ID of Google Sheet Integration
     * @param Obeject $tokenDetails  refreshed token info
     *
     * @return null
     */
    protected static function saveRefreshedToken($integrationID, $tokenDetails, $others = null)
    {
        if (empty($integrationID)) {
            return;
        }

        $flow = new FlowController();
        $gsheetDetails = $flow->get(['id' => $integrationID]);

        if (is_wp_error($gsheetDetails)) {
            return;
        }
        $newDetails = json_decode($gsheetDetails[0]->flow_details);

        $newDetails->tokenDetails = $tokenDetails;
        if (!empty($others['spreadsheets'])) {
            $newDetails->default->workbooks = $others['spreadsheets'];
        }
        if (!empty($others['worksheets'])) {
            $newDetails->default->worksheets = $others['worksheets'];
        }
        if (!empty($others['worksheet_headers'])) {
            $newDetails->default->worksheets->headers->{$others['worksheet']} = $others['worksheet_headers'];
        }

        $flow->update($integrationID, ['flow_details' => \json_encode($newDetails)]);
    }

    public function execute($integrationData, $fieldValues)
    {

        $integrationDetails = $integrationData->flow_details;

        //    wp_send_json_success($integrationDetails);

        $tokenDetails = $integrationDetails->tokenDetails;
        $spreadsheetId = $integrationDetails->spreadsheetId;
        $worksheetName = $integrationDetails->worksheetName;
        $headerRow = $integrationDetails->headerRow;
        $header = $integrationDetails->header;
        $fieldMap = $integrationDetails->field_map;
        $actions = $integrationDetails->actions;
        $defaultDataConf = $integrationDetails->default;
        // wp_send_json_success($fieldMap);
        if (empty($tokenDetails)
            || empty($spreadsheetId)
            || empty($worksheetName)
            || empty($fieldMap)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('module, fields are required for Google sheet api', 'bit-integrations'));
        }

        if ((intval($tokenDetails->generates_on) + (55 * 60)) < time()) {
            $requiredParams['clientId'] = $integrationDetails->clientId;
            $requiredParams['clientSecret'] = $integrationDetails->clientSecret;
            $requiredParams['tokenDetails'] = $tokenDetails;
            $newTokenDetails = GoogleSheetController::refreshAccessToken((object)$requiredParams);
            if ($newTokenDetails) {
                GoogleSheetController::saveRefreshedToken($this->_integrationID, $newTokenDetails);
                $tokenDetails = $newTokenDetails;
            }
        }

        // $actions = $integrationDetails->actions;
        $recordApiHelper = new RecordApiHelper($tokenDetails, $this->_integrationID);

        $gsheetApiResponse = $recordApiHelper->execute(
            $spreadsheetId,
            $worksheetName,
            $headerRow,
            $header,
            $actions,
            $defaultDataConf,
            $fieldValues,
            $fieldMap
        );

        if (is_wp_error($gsheetApiResponse)) {
            return $gsheetApiResponse;
        }
        return $gsheetApiResponse;
    }
}
