<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Models\NotificationType;

class NotificationTypeTest extends TestCase
{
    // use RefreshDatabase;

    public function testCreate()
    {
        $data = NotificationType::factory()->make();
        $model = NotificationType::factory()->create($data->getAttributes());

        $this->assertInstanceOf(NotificationType::class, $model);
        $this->assertGreaterThan(0, $model->id);
    }

    public function testUpdate()
    {
        $model = NotificationType::factory()->create();
        $data = $model->getAttributes();

        $updateData = NotificationType::factory()->make();
        $model->fill($updateData->toArray());
        $keys = array_keys($updateData->toArray());

        $this->assertInstanceOf(NotificationType::class, $model);
        $this->assertNotEquals(
            Arr::only($data, $keys),
            Arr::only($model->getAttributes(), $keys)
        );
    }

    public function testDelete()
    {
        $model = NotificationType::factory()->create();

        $model->delete();
        $this->assertNotNull($model->deleted_at);

        $model->forceDelete();
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);

        $model->delete();

        $this->assertInstanceOf(NotificationType::class, $model);
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
    }
}
