<?php

namespace Nitm\Notifications\Listeners;

use Nitm\Notifications\Models\User;
use Nitm\Helpers\CollectionHelper;
use Nitm\Notifications\Events\FeedNotificationWasReceived as RealEvent;
use Nitm\Notifications\Notifications\NotifyOfNewFeedNotificationByFirebase;

class FeedNotificationWasReceived
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RealEvent $event)
    {
        $users = $event->user ?? $event->users;
        if ($users) {
            $this->sendTo($users, $event->data);
        }
    }

    /**
     * @param mixed $users
     * @param mixed $data
     *
     * @return void
     */
    protected function sendTo($users, $data): void
    {
        $users = !CollectionHelper::isCollection($users) ? collect(is_array($users) ? $users : [$users]) : $users;
        $users->map(function ($user) use ($data) {
            $user = is_object($user) ? $user : User::find($user);
            if (CollectionHelper::isCollection(($user))) {
                $user = $user->first();
            }
            if ($user instanceof User) {
                $user->notify(new NotifyOfNewFeedNotificationByFirebase($data));
            }
        });
    }
}
