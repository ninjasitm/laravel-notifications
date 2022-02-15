<?php

namespace Nitm\Notifications\Traits\User;

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

    public function notifications()
    {
        return $this->hasMany(config('nitm-notifications.notification_model', \Nitm\Notifications\Models\Notification::class));
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('read', 0);
    }

    public function announcements()
    {
        return $this->hasMany(config('nitm-notifications.announcement_model', \Nitm\Notifications\Models\Announcement::class));
    }

    public function unreadAnnouncements()
    {
        return $this->hasMany(config('nitm-notifications.announcement_model', \Nitm\Notifications\Models\Announcement::class))
            ->join('users', 'users.id', '=', 'announcements.user_id')
            ->whereRaw('announcements.created_at > users.last_read_announcements_at OR announcements.updated_at > users.last_read_announcements_at');
    }
}