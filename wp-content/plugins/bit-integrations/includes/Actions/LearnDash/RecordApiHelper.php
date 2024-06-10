<?php

/**
 * trello Record Api
 */

namespace BitCode\FI\Actions\LearnDash;

use LDLMS_DB;
use BitCode\FI\Log\LogHandler;
use BitCode\FI\Core\Util\Common;
use BitCode\FI\Actions\Mail\MailController;

/**
 * Provide functionality for Record insert, upsert
 */
class RecordApiHelper
{
    private static $integrationID;
    private $_integrationDetails;
    private $quiz_list;
    private $assignment_list;

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
            $actionValue = $value->learnDeshFormField;
            if ($triggerValue === 'custom') {
                $dataFinal[$actionValue] = Common::replaceFieldWithValue($value->customValue, $data);
            } elseif (!is_null($data[$triggerValue])) {
                $dataFinal[$actionValue] = $data[$triggerValue];
            }
        }
        return $dataFinal;
    }

    public static function createGroup(
        $finalData,
        $courseIds,
        $userRole
    ) {
        $user_id = get_current_user_id();
        $group_title = $finalData['title'];

        $ld_group_args = [
            'post_type' => 'groups',
            'post_status' => apply_filters('uo_create_new_group_status', 'publish'),
            'post_title' => $group_title,
            'post_content' => '',
            'post_author' => $user_id,
        ];

        $group_id = wp_insert_post($ld_group_args);
        if (is_wp_error($group_id)) {
            return;
        }


        $user = get_user_by('ID', $user_id);

        switch ($userRole) {
            case '2':
                $user->add_role('group_leader');
                break;
            case '3':
                $user->set_role('group_leader');
                break;
        }
        ld_update_leader_group_access($user_id, $group_id);


        $group_courses = explode(',', $courseIds);

        if (!empty($group_courses)) {
            foreach ($group_courses as $course_id) {
                ld_update_course_group_access((int) $course_id, (int) $group_id, false);
                $transient_key = 'learndash_course_groups_' . $course_id;
                delete_transient($transient_key);
            }
        }

        return $group_id;
    }

    public static function enrollTheUserInACourse($courseIds)
    {
        $user_id = get_current_user_id();

        if (!function_exists('ld_update_course_access')) {
            $error_message = 'The function ld_update_course_access does not exist';
            return $error_message;
        }

        $course_id = $courseIds;

        $apiResponse = ld_update_course_access($user_id, $course_id);
        return $apiResponse;
    }

    public static function makeThUserTheLeaderOfGroup($leaderRole, $leaderOfGroup)
    {
        $user_id = get_current_user_id();
        $user = get_user_by('ID', $user_id);

        if (is_wp_error($user)) {
            return;
        }

        if (user_can($user, 'group_leader')) {
            ld_update_leader_group_access($user_id, $leaderOfGroup);

            return;
        }

        switch ($leaderRole) {
            case '2':
                $user->add_role('group_leader');
                $apiResponse = ld_update_leader_group_access($user_id, $leaderOfGroup);
                break;
            case '3':
                $user->set_role('group_leader');
                $apiResponse = ld_update_leader_group_access($user_id, $leaderOfGroup);
                break;
        }
        return $apiResponse;
    }

    // Mark the course as complete for the user function 4.
    public static function mark_quiz_complete($user_id, $course_id = null)
    {
        $quizzes = learndash_get_course_quiz_list($course_id, $user_id);
        if ($quizzes) {
            foreach ($quizzes as $quiz) {
                $quiz_list[$quiz['post']->ID] = 0;
            }
        }
        $quizz_progress = [];
        if (!empty($quiz_list)) {
            $usermeta = get_user_meta($user_id, '_sfwd-quizzes', true);
            $quizz_progress = empty($usermeta) ? [] : $usermeta;

            foreach ($quiz_list as $quiz_id => $quiz) {
                $quiz_meta = get_post_meta($quiz_id, '_sfwd-quiz', true);

                if (learndash_is_quiz_complete($user_id, $quiz_id, $course_id)) {
                    continue;
                }

                $quizdata = [
                    'quiz' => $quiz_id,
                    'score' => 0,
                    'count' => 0,
                    'pass' => true,
                    'rank' => '-',
                    'time' => time(),
                    'pro_quizid' => $quiz_meta['sfwd-quiz_quiz_pro'],
                    'course' => $course_id,
                    'points' => 0,
                    'total_points' => 0,
                    'percentage' => 100,
                    'timespent' => 0,
                    'has_graded' => false,
                    'statistic_ref_id' => 0,
                    'm_edit_by' => 9999999,
                    'm_edit_time' => time(),
                ];

                $quizz_progress[] = $quizdata;

                if ($quizdata['pass'] == true) {
                    $quizdata_pass = true;
                } else {
                    $quizdata_pass = false;
                }

                learndash_update_user_activity(
                    [
                        'course_id' => $course_id,
                        'user_id' => $user_id,
                        'post_id' => $quiz_id,
                        'activity_type' => 'quiz',
                        'activity_action' => 'insert',
                        'activity_status' => true,
                        'activity_started' => $quizdata['time'],
                        'activity_completed' => $quizdata['time'],
                        'activity_meta' => $quizdata,
                    ]
                );
            }
        }

        if (!empty($quizz_progress)) {
            update_user_meta($user_id, '_sfwd-quizzes', $quizz_progress);
        }
    }

    //  function 3.
    public static function mark_topics_done($user_id, $lesson_id, $course_id)
    {
        $topic_list = learndash_get_topic_list($lesson_id, $course_id);
        if ($topic_list) {
            foreach ($topic_list as $topic) {
                learndash_process_mark_complete($user_id, $topic->ID, false, $course_id);
                $topic_quiz_list = learndash_get_lesson_quiz_list($topic->ID, $user_id, $course_id);
                if ($topic_quiz_list) {
                    foreach ($topic_quiz_list as $ql) {
                        $quiz_list[$ql['post']->ID] = 0;
                    }
                }
            }
        }
    }

    //  user function 2.
    public static function mark_steps_done($user_id, $course_id)
    {
        $lessons = learndash_get_lesson_list($course_id, ['num' => 0]);
        foreach ($lessons as $lesson) {
            self::mark_topics_done($user_id, $lesson->ID, $course_id);
            $lesson_quiz_list = learndash_get_lesson_quiz_list($lesson->ID, $user_id, $course_id);

            if ($lesson_quiz_list) {
                foreach ($lesson_quiz_list as $ql) {
                    $quiz_list[$ql['post']->ID] = 0;
                }
            }

            learndash_process_mark_complete($user_id, $lesson->ID, false, $course_id);
        }

        self::mark_quiz_complete($user_id, $course_id);
    }

    //  user function 1.
    public static function markACourseCompleteForTheUser($courseIds)
    {
        $user_id = get_current_user_id();
        $course_id = $courseIds;
        self::mark_steps_done($user_id, $course_id);
        $apiResponse = learndash_process_mark_complete($user_id, $course_id);
        return $apiResponse;
    }

    // action 6 and 1st part
    public static function courseLessonComplete(
        $courseIds,
        $lessonId
    ) {
        $user_id = get_current_user_id();
        return self::mark_steps_done_for_six($user_id, $lessonId, $courseIds);
    }

    public static function mark_steps_done_for_six($user_id, $lesson_id, $course_id)
    {
        $topic_list = learndash_get_topic_list($lesson_id, $course_id);

        if ($topic_list) {
            foreach ($topic_list as $topic) {
                $topic_quiz_list = learndash_get_lesson_quiz_list($topic->ID, $user_id, $course_id);
                if ($topic_quiz_list) {
                    foreach ($topic_quiz_list as $ql) {
                        $quiz_list[$ql['post']->ID] = 0;
                    }
                }

                self::mark_quiz_complete($user_id, $course_id);

                learndash_process_mark_complete($user_id, $topic->ID, false, $course_id);
            }
        }

        $lesson_quiz_list = learndash_get_lesson_quiz_list($lesson_id, $user_id, $course_id);

        if ($lesson_quiz_list) {
            foreach ($lesson_quiz_list as $ql) {
                self::$quiz_list[$ql['post']->ID] = 0;
            }
        }

        self::mark_quiz_complete($user_id, $course_id);

        return learndash_process_mark_complete($user_id, $lesson_id, false, $course_id);
    }

    public static function topicComplete(
        $course_id,
        $lessonId,
        $topic_id
    ) {
        $user_id = get_current_user_id();
        $topic_quiz_list = learndash_get_lesson_quiz_list($topic_id, $user_id, $course_id);
        if ($topic_quiz_list) {
            foreach ($topic_quiz_list as $ql) {
                $quiz_list[$ql['post']->ID] = 0;
            }
        }

        self::mark_quiz_complete($user_id, $course_id);

        return learndash_process_mark_complete($user_id, $topic_id, false, $course_id);
    }

    public static function addUserToGroup($group_id)
    {
        $user_id = get_current_user_id();
        $check_group = learndash_validate_groups([$group_id]);
        if (empty($check_group)) {
            LogHandler::save(self::getIntegrationId(), json_encode(['type' => 'group', 'type_name' => 'Add-the-user-to-a-group']), 'error', json_encode('Group not found'));
        }
        return ld_update_group_access($user_id, $group_id);
    }

    // action 7 starts here
    public function courseLessonNotComplete(
        $course_id,
        $lesson_id
    ) {
        $user_id = get_current_user_id();

        $this->mark_steps_incomplete($user_id, $lesson_id, $course_id);

        learndash_process_mark_incomplete($user_id, $course_id, $lesson_id, false);
    }

    public function mark_steps_incomplete($user_id, $lesson_id, $course_id)
    {
        $topic_list = learndash_get_topic_list($lesson_id, $course_id);

        if ($topic_list) {
            foreach ($topic_list as $topic) {
                learndash_process_mark_incomplete($user_id, $course_id, $topic->ID, false);
                $topic_quiz_list = learndash_get_lesson_quiz_list($topic->ID, $user_id, $course_id);
                if ($topic_quiz_list) {
                    foreach ($topic_quiz_list as $ql) {
                        learndash_delete_quiz_progress($user_id, $ql['post']->ID);
                    }
                }
            }
        }

        $lesson_quiz_list = learndash_get_lesson_quiz_list($lesson_id, $user_id, $course_id);

        if ($lesson_quiz_list) {
            foreach ($lesson_quiz_list as $ql) {
                learndash_delete_quiz_progress($user_id, $ql['post']->ID);
            }
        }
    }

    public static function mark_quiz_incomplete($user_id, $course_id = null)
    {
        if (!empty($quiz_list)) {
            foreach ($quiz_list as $quiz_id => $quiz) {
                learndash_delete_quiz_progress($user_id, $quiz_id);
            }
        }
    }
    // action 7 ends here

    // action 9 starts here

    public static function topicNotComplete(
        $course_id,
        $lessonId,
        $topic_id
    ) {
        // }

        // public function mark_not_complete_a_topic( $user_id, $action_data, $recipe_id, $args ) {

        $user_id = get_current_user_id();

        $topic_quiz_list = learndash_get_lesson_quiz_list($topic_id, $user_id, $course_id);
        if ($topic_quiz_list) {
            foreach ($topic_quiz_list as $ql) {
                $quiz_list[$ql['post']->ID] = 0;
            }
        }

        self::mark_quiz_incomplete($user_id, $course_id);

        return learndash_process_mark_incomplete($user_id, $course_id, $topic_id, false);
    }

    // action 9 ends here

    // action 11 starts here

    public static function removeUserToGroup($group_id)
    {
        $user_id = get_current_user_id();
        if ('-1' !== $group_id) {
            $apiResponse = ld_update_group_access($user_id, $group_id, true);
        } else {
            $all_groups_list = learndash_get_users_group_ids($user_id);
            foreach ($all_groups_list as $group_id) {
                $apiResponse = ld_update_group_access($user_id, $group_id, true);
            }
        }
        return $apiResponse;
    }

    // action 11 ends here

    // action 13 starts here

    public function resetQuiz($quiz_id)
    {
        $user_id = get_current_user_id();

        if ('-1' !== $quiz_id) {
            self::delete_quiz_progress($user_id, $quiz_id);
        }
    }

    public static function delete_quiz_progress($user_id, $quiz_id = null)
    {
        global $wpdb;

        if (!empty($quiz_id)) {
            $usermeta = get_user_meta($user_id, '_sfwd-quizzes', true);
            $quizz_progress = empty($usermeta) ? [] : $usermeta;
            foreach ($quizz_progress as $k => $p) {
                if ((int) $p['quiz'] !== (int) $quiz_id) {
                    continue;
                } else {
                    $statistic_ref_id = $p['statistic_ref_id'];
                    unset($quizz_progress[$k]);
                    if (!empty($statistic_ref_id)) {
                        if (class_exists('\LDLMS_DB')) {
                            $pro_quiz_stat_table = LDLMS_DB::get_table_name('quiz_statistic');
                            $pro_quiz_stat_ref_table = LDLMS_DB::get_table_name('quiz_statistic_ref');
                        } else {
                            $pro_quiz_stat_table = $wpdb->prefix . 'wp_pro_quiz_statistic';
                            $pro_quiz_stat_ref_table = $wpdb->prefix . 'wp_pro_quiz_statistic_ref';
                        }

                        $wpdb->query($wpdb->prepare("DELETE FROM {$pro_quiz_stat_table} WHERE statistic_ref_id = %d", $statistic_ref_id));
                        $wpdb->query($wpdb->prepare("DELETE FROM {$pro_quiz_stat_ref_table} WHERE statistic_ref_id = %d", $statistic_ref_id));
                    }
                }
            }
            $apiResponse = update_user_meta($user_id, '_sfwd-quizzes', $quizz_progress);
            return $apiResponse;
        }
        return false;
    }

    // action 13 ends here

    // action 17 starts here

    public function UnenrollUserFromCourse($course_id)
    {
        $user_id = 5;

        if ('any' === $course_id) {
            $user_courses = learndash_user_get_enrolled_courses($user_id);
            foreach ($user_courses as $course_id) {
                $apiResponse = ld_update_course_access($user_id, $course_id, true);
            }
        } else {
            $apiResponse = ld_update_course_access($user_id, $course_id, true);
        }

        return $apiResponse;
    }

    // action 17 ends here

    // action 10 starts here

    // public function remove_from_group( $user_id, $action_data, $recipe_id, $args )

    public static function removeGroupLeaderAndChildren($group_id)
    {
        $user_id = get_current_user_id();
        if (!self::is_group_hierarchy_enabled()) {
            $error_message = 'The LearnDash Group hierarchy setting is not enabled.';
            LogHandler::save(self::getIntegrationId(), json_encode(['type' => 'group', 'type_name' => 'remove-leader-from-group']), 'error', json_encode($error_message));
            return;
        }

        $all_hierarchy_groups = self::get_group_children_in_an_action($group_id, 1, []);
        array_push($all_hierarchy_groups, $group_id);
        $all_groups_list = learndash_get_administrators_group_ids($user_id, true);
        $common = array_intersect($all_hierarchy_groups, $all_groups_list);

        if (!$common) {
            $error_message = 'The Group Leader is not an admin of any of the groups in hierarchy.';
            LogHandler::save(self::getIntegrationId(), json_encode(['type' => 'group', 'type_name' => 'remove-leader-from-group']), 'error', json_encode($error_message));

            return;
        }
        foreach ($common as $group_id) {
            $apiResponse = ld_update_leader_group_access($user_id, $group_id, true);
        }
        return $apiResponse;
    }

    public static function is_group_hierarchy_enabled()
    {
        $settings = get_option('learndash_settings_groups_management_display');
        if (empty($settings)) {
            return false;
        }
        if (!isset($settings['group_hierarchical_enabled'])) {
            return false;
        }
        if ('yes' !== $settings['group_hierarchical_enabled']) {
            return false;
        }

        return true;
    }

    public static function get_group_children_in_an_action($parent_id, $depth = 1, $groups = [])
    {
        $args = [
            'post_type' => 'groups',
            'posts_per_page' => 9999,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
        ];
        $results = get_posts($args);
        if ($results) {
            foreach ($results as $r) {
                $group_id = $r->ID;
                $groups[] = $group_id;
                $ld_children = learndash_get_group_children($group_id);
                $groups = array_merge($groups, $ld_children);
                self::get_group_children_in_an_action($r->ID, ++$depth, $groups);
            }
        }
        if (empty($groups)) {
            return [];
        }
        $ld_children = learndash_get_group_children($parent_id);

        return array_unique(array_merge($groups, $ld_children));
    }

    // action 10 ends here

    // action 12 starts here
    public static function removeUserAndChildrenFromGroup($group_id)
    {
        $user_id = get_current_user_id();

        if (!self::is_group_hierarchy_enabled()) {
            $error_message = 'The LearnDash Group hierarchy setting is not enabled.';
            LogHandler::save(self::getIntegrationId(), json_encode(['type' => 'group', 'type_name' => 'remove-user-from-group']), 'error', json_encode($error_message));
            return;
        }
        $all_hierarchy_groups = self::get_group_children_in_an_action($group_id, 1, []);
        array_push($all_hierarchy_groups, $group_id);
        $all_current_user_groups = learndash_get_users_group_ids($user_id, true);
        $common = array_intersect($all_hierarchy_groups, $all_current_user_groups);
        if (!$common) {
            $error_message = 'The user does not belong to any of the groups in the hierarchy.';
            LogHandler::save(self::getIntegrationId(), json_encode(['type' => 'group', 'type_name' => 'remove-user-from-group']), 'error', json_encode($error_message));
            return;
        }
        foreach ($common as $group_id) {
            $apiResponse = ld_update_group_access($user_id, $group_id, true);
        }

        return $apiResponse;
    }

    // action 12 ends here

    // action 14 starts here

    public static function resetUserProgressInCourse($course_id)
    {
        $user_id = get_current_user_id();
        $reset_tc_data = false;

        if ('-1' !== $course_id) {
            self::delete_user_activity($user_id, $course_id);
            if (self::delete_course_progress($user_id, $course_id)) {
                self::reset_quiz_progress($user_id, $course_id);
                self::delete_assignments();
            }
            // }
            $apiResponse = self::reset_quiz_progress($user_id, $course_id);
        }
        return $apiResponse;
    }

    public static function delete_user_activity($user_id, $course_id)
    {
        global $wpdb;
        delete_user_meta($user_id, 'completed_' . $course_id);
        delete_user_meta($user_id, 'course_completed_' . $course_id);
        delete_user_meta($user_id, 'learndash_course_expired_' . $course_id);

        $activity_ids = $wpdb->get_results($wpdb->prepare("SELECT activity_id FROM ' . $wpdb->prefix . 'learndash_user_activity WHERE course_id = %d AND user_id = %d", $course_id, $user_id));

        if ($activity_ids) {
            foreach ($activity_ids as $activity_id) {
                $wpdb->query($wpdb->prepare("DELETE FROM  {$wpdb->prefix}learndash_user_activity_meta WHERE activity_id = %d", $activity_id->activity_id));
                $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}learndash_user_activity WHERE activity_id = %d", $activity_id->activity_id));
            }
        }
    }

    public static function delete_course_progress($user_id, $course_id)
    {
        $usermeta = get_user_meta($user_id, '_sfwd-course_progress', true);
        if (!empty($usermeta) && isset($usermeta[$course_id])) {
            unset($usermeta[$course_id]);
            update_user_meta($user_id, '_sfwd-course_progress', $usermeta);

            return true;
        }

        return false;
    }

    public static function reset_quiz_progress($user_id, $course_id)
    {
        $lessons = learndash_get_lesson_list($course_id, ['num' => 0]);
        foreach ($lessons as $lesson) {
            self::get_topics_quiz($user_id, $lesson->ID, $course_id);
            $lesson_quiz_list = learndash_get_lesson_quiz_list($lesson->ID, $user_id, $course_id);

            if ($lesson_quiz_list) {
                foreach ($lesson_quiz_list as $ql) {
                    $quiz_list[$ql['post']->ID] = 0;
                }
            }

            $assignments = get_posts([
                'post_type' => 'sfwd-assignment',
                'posts_per_page' => 999,
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'lesson_id',
                        'value' => $lesson->ID,
                        'compare' => '=',
                    ],
                    [
                        'key' => 'course_id',
                        'value' => $course_id,
                        'compare' => '=',
                    ],
                    [
                        'key' => 'user_id',
                        'value' => $user_id,
                        'compare' => '=',
                    ],
                ],
            ]);

            if ($assignments) {
                foreach ($assignments as $assignment) {
                    $assignment_list[] = $assignment->ID;
                }
            }
        }

        self::delete_quiz_progress($user_id, $course_id);
    }

    public static function get_topics_quiz($user_id, $lesson_id, $course_id)
    {
        $topic_list = learndash_get_topic_list($lesson_id, $course_id);
        if ($topic_list) {
            foreach ($topic_list as $topic) {
                $topic_quiz_list = learndash_get_lesson_quiz_list($topic->ID, $user_id, $course_id);
                if ($topic_quiz_list) {
                    foreach ($topic_quiz_list as $ql) {
                        $quiz_list[$ql['post']->ID] = 0;
                    }
                }

                $assignments = get_posts([
                    'post_type' => 'sfwd-assignment',
                    'posts_per_page' => 999,
                    'meta_query' => [
                        'relation' => 'AND',
                        [
                            'key' => 'lesson_id',
                            'value' => $topic->ID,
                            'compare' => '=',
                        ],
                        [
                            'key' => 'course_id',
                            'value' => $course_id,
                            'compare' => '=',
                        ],
                        [
                            'key' => 'user_id',
                            'value' => $user_id,
                            'compare' => '=',
                        ],
                    ],
                ]);

                if ($assignments) {
                    foreach ($assignments as $assignment) {
                        $assignment_list[] = $assignment->ID;
                    }
                }
            }
        }
    }

    public static function delete_assignments()
    {
        global $wpdb;
        $assignments = self::getAssignmentList();
        if ($assignments) {
            foreach ($assignments as $assignment) {
                $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->posts} WHERE ID = %d", $assignment));
                $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE post_id = %d", $assignment));
            }
        }
    }


    // action 14 ends here

    // action 16 starts here

    public function sendMailToGroupLeader($integrationData, $fieldValues)
    {
        $mailInstance = new MailController();
        return $mailInstance->execute($integrationData, $fieldValues);
    }

    // action 16 ends here

    public function execute(
        $mainAction,
        $fieldValues,
        $integrationDetails,
        $integrationData
    ) {
        $fieldData = [];
        if ($mainAction === '1') {
            $userRole = $integrationDetails->userRole;
            $fieldMap = $integrationDetails->field_map;
            $finalData = $this->generateReqDataFromFieldMap($fieldValues, $fieldMap);
            $courseIds = $integrationDetails->courseId;
            $apiResponse = self::createGroup(
                $finalData,
                $courseIds,
                $userRole
            );
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'create-group']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'create-group']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '2') {
            $groupId = $integrationDetails->groupId;
            $apiResponse = self::addUserToGroup($groupId);
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Add-the-user-to-a-group']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Add-the-user-to-a-group']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '3') {
            $courseIds = $integrationDetails->courseId;

            $apiResponse = self::enrollTheUserInACourse($courseIds);
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'enroll-user-in-course']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'enroll-user-in-course']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '4') {
            $leaderRole = $integrationDetails->leaderRole;
            $leaderOfGroup = $integrationDetails->leaderOfGroup;
            // $user
            $apiResponse = self::makeThUserTheLeaderOfGroup($leaderRole, $leaderOfGroup);
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Make-the-user-the-leader-of-group']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Make-the-user-the-leader-of-group']), 'success', json_encode($apiResponse));
            }
        }
        if ($mainAction === '5') {
            $courseIds = $integrationDetails->courseId;
            $apiResponse = self::markACourseCompleteForTheUser($courseIds);
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-course-complete-for-the-user']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-course-complete-for-the-user']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '6') {
            $courseIds = $integrationDetails->courseId;
            $lessonId = $integrationDetails->lessonId;
            $apiResponse = self::courseLessonComplete(
                $courseIds,
                $lessonId
            );

            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-lesson-complete-for-the-user']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-lesson-complete-for-the-user']), 'success', json_encode($apiResponse));
            }
        }
        if ($mainAction === '7') {
            $courseIds = $integrationDetails->courseId;
            $lessonId = $integrationDetails->lessonId;
            $apiResponse = self::courseLessonNotComplete(
                $courseIds,
                $lessonId
            );

            if (is_wp_error($apiResponse)) {
                $error_message = 'failed lesson not complete';
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-lesson-complete-for-the-user']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Mark-a-lesson-complete-for-the-user']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '8') {
            $courseIds = $integrationDetails->courseId;
            $lessonId = $integrationDetails->lessonId;
            $topicId = $integrationDetails->topicId;
            $apiResponse = self::topicComplete(
                $courseIds,
                $lessonId,
                $topicId
            );
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'topic-complete-for-the-user']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'topic-complete-for-the-user']), 'success', json_encode($apiResponse));
            }
        }
        if ($mainAction === '9') {
            $courseIds = $integrationDetails->courseId;
            $lessonId = $integrationDetails->lessonId;
            $topicId = $integrationDetails->topicId;
            $apiResponse = self::topicNotComplete(
                $courseIds,
                $lessonId,
                $topicId
            );
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'topic-not-complete-for-the-user']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'topic-not-complete-for-the-user']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '10') {
            $group_id = $integrationDetails->groupId10;
            $apiResponse = self::removeGroupLeaderAndChildren($group_id);
            if ($apiResponse) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-Leader-from-group-and-its-children']), 'success', json_encode('Remove Leader from group and its children successfully'));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-Leader-from-group-and-its-children']), 'error', json_encode('Failed to remove leader from group and its children'));
            }
        }

        if ($mainAction === '11') {
            $groupId = $integrationDetails->groupId11;
            $apiResponse = self::removeUserToGroup($groupId);
            if (is_wp_error($apiResponse)) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-the-user-from-a-group']), 'error', json_encode('Fail to remove user from group'));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-the-user-from-a-group']), 'success', json_encode('User removed from group successfully'));
            }
        }

        if ($mainAction === '12') {
            $group_id = $integrationDetails->groupId12;
            $apiResponse = self::removeUserAndChildrenFromGroup($group_id);
            if ($apiResponse) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-user-from-group-and-its-children']), 'error', json_encode('Remove user from group and its children successfully'));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'Remove-user-from-group-and-its-children']), 'success', json_encode('Failed to remove user from group and its children'));
            }
        }

        if ($mainAction === '13') {
            $quiz_id = $integrationDetails->quizId;
            $apiResponse = self::resetQuiz($quiz_id);
            if (is_wp_error($apiResponse)) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'quiz', 'type_name' => 'Reset-users-attempts-for-quiz']), 'error', json_encode('Fail to reset quiz'));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'quiz', 'type_name' => 'Reset-users-attempts-for-quiz']), 'success', json_encode('Quiz reset successfully'));
            }
        }

        if ($mainAction === '14') {
            $courseIds = $integrationDetails->courseId;

            $apiResponse = self::resetUserProgressInCourse($courseIds);
            if (is_wp_error($apiResponse)) {
                $error_message = $apiResponse->get_error_message();
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'enroll-user-in-course']), 'error', json_encode($error_message));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'group', 'type_name' => 'enroll-user-in-course']), 'success', json_encode($apiResponse));
            }
        }

        if ($mainAction === '16') {
            $apiResponse = self::sendMailToGroupLeader($integrationData, $fieldValues);
        }

        if ($mainAction === '17') {
            $course_id = $integrationDetails->courseId;
            $apiResponse = self::UnenrollUserFromCourse($course_id);
            if ($apiResponse) {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'quiz', 'type_name' => 'users-unEnroll-course']), 'success', json_encode('users-unenroll-course-successfully'));
            } else {
                LogHandler::save(self::$integrationID, json_encode(['type' => 'quiz', 'type_name' => 'users-unEnroll-course']), 'error', json_encode('users-unenroll-course-failed'));
            }
        }

        return $apiResponse;
    }
}
