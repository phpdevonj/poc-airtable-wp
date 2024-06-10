<?php

/**
 * Fluent CRM Record Api
 */

namespace BitCode\FI\Actions\FluentCrm;

use BitCode\FI\Log\LogHandler;
use FluentCrm\App\Models\Subscriber;
use FluentCrm\Includes\Helpers\Arr;

/**
 * Provide functionality for Record insert
 */
class RecordApiHelper
{
    private $_integrationID;
    public function __construct($integId)
    {
        $this->_integrationID = $integId;
    }

    public function insertRecord($data, $actions)
    {

        // for exsist user
        $subscriber = Subscriber::where('email', $data['email'])->first();

        if ($subscriber && isset($actions->skip_if_exists) && $actions->skip_if_exists) {
            $response = [
                'success' => false,
                'messages' => 'Contact already exists!'
            ];
        } else {
            // for subscirber
            if (!$subscriber) {
                if (isset($actions->double_opt_in) && $actions->double_opt_in) {
                    $data['status'] = 'pending';
                } else {
                    $data['status'] = 'subscribed';
                }

                $subscriber = FluentCrmApi('contacts')->createOrUpdate($data, false, false);

                if ($subscriber->status === 'pending') {
                    $subscriber->sendDoubleOptinEmail();
                }
                if ($subscriber) {
                    $response = [
                        'success' => true,
                        'messages' => 'Insert successfully!'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'messages' => 'Something wrong!'
                    ];
                }
            } else {

                $hasDouBleOptIn = isset($actions->double_opt_in) && $actions->double_opt_in;

                $forceSubscribed = !$hasDouBleOptIn && ($subscriber->status != 'subscribed');

                if ($forceSubscribed) {
                    $data['status'] = 'subscribed';
                }

                $subscriber = FluentCrmApi('contacts')->createOrUpdate($data, $forceSubscribed, false);

                if ($hasDouBleOptIn && ($subscriber->status === 'pending' || $subscriber->status === 'unsubscribed')) {
                    $subscriber->sendDoubleOptinEmail();
                }
                if ($subscriber) {
                    $response = [
                        'success' => true,
                        'messages' => 'Insert successfully!'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'messages' => 'Something wrong!'
                    ];
                }
            }
        }
        return $response;
    }

    public function insertDeleteTag($data, $actionName)
    {
        $subscriber = Subscriber::where('email', $data['email'])->first();

        if (!$subscriber) {
            return $response = [
                'success' => false,
                'messages' => "Contact doesn't exists!"
            ];
        }

        $tags = $data['tags'];

        if ($actionName === 'add-tag') {
            $subscriber->attachTags($tags);

            return $response = [
                'success' => true,
                'messages' => 'Tag added successfully!'
            ];
        } else {
            $subscriber->detachTags($tags);

            return $response = [
                'success' => true,
                'messages' => 'Tag remove successfully!'
            ];
        }
    }

    public function removeUser($data)
    {
        $subscriber = Subscriber::where('email', $data['email'])->first();

        if (!$subscriber) {
            return $response = [
                'success' => false,
                'messages' => "Contact doesn't exists!"
            ];
        }

        $listId = $data['lists'];

        $subscriber->detachLists($listId);

        return $response = [
            'success' => true,
            'messages' => 'User remove from list successfully!'
        ];
    }

    public function execute($fieldValues, $fieldMap, $actions, $list_id, $tags, $actionName)
    {
        $fieldData = [];

        foreach ($fieldMap as $fieldKey => $fieldPair) {
            if (!empty($fieldPair->fluentCRMField)) {
                if ($fieldPair->formField === 'custom' && isset($fieldPair->customValue)) {
                    $fieldData[$fieldPair->fluentCRMField] = $fieldPair->customValue;
                } else {
                    $fieldData[$fieldPair->fluentCRMField] = $fieldValues[$fieldPair->formField];
                }
            }
        }

        if (!is_null($list_id)) {
            $fieldData['lists'] = [$list_id];
        }
        if (!is_null($tags)) {
            $fieldData['tags'] = $tags;
        }

        switch ($actionName) {
            case "add-tag":
            case "remove-tag":
                $recordApiResponse = $this->insertDeleteTag($fieldData, $actionName);
                break;
            case "add-user":
                $recordApiResponse = $this->insertRecord($fieldData, $actions);
                break;
            case "remove-user":
                $recordApiResponse = $this->removeUser($fieldData);
                break;
        }

        if ($recordApiResponse['success']) {
            LogHandler::save($this->_integrationID, ['type' =>  'record', 'type_name' => $actionName], 'success', $recordApiResponse);
        } else {
            LogHandler::save($this->_integrationID, ['type' =>  'record', 'type_name' => $actionName], 'error', $recordApiResponse);
        }
        return $recordApiResponse;
    }
}
