<?php

namespace Nitm\Notifications\Models;

use Illuminate\Support\Arr;
use Nitm\Content\Models\Model as Model;
use Nitm\Notifications\Contracts\Models\CommunicationToken as ModelsCommunicationToken;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;

/**
 * @SWG\Definition(
 *      definition="CommunicationToken",
 *      required={"user_id", "token", "type"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="token",
 *          description="token",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="device_id",
 *          description="device_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class CommunicationToken extends Model implements ModelsCommunicationToken
{
    public $table = 'communication_tokens';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'token',
        'device_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'token' => 'string',
        'device_id' => 'array',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'sometimes',
        'token' => 'required',
        'device_id' => 'sometimes',
        'type' => 'sometimes'
    ];

    /**
     * Get the device id
     *
     * @return mixed
     */
    public function getDeviceIdAttribute()
    {
        $id = Arr::get($this->attributes, 'device_id');
        return json_decode($id, true) ?? $id;
    }

    public function scopeForUser($query, SupportsNotifications $user = null)
    {
        $user = $user ?? auth()->user();
        $query->whereUserId($user ? $user->id : -1);
    }
}