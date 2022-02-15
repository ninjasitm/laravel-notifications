<?php

namespace Nitm\Notifications\Listeners;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Contracts\ListensToActivity;

abstract class BaseUserListener implements ListensToActivity
{
    /**
     * The user instance.
     *
     * @var \Laravel\Spark\User
     */
    public $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->user = $event->user;
        //
    }
}
