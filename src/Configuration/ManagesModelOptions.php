<?php

namespace Nitm\Notifications\Configuration;

use Nitm\Content\NitmContent;

trait ManagesModelOptions
{
    /**
     * The user model class name.
     *
     * @var string
     */
    public static $userModel = 'Nitm\Notifications\Models\User';
    /**
     * Set the user model class name.
     *
     * @param  string $userModel
     * @return void
     */
    public static function useUserModel($userModel)
    {
        static::$userModel = $userModel;
        config(['nitm-notifications.user_model' => $userModel]);
    }

    /**
     * Get the user model class name.
     *
     * @return string
     */
    public static function userModel()
    {
        return config('nitm-notifications.user_model') ?? static::$userModel ?? NitmContent::userModel();
    }

    /**
     * Get a new user model instance.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public static function user()
    {
        $userModel = static::userModel();
        return new $userModel;
    }
}