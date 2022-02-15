<?php

/**
 * CommunicationToken Repository
 */

namespace Nitm\Notifications\Repositories;

use Nitm\Notifications\Models\CommunicationToken;
use Nitm\Content\Repositories\BaseRepository;

/**
 * Class CommunicationTokenRepository
 *
 * @package App\Repositories
 * @version August 3, 2020, 5:36 pm UTC
 */

class CommunicationTokenRepository extends BaseRepository
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
        return CommunicationToken::class;
    }
}