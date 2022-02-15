<?php

namespace Tests\Repositories;

use Nitm\Notifications\Models\NotificationPreference;
use Nitm\Notifications\Repositories\NotificationPreferenceRepository;
use Tests\TestCase;

class NotificationPreferenceRepositoryTest extends TestCase
{

    /**
     * @var NotificationPreferenceRepository
     */
    protected $notificationPreferenceRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->notificationPreferenceRepo = \App::make(NotificationPreferenceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_notification_preference()
    {
        $notificationPreference = NotificationPreference::factory()->make()->toArray();

        $createdNotificationPreference = $this->notificationPreferenceRepo->create($notificationPreference);

        $createdNotificationPreference = $createdNotificationPreference->toArray();
        $this->assertArrayHasKey('id', $createdNotificationPreference);
        $this->assertNotNull($createdNotificationPreference['id'], 'Created NotificationPreference must have id specified');
        $this->assertNotNull(NotificationPreference::find($createdNotificationPreference['id']), 'NotificationPreference with given id must be in DB');
        $this->assertModelData($notificationPreference, $createdNotificationPreference);
    }

    /**
     * @test read
     */
    public function test_read_notification_preference()
    {
        $notificationPreference = NotificationPreference::factory()->create();

        $dbNotificationPreference = $this->notificationPreferenceRepo->find($notificationPreference->id);

        $dbNotificationPreference = $dbNotificationPreference->toArray();
        $this->assertModelData($notificationPreference->toArray(), $dbNotificationPreference);
    }

    /**
     * @test update
     */
    public function test_update_notification_preference()
    {
        $notificationPreference     = NotificationPreference::factory()->create();
        $fakeNotificationPreference = NotificationPreference::factory()->make()->toArray();

        $updatedNotificationPreference = $this->notificationPreferenceRepo->update($fakeNotificationPreference, $notificationPreference->id);

        $this->assertModelData($fakeNotificationPreference, $updatedNotificationPreference->toArray());
        $dbNotificationPreference = $this->notificationPreferenceRepo->find($notificationPreference->id);
        $this->assertModelData($fakeNotificationPreference, $dbNotificationPreference->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_notification_preference()
    {
        $notificationPreference = NotificationPreference::factory()->create();

        $resp = $this->notificationPreferenceRepo->delete($notificationPreference->id);

        $this->assertTrue($resp);
        $this->assertNull(NotificationPreference::find($notificationPreference->id), 'NotificationPreference should not exist in DB');
    }
}
