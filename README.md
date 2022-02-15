# Installation
```
composer require nitm/laravel-notifications
```

You may also want to add the custom repository to your `composer.json` file.

```
```

Once installed you can publish the assets using the `php artisan vendor:publish` command and selecting the tags you want to publish.

```
nitm-notifications-config for configuration files
nitm-notifications-migrations for migrations
```

# Basics
This package supports notifications, announcements and firebase FCM communication channels for mobile push notifications.
## Notifications
Create notifications, announcement and preferences according to your application needs. You may use Nova to create and manage these resources as needed.
## Communication Tokens
Use communication tokens to register unique devices in order to send notifications to users.

# Classes
Use the following classes to help reduce boilerplate behavior:
- Extend notifications from the `Nitm\Notifications\Notifications\BaseNotification` class
- Extend events from the `Nitm\Notifications\Events\BaseUserEvent` class
- Extend listeners from the `Nitm\Notifications\Listeners\BaseUserListener` class

## Events
You may listen to the various events to handle notifications.

For example in your `EventServiceProvider` class. Disable an enable as needed:
```
        \App\Events\NotifyAdmins::class => [
             \App\Listeners\NotifyAdminsOfActivity::class
        ],

        \App\Events\NotifyUsers::class => [
            \App\Listeners\NotifyUsersOfActivity::class
        ],

        \App\Events\NotifyCustom::class => [
             \App\Listeners\NotifyCustomOfActivity::class
        ],

        \App\Events\NotifyUser::class => [
            \App\Listeners\NotifyUserOfActivity::class
        ],

        /**
         * Feed notifications
         */

        \App\Events\FeedNotificationWasReceived::class => [
            \App\Listeners\FeedNotificationWasReceived::class
        ],
```

# Routes
```
+--------+-----------+-------------------------------------------------------------+------------------------------------------------+----------------------------------------------------------------------------------------+------------+
| Domain | Method    | URI                                                         | Name                                           | Action                                                                                 | Middleware |
+--------+-----------+-------------------------------------------------------------+------------------------------------------------+----------------------------------------------------------------------------------------+------------+
|        | GET|HEAD  | api/notifications                                           | notifications.index                            | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@index                | api        |
|        | POST      | api/notifications                                           | notifications.store                            | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@store                | api        |
|        | GET|HEAD  | api/notifications/announcements                             | notifications.announcements.index              | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@index                | api        |
|        | POST      | api/notifications/announcements                             | notifications.announcements.store              | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@store                | api        |
|        | GET|HEAD  | api/notifications/announcements/form-config                 | notifications.announcements.config             | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@formConfig           | api        |
|        | POST      | api/notifications/announcements/{announcement}              | notifications.announcements.update-post        | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@update               | api        |
|        | GET|HEAD  | api/notifications/announcements/{announcement}              | notifications.announcements.show               | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@show                 | api        |
|        | PUT|PATCH | api/notifications/announcements/{announcement}              | notifications.announcements.update             | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@update               | api        |
|        | DELETE    | api/notifications/announcements/{announcement}              | notifications.announcements.destroy            | Nitm\Notifications\Http\Controllers\API\AnnouncementAPIController@destroy              | api        |
|        | GET|HEAD  | api/notifications/communication-tokens                      | notifications.communication-tokens.index       | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@index          | api        |
|        | POST      | api/notifications/communication-tokens                      | notifications.communication-tokens.store       | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@store          | api        |
|        | GET|HEAD  | api/notifications/communication-tokens/form-config          | notifications.communication-tokens.config      | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@formConfig     | api        |
|        | POST      | api/notifications/communication-tokens/{communicationToken} | notifications.communication-tokens.update-post | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@update         | api        |
|        | GET|HEAD  | api/notifications/communication-tokens/{communicationToken} | notifications.communication-tokens.show        | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@show           | api        |
|        | PUT|PATCH | api/notifications/communication-tokens/{communicationToken} | notifications.communication-tokens.update      | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@update         | api        |
|        | DELETE    | api/notifications/communication-tokens/{communicationToken} | notifications.communication-tokens.destroy     | Nitm\Notifications\Http\Controllers\API\CommunicationTokenAPIController@destroy        | api        |
|        | GET|HEAD  | api/notifications/form-config                               | notifications.config                           | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@formConfig           | api        |
|        | GET|HEAD  | api/notifications/preferences                               | notifications.preferences.index                | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@index      | api        |
|        | POST      | api/notifications/preferences                               | notifications.preferences.store                | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@store      | api        |
|        | GET|HEAD  | api/notifications/preferences/form-config                   | notifications.preferences.config               | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@formConfig | api        |
|        | POST      | api/notifications/preferences/{preference}                  | notifications.preferences.update-post          | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@update     | api        |
|        | GET|HEAD  | api/notifications/preferences/{preference}                  | notifications.preferences.show                 | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@show       | api        |
|        | PUT|PATCH | api/notifications/preferences/{preference}                  | notifications.preferences.update               | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@update     | api        |
|        | DELETE    | api/notifications/preferences/{preference}                  | notifications.preferences.destroy              | Nitm\Notifications\Http\Controllers\API\NotificationPreferenceAPIController@destroy    | api        |
|        | POST      | api/notifications/{notification}                            | notifications.update-post                      | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@update               | api        |
|        | GET|HEAD  | api/notifications/{notification}                            | notifications.show                             | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@show                 | api        |
|        | PUT|PATCH | api/notifications/{notification}                            | notifications.update                           | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@update               | api        |
|        | DELETE    | api/notifications/{notification}                            | notifications.destroy                          | Nitm\Notifications\Http\Controllers\API\NotificationAPIController@destroy              | api        |
+--------+-----------+-------------------------------------------------------------+------------------------------------------------+----------------------------------------------------------------------------------------+------------+
```
## Customization
You may customize the route names, middleware and prefixes in the `nitm-notification.php` configuration.