<?php

namespace Nitm\Notifications\Models;

use Parsedown;
use Illuminate\Support\Arr;
use Nitm\Content\Traits\SetUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory, SetUuid;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';

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

    /**
     * Get the user that created the announcement.
     */
    public function creator()
    {
        return $this->belongsTo(NitmContent::userModel(), 'user_id');
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