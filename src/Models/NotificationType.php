<?php

namespace Nitm\Notifications\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="NotificationType",
 *      required={"notification_class", "is_active"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="notification_class",
 *          description="notification_class",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
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
class NotificationType extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'notification_types';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'notification_class',
        'title',
        'description',
        'is_active',
        'for_admin_only',
        'for_mentors'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'notification_class' => 'string',
        'title' => 'string',
        'description' => 'string',
        'is_active' => 'boolean',
        'for_admin_only' => 'boolean',
        'for_mentors' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'notification_class' => 'required|string',
        'title' => 'nullable|string',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
        'for_admin_only' => 'boolean',
        'for_mentors' => 'boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(config('nitm-notifications.notification_preference_model', \Nitm\Notifications\Models\NotificationPreference::class), 'type_id');
    }

    /**
     * For Admins Only
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeForAdminsOnly($query)
    {
        $query->whereForAdminOnly(true);
    }

    /**
     * For Non Admins
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeForNonAdmins($query)
    {
        $query->whereForAdminOnly(false);
    }

    /**
     * For Mentors Only
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeForMentors($query)
    {
        $query->whereForMentor(true)->forNonAdmins();
    }

    /**
     * For Non Mentors
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeForNonMentors($query)
    {
        $query->whereForMentor(false);
    }

    /**
     * For Students
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeForStudents($query)
    {
        $query->forNonAdmins()->forNonMentors();
    }
}