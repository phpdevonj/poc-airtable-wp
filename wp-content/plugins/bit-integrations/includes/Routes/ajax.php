<?php
/***
 * If try to direct access  plugin folder it will Exit
 **/
if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\controller\PostController;
use BitCode\FI\controller\UserController;
use BitCode\FI\Core\Util\Route;
use BitCode\FI\Flow\Flow;
use BitCode\FI\Log\LogHandler;
use BitCode\FI\Triggers\TriggerController;

Route::post('log/get', [LogHandler::class, 'get']);
Route::post('log/delete', [LogHandler::class, 'delete']);

Route::get('trigger/list', [TriggerController::class, 'triggerList']);

Route::get('flow/list', [Flow::class, 'flowList']);
Route::post('flow/get', [Flow::class, 'get']);
Route::post('flow/save', [Flow::class, 'save']);
Route::post('flow/update', [Flow::class, 'update']);
Route::post('flow/delete', [Flow::class, 'delete']);
Route::post('flow/bulk-delete', [Flow::class, 'bulkDelete']);
Route::post('flow/toggleStatus', [Flow::class, 'toggle_status']);
Route::post('flow/clone', [Flow::class, 'flowClone']);

/* Controller */
Route::post('customfield/list', [PostController::class, 'getCustomFields']);
Route::get('pods/list', [PostController::class, 'getPodsPostType']);
Route::post('pods/fields', [PostController::class, 'getPodsField']);
Route::post('user/list', [UserController::class, 'getWpUsers']);
Route::get('role/list', [UserController::class, 'getUserRoles']);
Route::get('page/list', [PostController::class, 'getPages']);
Route::post('post-types/list', [PostController::class, 'getPostTypes']);
/*Controller */