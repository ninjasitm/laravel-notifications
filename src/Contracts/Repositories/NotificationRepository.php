<?php

namespace Nitm\Notifications\Contracts\Repositories;

interface NotificationRepository
{
    /**
     * Get the most recent notifications for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recent($user);

    /**
     * Create a personal notification from another user.
     *
     * @param  mixed $user
     * @param  mixed $from
     * @param  array $data
     * @return \Nitm\Notifications\Notification
     */
    public function personal($user, $from, array $data);
}