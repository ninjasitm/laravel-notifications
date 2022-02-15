<?php

namespace Nitm\Notifications\Models;

use Nitm\Content\Models\User as ModelsUser;
use Nitm\Content\Traits\User\CommunicationTokens;
use Nitm\Notifications\Traits\User\HasNotifications;

class User extends ModelsUser
{
    use HasNotifications, CommunicationTokens;
}