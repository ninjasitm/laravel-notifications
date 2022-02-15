<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Models\Announcement;

class AnnouncementTest extends TestCase
{
    // use RefreshDatabase;

    public function testCreate()
    {
        $data = Announcement::factory()->make();
        $model = Announcement::factory()->create($data->getAttributes());

        $this->assertInstanceOf(Announcement::class, $model);
        $this->assertGreaterThan(0, $model->id->toString());
    }

    public function testUpdate()
    {
        $model = Announcement::factory()->create();
        $data = $model->getAttributes();

        $updateData = Announcement::factory()->make();
        $model->fill($updateData->toArray());
        $keys = array_keys($updateData->toArray());

        $this->assertInstanceOf(Announcement::class, $model);
        $this->assertNotEquals(
            Arr::only($data, $keys),
            Arr::only($model->getAttributes(), $keys)
        );
    }

    public function testDelete()
    {
        $model = Announcement::factory()->create();

        $model->delete();

        $this->assertInstanceOf(Announcement::class, $model);
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
    }
}