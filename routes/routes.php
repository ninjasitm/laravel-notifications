<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(
    function () {
        /**
         * Notification preferences
         */
        Route::post('/notifications/preferences/{preference}', 'API\NotificationPreferenceAPIController@update');
        Route::apiResource('/notifications/preferences', 'API\NotificationPreferenceAPIController');
        Route::get('/notifications/preferences/form-config', 'API\NotificationPreferenceAPIController@formConfig');
    }
);