<?php

namespace Nitm\Notifications\Traits\User;

use Nitm\Notifications\Models\CommunicationToken;

trait CommunicationTokens
{
    /**
     * Laravel uses this method to allow you to initialize traits
     *
     * @return void
     */
    // public function initializeUserCalendar()
    // {
    //     $this->withCount[] = 'newRsvps';
    // }

    /**
     * Get rsvps
     *
     * @return void
     */
    public function communicationTokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(config('nitm-notifications.communication_token_model', \Nitm\Notifications\Models\CommunicationToken::class), 'user_id', 'id');
    }
}