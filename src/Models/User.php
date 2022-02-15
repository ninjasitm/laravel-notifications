<?php

namespace Nitm\Notifications\Models;

use Nitm\Content\Models\User as ModelsUser;
use Nitm\Content\Traits\User\CommunicationTokens;
use Nitm\Notifications\Traits\User\HasNotifications;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;

class User extends ModelsUser implements SupportsNotifications
{
    use HasNotifications, CommunicationTokens;
}