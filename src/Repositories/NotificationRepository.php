<?php

namespace Nitm\Notifications\Repositories;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Nitm\Notifications\Models\Notification;
use Nitm\Content\Repositories\BaseRepository;
use Nitm\Notifications\Events\NotificationCreated;
use Nitm\Notifications\Contracts\Repositories\NotificationRepository as Contract;

class NotificationRepository extends BaseRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Notification::class;
    }

    /**
     * {@inheritdoc}
     */
    public function recent($user)
    {
        // Retrieve all unread notifications for the user...
        $notifications = Notification::with('creator')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $notifications->values();
    }

    /**
     * {@inheritdoc}
     */
    public function recentQuery($user)
    {
        // Retrieve all unread notifications for the user...
        $notifications = Notification::with('creator')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        return $notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        $user    = auth()->user();
        $creator = Arr::get($data, 'from');

        $notification = Notification::create(
            [
                'id'          => Uuid::uuid4(),
                'user_id'     => Arr::get($data, 'user_id') ?: ($user ? $user->id : 1),
                'created_by'  => $creator ? $creator->id : null,
                'icon'        => Arr::get($data, 'icon'),
                'body'        => Arr::get($data, 'body'),
                'action_text' => Arr::get($data, 'action_text'),
                'action_url'  => Arr::get($data, 'action_url'),
            ]
        );

        event(new NotificationCreated($notification));

        return $notification;
    }

    /**
     * {@inheritdoc}
     */
    public function personal($user, $from, array $data)
    {
        return $this->create($user, array_merge($data, ['from' => $from]));
    }
}