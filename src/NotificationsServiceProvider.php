<?php

namespace Nitm\Notifications;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Nitm\Notifications\NitmNotifications;
use Nitm\Notifications\Models\Notification;
use Nitm\Notifications\Models\NotificationPreference;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;
use Nitm\Notifications\Models\Announcement;
use Nitm\Notifications\Models\CommunicationToken;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'nitm-notifications-migrations');
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('nitm-notifications.php'),
            ], 'nitm-notifications-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'nitm-notifications');
        $this->registerBindings();
        $this->defineRouteBindings();
    }

    /**
     * Register bindings
     *
     * @return void
     */
    protected function registerBindings()
    {
        $bindings = [
            SupportsNotifications::class => NitmNotifications::userModel(),
        ];

        foreach ($bindings as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Define the NitmContent route model bindings.
     *
     * @return void
     */
    protected function defineRouteBindings()
    {
        Route::model('notification', config('nitm-notifications.notification_model', Notification::class));
        Route::model('preference', config('nitm-notifications.notification_preference_model', NotificationPreference::class));
        Route::model('announcement', config('nitm-notifications.announcement_model', Announcement::class));
        Route::model('communicationToken', config('nitm-notifications.communication_token_model', CommunicationToken::class));
    }

    /**
     * Set the nova user model
     *
     * @param  mixed $class
     * @return void
     */
    public static function useNovaUser($class)
    {
        config(['nitm-notifications.nova.user' => $class]);
    }
}