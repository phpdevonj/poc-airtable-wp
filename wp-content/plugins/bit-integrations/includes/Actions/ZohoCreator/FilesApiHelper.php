<?php

/**
 * ZohoCreator Files Api
 */

namespace BitCode\FI\Actions\ZohoCreator;

use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Upload files
 */
final class FilesApiHelper
{
    private $_defaultHeader;
    private $_apiDomain;
    private $_payloadBoundary;
    private $_basepath;

    /**
     *
     * @param Object  $tokenDetails Api token details
     * @param Integer $formID       ID of the form, for which integration is executing
     * @param Integer $entryID      Current submittion ID
     */
    public function __construct($tokenDetails, $formID, $entryID)
    {
        $this->_payloadBoundary = wp_generate_password(24);
        $this->_defaultHeader['Authorization'] = "Zoho-oauthtoken {$tokenDetails->access_token}";
        $this->_defaultHeader['content-type'] = "multipart/form-data; boundary=" . $this->_payloadBoundary;
        $this->_apiDomain = \urldecode($tokenDetails->api_domain);
        $this->_basepath = UPLOAD_DIR . DIRECTORY_SEPARATOR . $formID . DIRECTORY_SEPARATOR . $entryID . DIRECTORY_SEPARATOR;
    }

    /**
     * Helps to execute upload files api
     *
     * @param Mixed $files        Files path
     * @param Bool  $isAttachment Check upload type
     * @param Mixed $module       Attachment Module name
     * @param Mixed $recordID     Record id
     *
     * @return Array $uploadedFiles ID's of uploaded file in Zoho Creator
     */
    public function uploadFiles($dataCenter, $files, $accountOwner, $applicationId,  $reportId, $recordId, $fieldId)
    {
        $uploadFileEndpoint = "https://creator.zoho.{$dataCenter}/api/v2/{$accountOwner}/{$applicationId}/report/{$reportId}/{$recordId}/{$fieldId}/upload";
        $payload = '';
        if (is_array($files)) {
            foreach ($files as $fileIndex => $fileName) {
                if (file_exists("{$this->_basepath}{$fileName}")) {
                    $payload .= '--' . $this->_payloadBoundary;
                    $payload .= "\r\n";
                    $payload .= 'Content-Disposition: form-data; name="' . 'file' .
                        '"; filename="' . basename("{$this->_basepath}{$fileName}") . '"' . "\r\n";
                    $payload .= "\r\n";
                    $payload .= file_get_contents("{$this->_basepath}{$fileName}");
                    $payload .= "\r\n";
                }
            }
        } elseif (file_exists("{$this->_basepath}{$files}")) {
            $payload .= '--' . $this->_payloadBoundary;
            $payload .= "\r\n";
            $payload .= 'Content-Disposition: form-data; name="' . 'file' .
                '"; filename="' . basename("{$this->_basepath}{$files}") . '"' . "\r\n";
            $payload .= "\r\n";
            $payload .= file_get_contents("{$this->_basepath}{$files}");
            $payload .= "\r\n";
        }

        if (empty($payload)) {
            return false;
        }
        $payload .= '--' . $this->_payloadBoundary . '--';

        $uploadResponse = HttpHelper::post($uploadFileEndpoint, $payload, $this->_defaultHeader);



        return $uploadResponse;
    }
}
