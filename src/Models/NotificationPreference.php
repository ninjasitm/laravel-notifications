<?php

namespace Nitm\Notifications\Models;

use Nitm\Content\Models\Model as Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="NotificationPreference",
 *      required={"type_id", "via_web", "via_email", "via_mobile", "via_sms", "is_enabled"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type_id",
 *          description="type_id",
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
 *          property="team_id",
 *          description="team_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="via_web",
 *          description="via_web",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="via_email",
 *          description="via_email",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="via_mobile",
 *          description="via_mobile",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="via_sms",
 *          description="via_sms",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_enabled",
 *          description="is_enabled",
 *          type="boolean"
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
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class NotificationPreference extends Model
{
    use SoftDeletes;

    const VIA_MOBILE = 'via_mobile';
    const VIA_EMAIL = 'via_email';
    const VIA_SMS = 'via_sms';
    const VIA_WEB = 'via_web';

    public $table = 'notification_preferences';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $with = ['type'];
    protected $dates = ['deleted_at'];


    public $fillable = [
        'entity_type',
        'entity_id',
        'type_id',
        'user_id',
        'team_id',
        'via_web',
        'via_email',
        'via_mobile',
        'via_sms',
        'is_enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'user_id' => 'integer',
        'team_id' => 'integer',
        'via_web' => 'boolean',
        'via_email' => 'boolean',
        'via_mobile' => 'boolean',
        'via_sms' => 'boolean',
        'is_enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type_id' => 'required|integer',
        'user_id' => 'nullable|integer',
        'team_id' => 'nullable|integer',
        'via_web' => 'boolean',
        'via_email' => 'boolean',
        'via_mobile' => 'boolean',
        'via_sms' => 'boolean',
        'is_enabled' => 'boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function type()
    {
        return $this->belongsTo(config('nitm-notifications.notification_type_model', \Nitm\Notifications\Models\NotificationType::class), 'type_id');
    }

    /**
     * Scope For Type
     *
     * @param  mixed $query
     * @param  mixed $class
     * @return void
     */
    public function scopeForType($query, NotificationType $type)
    {
        $query->whereHas('type', function ($query) use ($type) {
            $query->whereId($type->id);
        });
    }

    /**
     * Scope For Types
     *
     * @param  mixed $query
     * @param  mixed $class
     * @return void
     */
    public function scopeForTypes($query, Collection|iterable $types)
    {
        $query->whereHas('type', function ($query) use ($types) {
            $types = $types instanceof Collection ? $types : collect($types);
            $query->whereIn('id', $types->map(function ($type) {
                return $type instanceof Model ? $type->id : intval($type);
            }));
        });
    }

    /**
     * Scope For Entity
     *
     * @param  mixed $query
     * @param  mixed $model
     * @return void
     */
    public function scopeForEntity($query, Model $model)
    {
        $query->whereEntityType($model->getMorphClass())
            ->whereEntityId($model->id ?? -1);
    }

    /**
     * ForUser
     *
     * @param  mixed $query
     * @param  mixed $user
     * @param  mixed $team
     * @return void
     */
    public function scopeForUser($query, $user = null, $team = null)
    {
        if ($user->isMentorOn($team)) {
            $query->whereHas('type', function ($query) {
                $query->forMentors();
            });
        } elseif ($user->isStudentOn($team)) {
            $query->whereHas('type', function ($query) {
                $query->forStudents();
            });
        }
    }

    /**
     * SortByGroup
     *
     * @param  mixed $query
     * @param  mixed $field
     * @param  mixed $direction
     * @return void
     */
    public function scopeSortByGroup($query, $field = null, $direction = 'ask')
    {
        $query->join('notification_types', 'notification_types.id', '=', 'notification_preferences.type_id')
            ->orderBy('notification_types.group', 'asc');
    }
}