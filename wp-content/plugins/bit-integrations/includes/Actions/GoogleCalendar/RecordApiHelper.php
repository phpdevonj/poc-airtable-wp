<?php

namespace BitCode\FI\Actions\GoogleCalendar;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Core\Util\HttpHelper;
use BitCode\FI\Log\LogHandler;

class RecordApiHelper
{
    protected $token;
    protected $timeZone;
    protected $calendarId;

    public function __construct($token, $calendarId, $timeZone)
    {
        $this->token = $token;
        $this->timeZone = $timeZone;
        $this->calendarId = $calendarId;
    }

    public function insertEvent($data)
    {
        $apiEndpoint = 'https://www.googleapis.com/calendar/v3/calendars/' . $this->calendarId . '/events';
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];
        return HttpHelper::post($apiEndpoint, json_encode($data), $headers);
    }

    public function freeSlotCheck($startTime, $endTime)
    {
        $apiEndpoint = 'https://www.googleapis.com/calendar/v3/freeBusy';
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];
        $body = [
            'timeMin'  => $startTime,
            'timeMax'  => $endTime,
            'timeZone' => $this->timeZone,
            'items'    => [[
                'id' => $this->calendarId,
            ]],
        ];
        return HttpHelper::post($apiEndpoint, json_encode($body), $headers);
    }

    public function handleInsert($fieldData, $reminderFieldMap, $actions)
    {
        $data = [];
        $dateType = 'dateTime';
        foreach ($fieldData as $title => $value) {
            if ($title === 'start' || $title === 'end') {
                $date = new \DateTime($value, new \DateTimeZone($this->timeZone));
                if (isset($actions->allDayEvent)) {
                    $data[$title]['date'] = $date->format('Y-m-d');
                    $dateType = 'date';
                } else {
                    $data[$title]['dateTime'] = $date->format('Y-m-d\TH:i:sP');
                }
                $data[$title]['timeZone'] = $this->timeZone;
                continue;
            }
            $data[$title] = $value;
        }

        if (isset($actions->reminders) && count($reminderFieldMap) > 0) {
            $data['reminders'] = [
                'useDefault' => false,
                'overrides'  => $reminderFieldMap
            ];
        }

        if (isset($actions->skipIfSlotNotEmpty)) {
            $apiResponse = $this->freeSlotCheck($data['start'][$dateType], $data['end'][$dateType]);

            if (is_wp_error($apiResponse) || !empty($apiResponse->error)) {
                return $apiResponse;
            };
            if (empty($apiResponse->calendars->{$this->calendarId}->busy)) {
                return $this->insertEvent($data);
            };
            return 'No free slot at this time';
        }

        return $this->insertEvent($data);
    }

    public function executeRecordApi($integrationId, $fieldValues, $fieldMap, $reminderFieldMap, $actions)
    {
        $fieldData = [];
        foreach ($fieldMap as $value) {
            if (!empty($value->googleCalendarFormField)) {
                if ($value->formField === 'custom') {
                    $replaceFieldWithValue = Common::replaceFieldWithValue($value->customValue, $fieldValues);
                    if (isset($replaceFieldWithValue)) {
                        $fieldData[$value->googleCalendarFormField] = $replaceFieldWithValue;
                    }
                } else {
                    $fieldData[$value->googleCalendarFormField] = is_array($fieldValues[$value->formField]) ? json_encode($fieldValues[$value->formField]) : $fieldValues[$value->formField];
                }
            }
        }
        $reminderFieldMap = [...array_filter($reminderFieldMap, fn ($value) => !empty($value->method) && !empty($value->minutes))];

        $apiResponse = $this->handleInsert($fieldData, $reminderFieldMap, $actions);

        if (!isset($apiResponse->id)) {
            if (isset($apiResponse->error)) {
                LogHandler::save($integrationId, wp_json_encode(['type' => 'record', 'type_name' => 'insert']), 'error', $apiResponse);
            }
            LogHandler::save($integrationId, wp_json_encode(['type' => 'record', 'type_name' => 'insert']), 'error', 'Please check if your have access to insert event in this selected calendar.');
        } else {
            LogHandler::save($integrationId, wp_json_encode(['type' => 'record', 'type_name' => 'insert']), 'success', $apiResponse);
        }
        return;
    }
}
