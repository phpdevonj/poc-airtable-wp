<?php
namespace BitCode\FI\Actions\GoogleContacts;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

class RecordApiHelper
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function handleInsertContact($data)
    {
        $apiEndpoint = 'https://people.googleapis.com/v1/people:createContact';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $dataNew = [
            'phoneNumbers' => [
                [
                    'value' => !empty($data['phoneNumber']) ? $data['phoneNumber'] : '',
                ]
            ],
            'names' => [
                [
                    'givenName' => !empty($data['name']) ? $data['name'] : '',

                ]
            ],
            'addresses' => [
                [
                    'city' => !empty($data['city']) ? $data['city'] : '',
                    'country' => !empty($data['country']) ? $data['country'] : '',
                ]
            ],
            'nicknames' => [
                [
                    'value' => !empty($data['nickname']) ? $data['nickname'] : ''
                ]
            ],
            'locations' => [
                [
                    'value' => !empty($data['locations']) ? $data['locations'] : ''
                ]
            ],
            'biographies' => [
                [
                    'value' => !empty($data['biographies']) ? $data['biographies'] : ''
                ]
            ],
            'emailAddresses' => [
                [
                    'value' => !empty($data['email']) ? $data['email'] : ''
                ]
            ],
            'occupations' => [
                [
                    'value' => !empty($data['occupation']) ? $data['occupation'] : ''
                ]
            ],
            'organizations' => [
                [
                    'name' => !empty($data['organization']) ? $data['organization'] : '',
                ]
            ],
        ];

        return HttpHelper::post($apiEndpoint, json_encode($dataNew), $headers);
    }

    public function searchContact($data)
    {
        $apiEndpoint = 'https://people.googleapis.com/v1/people:searchContacts';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $data = [
            'query' => $data['name'],
            'readMask' => 'emailAddresses',
        ];

        return HttpHelper::get($apiEndpoint, $data, $headers);
    }

    public function handleUpdateContact($data, $resourceName, $eTag)
    {
        $apiEndpoint = "https://people.googleapis.com/v1/{$resourceName}:updateContact?updatePersonFields=phoneNumbers,names,emailAddresses";
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $dataNew = [
            'etag' => $eTag,
            'phoneNumbers' => [
                [
                    'value' => !empty($data['phoneNumber']) ? $data['phoneNumber'] : '',
                ]
            ],
            'names' => [
                [
                    'givenName' => !empty($data['name']) ? $data['name'] : '',

                ]
            ],
            'emailAddresses' => [
                [
                    'value' => !empty($data['email']) ? $data['email'] : ''
                ]
            ],
        ];

        return HttpHelper::request($apiEndpoint, 'PATCH', json_encode($dataNew), $headers);
    }

    public function handleUploadPhoto($imageLocation, $resourceName)
    {
        $apiEndpoint = "https://people.googleapis.com/v1/{$resourceName}:updateContactPhoto";
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        // $dataNew = [
        //     "photoBytes" => base64_encode(file_get_contents(json_decode($fieldData['organization'])[0])),
        //     "personFields" => 'addresses,biographies,emailAddresses,names,phoneNumbers'
        // ];

        $dataNew = [
            'photoBytes' => base64_encode(file_get_contents($imageLocation)),
            'personFields' => 'addresses,biographies,emailAddresses,names,phoneNumbers'
        ];

        return HttpHelper::request($apiEndpoint, 'PATCH', json_encode($dataNew), $headers);
    }

    public function executeRecordApi($integrationId, $fieldValues, $fieldMap, $actions, $mainAction)
    {
        $fieldData = [];
        foreach ($fieldMap as $value) {
            if (!empty($value->googleContactsFormField)) {
                if ($value->formField === 'custom' && isset($value->customValue) && Common::replaceFieldWithValue($value->customValue, $fieldValues)) {
                    $fieldData[$value->googleContactsFormField] = Common::replaceFieldWithValue($value->customValue, $fieldValues);
                } else {
                    $fieldData[$value->googleContactsFormField] = is_array($fieldValues[$value->formField]) ? json_encode($fieldValues[$value->formField]) : $fieldValues[$value->formField];
                }
            }
        }

        if ($mainAction === '1') {
            $contactResponse = $this->handleInsertContact($fieldData);
            $imageLocation = $fieldValues[$actions->attachments][0];
            $resourceName = $contactResponse->resourceName;
            if (!empty($imageLocation)) {
                $this->handleUploadPhoto($fieldData, $imageLocation, $resourceName);
            }
            if (!property_exists($contactResponse, 'error')) {
                LogHandler::save($integrationId, wp_json_encode(['type' => 'contact', 'type_name' => 'insert']), 'success', json_encode($contactResponse));
            } else {
                LogHandler::save($integrationId, wp_json_encode(['type' => 'contact', 'type_name' => 'insert']), 'error', json_encode('Fail to add contact'));
            }
            return;
        }

        if ($mainAction === '2') {
            $searchResponse = $this->searchContact($fieldData);
            if (!empty($searchResponse)) {
                $resourceName = $searchResponse->results[0]->person->resourceName;
                $eTag = $searchResponse->results[0]->person->etag;
                if (!empty($resourceName) && !empty($eTag)) {
                    $updateResponse = $this->handleUpdateContact($fieldData, $resourceName, $eTag);
                    if (!property_exists($updateResponse, 'error')) {
                        LogHandler::save($integrationId, wp_json_encode(['type' => 'contact', 'type_name' => 'update']), 'success', json_encode($updateResponse));
                    } else {
                        LogHandler::save($integrationId, wp_json_encode(['type' => 'contact', 'type_name' => 'update']), 'error', json_encode('Fail to update contact'));
                    }
                    $imageLocation = $fieldValues[$actions->attachments][0];
                    if (!empty($imageLocation)) {
                        $this->handleUploadPhoto($imageLocation, $resourceName);
                    }
                    return;
                }
            } else {
                LogHandler::save($integrationId, wp_json_encode(['type' => 'contact', 'type_name' => 'update']), 'error', json_encode('Contact not found, please check the name'));
            }
        }
        return;
    }
}
