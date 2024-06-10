<?php

namespace BitCode\FI\Actions\PropovoiceCRM;

use BitCode\FI\Log\LogHandler;
use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private $_integrationID;

    public function __construct($integrationId)
    {
        $this->_integrationID = $integrationId;
    }


    public function generateReqDataFromFieldMap($data, $fieldMap)
    {
        $dataFinal = [];

        foreach ($fieldMap as $key => $value) {
            $triggerValue = $value->formField;
            $actionValue = $value->propovoiceCrmFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public function createLead($finalData)
    {
        $propovoiceLeadInstance = new \Ndpv\Model\Lead();
        return $propovoiceLeadInstance->create($finalData);
    }

    public function execute(
        $fieldValues,
        $fieldMap,
        $integrationDetails,
        $mainAction
    ) {
        $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
        $apiResponse = null;
        if ($mainAction == '1') {
            $tags = is_array($integrationDetails->tags) ? $integrationDetails->tags : explode(',', $integrationDetails->tags);
            $label = $integrationDetails->label;
            $finalData['tags'] = $tags;
            $finalData['level_id'] = $label;
            $apiResponse = $this->createLead($finalData);

            if (!$apiResponse) {
                LogHandler::save($this->_integrationID, 'Lead', 'success', "Lead Created Successfully");
            } else {
                LogHandler::save($this->_integrationID, 'Lead', 'error', json_encode($apiResponse));
            }
        }
        return $apiResponse;
    }
}
