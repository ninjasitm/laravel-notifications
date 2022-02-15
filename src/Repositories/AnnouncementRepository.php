<?php

namespace Nitm\Notifications\Repositories;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Nitm\Notifications\Models\Announcement;
use Nitm\Notifications\Events\AnnouncementCreated;
use Nitm\Content\Models\BaseModel;
use Nitm\Content\Repositories\BaseRepository;
use Nitm\Notifications\Contracts\Repositories\AnnouncementRepository as Contract;

class AnnouncementRepository extends BaseRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Announcement::class;
    }

    /**
     * {@inheritdoc}
     */
    public function recent()
    {
        return Announcement::with('creator')->orderBy('created_at', 'desc')->take(8)->get();
    }
    /**
     * {@inheritdoc}
     */
    public function recentQuery()
    {
        return Announcement::with('creator')->orderBy('created_at', 'desc');
    }

    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        $user = auth()->user();
        $announcement = Announcement::create(
            [
                'id' => Uuid::uuid4(),
                'user_id' => Arr::get($data, 'user_id') ?: ($user ? $user->id : 1),
                'body' => Arr::get($data, 'body'),
                'action_text' => Arr::get($data, 'action_text'),
                'action_url' => Arr::get($data, 'action_url'),
            ]
        );

        event(new AnnouncementCreated($announcement));

        return $announcement;
    }

    /**
     * {@inheritdoc}
     */
    public function update($data, $announcement)
    {
        $announcement = $announcement instanceof Announcement ?  $announcement : Announcement::find($announcement);
        $announcement->fill([
            'body' => $data['body'],
            'action_text' => Arr::get($data, 'action_text'),
            'action_url' => Arr::get($data, 'action_url'),
        ])->save();

        return $announcement;
    }
}