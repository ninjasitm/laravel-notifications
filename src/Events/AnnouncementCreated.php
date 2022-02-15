<?php

namespace Nitm\Notifications\Events;

class AnnouncementCreated
{
    /**
     * The announcement instance.
     *
     * @var \Nitm\Notifications\Models\Announcement
     */
    public $announcement;

    /**
     * Create a new announcement instance.
     *
     * @param  \Nitm\Notifications\Models\Announcement $announcement
     * @return void
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }
}
