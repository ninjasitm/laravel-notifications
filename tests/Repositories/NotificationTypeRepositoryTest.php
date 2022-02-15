<?php

namespace Tests\Repositories;

use Nitm\Notifications\Models\NotificationType;
use Nitm\Notifications\Repositories\NotificationTypeRepository;
use Tests\TestCase;

class NotificationTypeRepositoryTest extends TestCase
{

    /**
     * @var NotificationTypeRepository
     */
    protected $notificationTypeRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->notificationTypeRepo = \App::make(NotificationTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_notification_type()
    {
        $notificationType = NotificationType::factory()->make()->toArray();

        $createdNotificationType = $this->notificationTypeRepo->create($notificationType);

        $createdNotificationType = $createdNotificationType->toArray();
        $this->assertArrayHasKey('id', $createdNotificationType);
        $this->assertNotNull($createdNotificationType['id'], 'Created NotificationType must have id specified');
        $this->assertNotNull(NotificationType::find($createdNotificationType['id']), 'NotificationType with given id must be in DB');
        $this->assertModelData($notificationType, $createdNotificationType);
    }

    /**
     * @test read
     */
    public function test_read_notification_type()
    {
        $notificationType = NotificationType::factory()->create();

        $dbNotificationType = $this->notificationTypeRepo->find($notificationType->id);

        $dbNotificationType = $dbNotificationType->toArray();
        $this->assertModelData($notificationType->toArray(), $dbNotificationType);
    }

    /**
     * @test update
     */
    public function test_update_notification_type()
    {
        $notificationType = NotificationType::factory()->create();
        $fakeNotificationType = NotificationType::factory()->make()->toArray();

        $updatedNotificationType = $this->notificationTypeRepo->update($fakeNotificationType, $notificationType->id);

        $this->assertModelData($fakeNotificationType, $updatedNotificationType->toArray());
        $dbNotificationType = $this->notificationTypeRepo->find($notificationType->id);
        $this->assertModelData($fakeNotificationType, $dbNotificationType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_notification_type()
    {
        $notificationType = NotificationType::factory()->create();

        $resp = $this->notificationTypeRepo->delete($notificationType->id);

        $this->assertTrue($resp);
        $this->assertNull(NotificationType::find($notificationType->id), 'NotificationType should not exist in DB');
    }
}