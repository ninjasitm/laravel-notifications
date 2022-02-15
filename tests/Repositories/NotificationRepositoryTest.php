<?php

namespace Tests\Repositories;

use Nitm\Notifications\Models\Notification;
use Nitm\Notifications\Repositories\NotificationRepository;
use Tests\TestCase;

class NotificationRepositoryTest extends TestCase
{
    /**
     * @var NotificationRepository
     */
    protected $notificationTypeRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->notificationTypeRepo = \App::make(NotificationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_notification_type()
    {
        $notificationType = Notification::factory()->make()->toArray();

        $createdNotification = $this->notificationTypeRepo->create($notificationType);

        $createdNotification = $createdNotification->toArray();
        $this->assertArrayHasKey('id', $createdNotification);
        $this->assertNotNull($createdNotification['id'], 'Created Notification must have id specified');
        $this->assertNotNull(Notification::find($createdNotification['id']), 'Notification with given id must be in DB');
        $this->assertModelData($notificationType, $createdNotification);
    }

    /**
     * @test read
     */
    public function test_read_notification_type()
    {
        $notificationType = Notification::factory()->create();

        $dbNotification = $this->notificationTypeRepo->find($notificationType->id);

        $dbNotification = $dbNotification->toArray();
        $this->assertModelData($notificationType->toArray(), $dbNotification);
    }

    /**
     * @test update
     */
    public function test_update_notification_type()
    {
        $notificationType = Notification::factory()->create();
        $fakeNotification = Notification::factory()->make()->toArray();

        $updatedNotification = $this->notificationTypeRepo->update($fakeNotification, $notificationType->id);

        $this->assertModelData($fakeNotification, $updatedNotification->toArray());
        $dbNotification = $this->notificationTypeRepo->find($notificationType->id);
        $this->assertModelData($fakeNotification, $dbNotification->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_notification_type()
    {
        $notificationType = Notification::factory()->create();

        $resp = $this->notificationTypeRepo->delete($notificationType->id);

        $this->assertTrue($resp);
        $this->assertNull(Notification::find($notificationType->id), 'Notification should not exist in DB');
    }
}
