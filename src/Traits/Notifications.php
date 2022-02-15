<?php

namespace Nitm\Notifications\Traits;

use Illuminate\Support\Arr;
use Nitm\Content\Models\Notification;

trait Notifications
{
    protected function newBroadcastNotification(array $data)
    {
        $userClass = Nitm\Content\NitmContent::userModel();
        $user = auth()->user() ?: $userClass::where('email', config('app.email-from'))->first();
        $base = [];
        if ($user) {
            $base = [
                'user_id'    => Arr::get($data, 'user_id', $user->id),
                'created_by' => $user->id,
            ];
        }
        return new Notification(array_merge($base, $data));
    }
}
