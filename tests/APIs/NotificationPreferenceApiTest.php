<?php

namespace Tests\APIs;

use Nitm\Notifications\Models\NotificationPreference;
use Tests\TestCase;

class NotificationPreferenceApiTest extends TestCase
{
    // /**
    //  * @test
    //  */
    // public function test_create_notification_preference()
    // {
    //     $notificationPreference = NotificationPreference::factory()->make()->toArray();

    //     $this->response = $this->json(
    //         'POST',
    //         '/api/notifications/preferences',
    //         $notificationPreference
    //     );

    //     $this->assertApiResponse($notificationPreference);
    // }

    // /**
    //  * @test
    //  */
    // public function test_read_notification_preference()
    // {
    //     $notificationPreference = NotificationPreference::factory()->create();

    //     $this->response = $this->json(
    //         'GET',
    //         '/api/notifications/preferences/' . $notificationPreference->id
    //     );

    //     $this->assertApiResponse($notificationPreference->toArray());
    // }

    // /**
    //  * @test
    //  */
    // public function test_update_notification_preference()
    // {
    //     $notificationPreference       = NotificationPreference::factory()->create();
    //     $editedNotificationPreference = NotificationPreference::factory()->make()->toArray();

    //     $this->response = $this->json(
    //         'PUT',
    //         '/api/notifications/preferences/' . $notificationPreference->id,
    //         $editedNotificationPreference
    //     );

    //     $this->assertApiResponse($editedNotificationPreference);
    // }

    // /**
    //  * @test
    //  */
    // public function test_delete_notification_preference()
    // {
    //     $notificationPreference = NotificationPreference::factory()->create();

    //     $this->response = $this->json(
    //         'DELETE',
    //         '/api/notifications/preferences/' . $notificationPreference->id
    //     );

    //     $this->assertApiSuccess();
    //     $this->response = $this->json(
    //         'GET',
    //         '/api/notifications/preferences/' . $notificationPreference->id
    //     );

    //     $this->response->assertStatus(404);
    // }
}