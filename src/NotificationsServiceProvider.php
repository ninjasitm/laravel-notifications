<?php

namespace Nitm\Notifications;

use Illuminate\Support\ServiceProvider;
use Nitm\Notifications\Models\Product;
use Nitm\Notifications\Observers\Product as ProductObserver;
use Nitm\Notifications\Stripe\StripeService;

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