<?php

if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\Actions\MasterStudyLms\MasterStudyLmsController;
use BitCode\FI\Core\Util\Route;

Route::post('MasterStudyLms_authorize', [MasterStudyLmsController::class, 'authorizeMasterStudyLms']);
Route::post('mslms_fetch_all_course', [MasterStudyLmsController::class, 'getAllCourse']);
Route::post('msLms_fetch_all_lesson', [MasterStudyLmsController::class, 'getAllLesson']);
Route::post('msLms_fetch_all_quiz', [MasterStudyLmsController::class, 'getAllQuizByCourse']);
