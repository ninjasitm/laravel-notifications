<?php

namespace Nitm\Notifications\Models;

use Parsedown;
use Illuminate\Support\Arr;
use Nitm\Content\NitmContent;
use Nitm\Content\Traits\SetUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory, SetUuid;

    // use DatesTimezoneConversion;

    protected $dates = ['created_at', 'updated_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['parsed_body'];

    /**
     * UUID for Id
     *
     * @var array
     */
    protected $uuidFields = ['id'];

    protected $fillable = ['action_text', 'action_url', 'body', 'read', 'type', 'user_id', 'icon'];

    /**
     * Get the user the notification belongs to.
     */
    public function user()
    {
        return $this->belongsTo(NitmContent::userModel(), 'user_id');
    }

    /**
     * Get the user that created the notification (if any).
     */
    public function creator()
    {
        return $this->belongsTo(NitmContent::userModel(), 'created_by');
    }

    /**
     * Get the parsed body of the announcement.
     *
     * @return string
     */
    public function getParsedBodyAttribute()
    {
        return (new Parsedown)->text(htmlspecialchars($this->attributes['body']));
    }

    public function getActionUrlAttribute()
    {
        return str_replace(['https://dev.local:8080'], [config('app.webUrl')], Arr::get($this->attributes, 'action_url'));
    }

    /**
     * Det Id Attribute
     *
     * @return string
     */
    public function getIdAttribute()
    {
        return Arr::get($this->attributes, 'id') instanceof Uuid ? Arr::get($this->attributes, 'id')->toString() : Arr::get($this->attributes, 'id');
    }
}