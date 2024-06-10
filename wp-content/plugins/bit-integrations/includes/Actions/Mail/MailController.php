<?php
namespace BitCode\FI\Actions\Mail;

use BitCode\FI\Core\Util\Common;
use BitCode\FI\Log\LogHandler;

final class MailController
{
    /**
     * Helps to execute integration flow for Mail action
     *
     * @param Object $integrationData Details of flow
     * @param Array  $fieldValues     Data to use in send mail
     *
     * @return null
     */
    public function execute($integrationData, $fieldValues)
    {
        $flow = $integrationData->flow_details;
        if (property_exists($flow, 'to')) {
            $mailTo = $this->validateAddresses($flow->to, $fieldValues);
            if (!empty($mailTo)) {
                $mailSubject = property_exists($flow, 'subject') ? Common::replaceFieldWithValue($flow->subject, $fieldValues) : '';
                $mailBody = property_exists($flow, 'body') ? Common::replaceFieldWithValue($flow->body, $fieldValues) : '';

                $mailHeaders = [];
                if (!empty($flow->replyto)) {
                    $mailHeaders = array_merge($mailHeaders, $this->processHeader('Reply-To', $flow->replyto, $fieldValues));
                }
                if (!empty($flow->bcc)) {
                    $mailHeaders = array_merge($mailHeaders, $this->processHeader('Bcc', $flow->bcc, $fieldValues));
                }
                if (!empty($flow->cc)) {
                    $mailHeaders = array_merge($mailHeaders, $this->processHeader('Cc', $flow->cc, $fieldValues));
                }
                if (!empty($flow->from)) {
                    $mailHeaders = array_merge($mailHeaders, $this->processHeader('FROM', $flow->from, $fieldValues));
                }
                $attachments = [];
                if (!empty($flow->attachment)) {
                    $files = $flow->attachment;
                    if (is_array($files)) {
                        foreach ($files as $file) {
                            $attachments = array_merge($attachments, $this->processAttachment($file, $fieldValues));
                        }
                    } elseif (isset($fieldValues[$files])) {
                        $attachments = array_merge($attachments, $this->processAttachment($files, $fieldValues));
                    }
                }
                $mailBody = stripcslashes($mailBody);
                $mailSubject = stripcslashes($mailSubject);
                add_filter('wp_mail_content_type', [self::class, 'filterMailContentType']);
                $status = wp_mail($mailTo, $mailSubject, $mailBody, $mailHeaders, $attachments);
                if (!$status) {
                    $status = wp_mail($mailTo, $mailSubject, $mailBody, $mailHeaders);
                }
                if (!$status) {
                    LogHandler::save($integrationData->id, 'Send Mail', 'failed', "[$flow->name] failed sends mail to " . implode(', ', $mailTo));
                } else {
                    LogHandler::save($integrationData->id, 'Send Mail', 'success', "[$flow->name] successfully sends mail to " . implode(', ', $mailTo));
                }

                remove_filter('wp_mail_content_type', [self::class, 'filterMailContentType']);
            }
        }
    }

    public static function filterMailContentType()
    {
        return 'text/html; charset=UTF-8';
    }

    public function validateAddresses($emailAddresses, $fieldValues)
    {
        if (!is_array($emailAddresses)) {
            return [Common::replaceFieldWithValue($emailAddresses, $fieldValues)];
        }
        foreach ($emailAddresses as $key => $email) {
            if (!is_email($email)) {
                $email = Common::replaceFieldWithValue($email, $fieldValues);
            }
            if (is_email($email)) {
                $emailAddresses[$key] = $email;
            }
        }
        return $emailAddresses;
    }

    public function processHeader($type, $address, $fields)
    {
        $headers = [];
        $addresses = $this->validateAddresses($address, $fields);
        if (is_array($addresses)) {
            foreach ($addresses as $address) {
                $headers[] = "$type: " . explode('@', $address)[0] . '<' . sanitize_email($address) . '>';
            }
        } else {
            $headers[] = "$type: " . explode('@', $addresses)[0] . '<' . sanitize_email($addresses) . '>';
        }
        return $headers;
    }

    public function processAttachment($file, $fields)
    {
        $attachments = [];
        if (isset($fields[$file])) {
            if (is_array($fields[$file])) {
                foreach ($fields[$file] as $singleFile) {
                    if (\is_readable("{$singleFile}")) {
                        $attachments[] = "{$singleFile}";
                    }
                }
            } elseif (\is_readable("{$fields[$file]}")) {
                $attachments[] = "{$fields[$file]}";
            }
        }
        return $attachments;
    }
}
