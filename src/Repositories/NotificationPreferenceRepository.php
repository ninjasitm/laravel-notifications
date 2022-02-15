<?php

/**
 * NotificationPreference Repository
 */

namespace Nitm\Notifications\Repositories;

use Nitm\Notifications\Models\NotificationPreference;
use Nitm\Content\Repositories\BaseRepository;

/**
 * Class NotificationPreferenceRepository
 * @package App\Repositories
 * @version August 17, 2021, 5:38 pm UTC
 */

class NotificationPreferenceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return NotificationPreference::class;
    }
}