<?php

namespace Tests\APIs;

use Nitm\Notifications\Models\Notification;
use Tests\TestCase;

class NotificationsApiTest extends TestCase
{

    /**
     * @test
     */
    public function test_create_notification()
    {
        $notification = Notification::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/notifications',
            $notification
        );

        $this->assertApiResponse($notification);
    }

    /**
     * @test
     */
    public function test_read_notification()
    {
        $notification = Notification::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/notifications/' . $notification->id
        );

        $this->assertApiResponse($notification->toArray());
    }

    /**
     * @test
     */
    // public function test_update_notification()
    // {
    //     $notification       = Notification::factory()->create();
    //     $editedNotification = Notification::factory()->make()->toArray();

    //     $this->response = $this->json(
    //         'PUT',
    //         '/api/notifications/' . $notification->id,
    //         $editedNotification
    //     );

    //     $this->assertApiResponse($editedNotification);
    // }

    /**
     * @test
     */
    // public function test_delete_notification()
    // {
    //     $notification = Notification::factory()->create();

    //     $this->response = $this->json(
    //         'DELETE',
    //         '/api/notifications/' . $notification->id
    //     );

    //     $this->assertApiSuccess();
    //     $this->response = $this->json(
    //         'GET',
    //         '/api/notifications/' . $notification->id
    //     );

    //     $this->response->assertStatus(404);
    // }
}