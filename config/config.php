<?php

return [
    /**
     * User model
     */
    'user_model'                    => env('NITM_NOTIFICATIONS_USER_MODEL', 'Nitm\Notifications\Models\User'),

    /**
     * Announcement model
     */
    'announcement_model'            => env('NITM_NOTIFICATIONS_ANNOUNCEMENT_MODEL', 'Nitm\Notifications\Models\Announcement'),

    /**
     * Notifiation model
     */
    'notification_model'            => env('NITM_NOTIFICATIONS_MODEL', 'Nitm\Notifications\Models\Notification'),

    /**
     * Notifiation Type model
     */
    'notification_type_model'       => env('NITM_NOTIFICATIONS_TYPE_MODEL', 'Nitm\Notifications\Models\NotificationType'),

    /**
     * Notifiation Preference model
     */
    'notification_preference_model' => env('NITM_NOTIFICATIONS_PREFERENCE_MODEL', 'Nitm\Notifications\Models\NotificationPreference'),

    /**
     * Communication Token model
     */
    'communication_token_model'     => env('NITM_NOTIFICATIONS_COMMUNICATION_TOKEN_MODEL', 'Nitm\Notifications\Models\CommunicationToken'),

    /**
     * Routes configuration
     */
    'routes'                        => [
        'prefix'     => env('NITM_NOTIFICATIONS_ROUTES_PREFIX', 'api/notifications'),
        'name'       => env('NITM_NOTIFICATIONS_ROUTES_PREFIX', 'notifications'),
        'middleware' => env('NITM_NOTIFICATIONS_ROUTES_MIDDLEWARE', ['api']),
    ],

    /**
     * Nova configuration support
     */
    'nova'                          => [
        'connected-account' => Nitm\Notifications\Nova\Notification::class,
    ],
];