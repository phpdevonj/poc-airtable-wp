<?php

if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\Actions\Keap\KeapController;
use BitCode\FI\Core\Util\Route;

Route::post('keap_generate_token', [ KeapController::class, 'generateTokens']);
// Route::post('keap_refresh_audience', [ KeapController::class, 'refreshAudience']);
// Route::post('keap_refresh_fields', [ KeapController::class, 'refreshAudienceFields']);
Route::post('keap_fetch_all_tags', [ KeapController::class, 'refreshTagListAjaxHelper']);
