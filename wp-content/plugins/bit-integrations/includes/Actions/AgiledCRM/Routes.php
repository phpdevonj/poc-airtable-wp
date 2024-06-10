<?php
if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\Actions\AgiledCRM\AgiledCRMController;
use BitCode\FI\Core\Util\Route;

Route::post('agiled_authentication', [AgiledCRMController::class, 'authentication']);
Route::post('agiled_fetch_all_owners', [AgiledCRMController::class, 'getAllOwners']);
Route::post('agiled_fetch_all_accounts', [AgiledCRMController::class, 'getAllAccounts']);
Route::post('agiled_fetch_all_sources', [AgiledCRMController::class, 'getAllSources']);
Route::post('agiled_fetch_all_statuses', [AgiledCRMController::class, 'getAllStatuses']);
Route::post('agiled_fetch_all_lifeCycleStages', [AgiledCRMController::class, 'getAllLifeCycleStage']);
Route::post('agiled_fetch_all_CRMPipelines', [AgiledCRMController::class, 'getAllCRMPipelines']);
Route::post('agiled_fetch_all_CRMPipelineStages', [AgiledCRMController::class, 'getAllCRMPipelineStages']);
