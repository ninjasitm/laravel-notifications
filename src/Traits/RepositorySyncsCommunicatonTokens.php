<?php

namespace Nitm\Notifications\Traits;

use Illuminate\Support\Arr;
use Nitm\Helpers\CollectionHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use Nitm\Notifications\Contracts\Models\CommunicationToken;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;

trait RepositorySyncsCommunicatonTokens
{
    /**
     * Sync the user's communication tokens
     *
     * @param Authenticatable $model
     * @param mixed           $data
     * @param string          $type
     * @param string|null     $deviceId
     *
     * @return void
     */
    public function syncCommunicationTokens(SupportsNotifications $model, $data, string $type = 'fcm', string $deviceId = null): void
    {
        if (is_array($data)) {
            if (Arr::isAssoc(($data))) {
                $data = [$data];
            }
        } else {
            $data = [$data];
        }

        foreach ($data as $token) {
            if (is_array($token)) {
                $type = Arr::get($token, 'type', $type);
                $value = Arr::get($token, 'token');
                $deviceId = $deviceId ?? Arr::get($token, 'device_id') ?? $model->email;
            } else {
                $value = $token;
            }

            $deviceId = $deviceId ?? $model->email;
            if (!empty($deviceId)) {
                $type = !empty($type) ? strtolower($type) : null;
                $type = $type && in_array($type, ['apple', 'android', 'fcm']) ? $type : 'fcm';
                $communicationToken = $model->communicationTokens()->firstOrCreate(
                    [
                        'type' => $type,
                        'device_id' => is_array($deviceId) ? json_encode($deviceId) : $deviceId
                    ]
                );

                $communicationToken->device_id = $deviceId ?? $communicationToken->device_id;
                $communicationToken->token = $value;
                $communicationToken->save();
            }
        }
    }

    /**
     * @param Authenticatable $model
     * @param mixed           $token
     *
     * @return void
     */
    public function deleteCommunicationTokens(SupportsNotifications $model, $token): void
    {
        if ($token instanceof CommunicationToken) {
            $token->delete();
        } else {
            $tokens = CollectionHelper::isCollection($token) ? $token : collect(is_array($token) ? $token : [$token]);
            if ($tokens->count()) {
                $model->communicationTokens()->whereIn(
                    'token',
                    $tokens->map(
                        function ($t) {
                            return is_array($t) ? Arr::get($t, 'token') : $t;
                        }
                    )->filter()
                )->delete();
            }
        }
    }
}