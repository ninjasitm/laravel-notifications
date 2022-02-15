<?php

namespace Nitm\Notifications\Events;

class NotificationCreated
{
    /**
     * The notification instance.
     *
     * @var \Nitm\Notifications\Models\Notification
     */
    public $notification;

    /**
     * Create a new notification instance.
     *
     * @param  \Nitm\Notifications\Models\Notification $notification
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }
}
