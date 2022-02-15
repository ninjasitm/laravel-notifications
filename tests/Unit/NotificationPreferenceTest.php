<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Models\NotificationPreference;

class NotificationPreferenceTest extends TestCase
{
    // use RefreshDatabase;

    public function testCreate()
    {
        $data = NotificationPreference::factory()->make();
        $model = NotificationPreference::factory()->create($data->getAttributes());

        $this->assertInstanceOf(NotificationPreference::class, $model);
        $this->assertGreaterThan(0, $model->id);
    }

    public function testUpdate()
    {
        $model = NotificationPreference::factory()->create();
        $data = $model->getAttributes();

        $updateData = NotificationPreference::factory()->make();
        $model->fill($updateData->toArray());
        $keys = array_keys($updateData->toArray());

        $this->assertInstanceOf(NotificationPreference::class, $model);
        $this->assertNotEquals(
            Arr::only($data, $keys),
            Arr::only($model->getAttributes(), $keys)
        );
    }

    public function testDelete()
    {
        $model = NotificationPreference::factory()->create();

        $model->delete();
        $this->assertNotNull($model->deleted_at);

        $model->forceDelete();
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);

        $model->delete();

        $this->assertInstanceOf(NotificationPreference::class, $model);
        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
    }
}
