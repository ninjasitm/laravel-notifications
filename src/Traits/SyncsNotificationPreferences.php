<?php

namespace Nitm\Notifications\Traits;

use Nitm\Content\Models\Team;
use Nitm\Notifications\Models\User;
use Illuminate\Support\Arr;
use Nitm\Notifications\Models\NotificationType;
use Illuminate\Support\Collection;

trait SyncsNotificationPreferences
{
    /**
     * Sync Notification Preferences
     *
     * @param  mixed $data
     * @return void
     */
    public function syncNotificationPreferences($data)
    {
        if (!empty($data) && (is_array($data) || $data instanceof Collection)) {
            $this->initNotificationPreferences();
            $data = Arr::get($data, 'notification_preferences') ?: $data;
            $sanitizedData = collect([]);
            $teamId = null;
            $userId = null;

            if (!$this instanceof User) {
                $userId = $this->id;
            }
            if (!$this instanceof Team) {
                $teamId = $this->id;
            }
            foreach ($data as $k => $v) {
                $v = array_merge($v, [
                    'user_id' => $userId,
                    'team_id' => $teamId
                ]);
                $sanitizedData[$k] = $v;
            }
            $this->syncRelation($sanitizedData, 'notificationPreferences');
        }
    }

    /**
     * Init Notification Preferences
     *
     * @return Collection
     */
    public function initNotificationPreferences()
    {
        $this->load('notificationPreferences');
        $existing = $this->notificationPreferences;
        $class = config('nitm-notifications.notification_type_model');
        $types = $class::get();
        if ($types->count() > 0 && $types->count() > $existing->count()) {
            $toAdd = $types->whereNotIn('id', $existing->pluck('type_id'));
            $teamId = null;
            $userId = null;

            if ($this instanceof User) {
                $userId = $this->id;
            }
            if ($this instanceof Team) {
                $teamId = $this->id;
            }

            $this->setRelation(
                'notificationPreferences',
                $this->notificationPreferences()
                    ->createMany($toAdd->map(function ($type) use ($userId, $teamId) {
                        return [
                            'entity_type' => $userId ? User::class : Team::class,
                            'entity_id' => $userId ?? $teamId,
                            'type_id' => $type->id,
                            'user_id' => $userId,
                            'team_id' => $teamId
                        ];
                    }))
            );
        }

        return $this->notificationPreferences;
    }
}