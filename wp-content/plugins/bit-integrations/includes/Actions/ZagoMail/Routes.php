<?php

if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\Actions\ZagoMail\ZagoMailController;
use BitCode\FI\Core\Util\Route;

Route::post('zagoMail_authorize', [ZagoMailController::class, 'zagoMailAuthorize']);
Route::post('zagoMail_refresh_fields', [ZagoMailController::class, 'zagoMailRefreshFields']);
Route::post('zagoMail_lists', [ZagoMailController::class, 'zagoMailLists']);
Route::post('zagoMail_tags', [ZagoMailController::class, 'zagoMailTags']);
