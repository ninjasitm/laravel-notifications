<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Models\Notification;

class NotificationTest extends TestCase
{
    // use RefreshDatabase;

    public function testCreate()
    {
        $data = Notification::factory()->make();
        $model = Notification::factory()->create($data->getAttributes());

        $this->assertInstanceOf(Notification::class, $model);
        $this->assertGreaterThan(0, $model->id->toString());
    }

    public function testUpdate()
    {
        $model = Notification::factory()->create();
        $data = $model->getAttributes();

        $updateData = Notification::factory()->make();
        $model->fill($updateData->toArray());
        $keys = array_keys($updateData->toArray());

        $this->assertInstanceOf(Notification::class, $model);
        $this->assertNotEquals(
            Arr::only($data, $keys),
            Arr::only($model->getAttributes(), $keys)
        );
    }

    public function testDelete()
    {
        $model = Notification::factory()->create();

        $model->delete();

        $this->assertInstanceOf(Notification::class, $model);
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id->toString()]);
    }
}