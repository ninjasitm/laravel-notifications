<?php

namespace Nitm\Notifications\Contracts\Repositories;

use Nitm\Notifications\Announcement;

interface AnnouncementRepository
{
    /**
     * Get the most recent announcement notifications for the application.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recent();
}