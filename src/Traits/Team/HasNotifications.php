<?php

namespace Nitm\Notifications\Traits\Team;

use Nitm\Notifications\Models\NotificationPreference;

trait HasNotifications
{
    /**
     * Laravel uses this method to allow you to initialize traits
     *
     * @return void
     */
    // public function initializeHasNotifications()
    // {
    // }

    /**
     * Get notifiation prefrences
     *
     * @return void
     */
    public function notificationPreferences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(config('nitm-notifications.notification_preference_model', \Nitm\Notifications\Models\NotificationPreference::class), 'team_id', 'id');
    }
}