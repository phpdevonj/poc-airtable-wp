<?php
namespace BitCode\FI\Actions\MasterStudyLms;

use WP_Error;

class MasterStudyLmsController
{
    public static function pluginActive()
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        if (
            is_plugin_active('masterstudy-lms-learning-management-system/masterstudy-lms-learning-management-system.php')
        || is_plugin_active('masterstudy-lms-learning-management-system-pro/                       masterstudy-lms-learning-management-system-pro.php')) {
            return true;
        }
        return false;
    }

    public static function authorizeMasterStudyLms()
    {
        if (self::pluginActive()) {
            wp_send_json_success(true, 200);
        }
        wp_send_json_error(__('MasterStudyLms must be activated!', 'bit-integrations'));
    }

    public static function getAllCourse()
    {
        if (self::pluginActive()) {
            $courses = get_posts([
                'post_type' => 'stm-courses',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ]);
            $courseList = [];
            foreach ($courses as $course) {
                $courseList[] = [
                    'ID' => $course->ID,
                    'post_title' => $course->post_title,
                ];
            }
            wp_send_json_success($courseList, 200);
        }
        wp_send_json_error(__('MasterStudyLms must be activated!', 'bit-integrations'));
    }

    public static function getAllLesson($queryPrarms)
    {
        $courseId = $queryPrarms->courseId;
        if (self::pluginActive()) {
            $allLesson = MasterStudyLmsHelper::getLessonByCourse($courseId);
            wp_send_json_success($allLesson, 200);
        }
        wp_send_json_error(__('MasterStudyLms must be activated!', 'bit-integrations'));
    }

    public static function getAllQuizByCourse($queryPrarms)
    {
        $courseId = $queryPrarms->courseId;
        if (self::pluginActive()) {
            $allQuiz = MasterStudyLmsHelper::getQuizByCourse($courseId);
            wp_send_json_success($allQuiz, 200);
        }
        wp_send_json_error(__('MasterStudyLms must be activated!', 'bit-integrations'));
    }

    public function execute($integrationData, $fieldValues)
    {
        $integrationDetails = $integrationData->flow_details;
        $integId = $integrationData->id;
        $mainAction = $integrationDetails->mainAction;
        if (
            empty($integId) ||
            empty($mainAction)
        ) {
            return new WP_Error('REQ_FIELD_EMPTY', __('Some important info are missing those are required for MasterStudyLms', 'bit-integrations'));
        }
        $recordApiHelper = new RecordApiHelper($integrationDetails, $integId);
        $MasterStudyLmsApiResponse = $recordApiHelper->execute(
            $mainAction,
            $fieldValues,
            $integrationDetails,
            $integrationData
        );

        if (is_wp_error($MasterStudyLmsApiResponse)) {
            return $MasterStudyLmsApiResponse;
        }
        return $MasterStudyLmsApiResponse;
    }
}
