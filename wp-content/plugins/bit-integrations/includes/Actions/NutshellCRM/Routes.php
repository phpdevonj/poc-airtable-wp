<?php

if (!defined('ABSPATH')) {
    exit;
}

use BitCode\FI\Actions\NutshellCRM\NutshellCRMController;
use BitCode\FI\Core\Util\Route;

Route::post('nutshellcrm_authentication', [NutshellCRMController::class, 'authentication']);
Route::post('nutshellcrm_fetch_all_contacts', [NutshellCRMController::class, 'getContacts']);
Route::post('nutshellcrm_fetch_all_products', [NutshellCRMController::class, 'getProducts']);
Route::post('nutshellcrm_fetch_all_sources', [NutshellCRMController::class, 'getSources']);
Route::post('nutshellcrm_fetch_all_tags', [NutshellCRMController::class, 'getTags']);
Route::post('nutshellcrm_fetch_all_companies', [NutshellCRMController::class, 'getCompanies']);
Route::post('nutshellcrm_fetch_all_companytypes', [NutshellCRMController::class, 'getCompanyTypes']);
