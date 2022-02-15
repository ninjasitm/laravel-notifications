<?php

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

$routeBase = config("nitm-notifications.routes.base", "api/notifications");
$routeName = config("nitm-notifications.routes.name", "notification");

Route::middleware(config("nitm-notifications.routes.middleware", ["api"]))
    ->prefix($routeBase)
    ->as($routeName . '.')
    ->namespace(config("nitm-notifications.routes.namespace", 'Nitm\Notifications\Http\Controllers'))
    ->group(
        function () {
            /**
             * Override certain routes
             */
            Route::post("preferences/{preference}", "API\NotificationPreferenceAPIController@update")->name("preferences.update-post");
            Route::post("announcements/{announcement}", "API\AnnouncementAPIController@update")->name("announcements.update-post");
            Route::post("communication-tokens/{communicationToken}", "API\CommunicationTokenAPIController@update")->name("communication-tokens.update-post");

            /**
             * Notification preferences
             */
            Route::apiResource("preferences", "API\NotificationPreferenceAPIController");
            Route::get("preferences/form-config", "API\NotificationPreferenceAPIController@formConfig")->name("preferences.config");

            /**
             * Communication tokens
             */
            Route::apiResource("communication-tokens", "API\CommunicationTokenAPIController")->parameters([
                'communication-tokens' => 'communicationToken',
            ]);
            Route::get("communication-tokens/form-config", "API\CommunicationTokenAPIController@formConfig")->name("communication-tokens.config");

            /**
             * Notification announcements
             */
            Route::apiResource("announcements", "API\AnnouncementAPIController");
            Route::get("announcements/form-config", "API\AnnouncementAPIController@formConfig")->name("announcements.config");

            /**
             * Notification notifications
             */
            Route::post("{notification}", "API\NotificationAPIController@update")->name("update-post");
            Route::apiResource("/", "API\NotificationAPIController")->parameters(['' => 'notification']);
            Route::get("/form-config", "API\NotificationAPIController@formConfig")->name("config");
        }
    );