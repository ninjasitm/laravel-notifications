<?php

namespace Tests\APIs;

use Nitm\Notifications\Models\Announcement;
use Tests\TestCase;

class AnnouncementsApiTest extends TestCase
{

    // /**
    //  * @test
    //  */
    // public function test_create_announcement()
    // {
    //     $announcement = Announcement::factory()->make()->toArray();

    //     $this->response = $this->json(
    //         'POST',
    //         '/api/notifications/announcements',
    //         $announcement
    //     );

    //     $this->assertApiResponse($announcement);
    // }

    // /**
    //  * @test
    //  */
    // public function test_read_announcement()
    // {
    //     $announcement = Announcement::factory()->create();

    //     $this->response = $this->json(
    //         'GET',
    //         '/api/notifications/announcements/' . $announcement->id
    //     );

    //     $this->assertApiResponse($announcement->toArray());
    // }

    // /**
    //  * @test
    //  */
    // public function test_update_announcement()
    // {
    //     $announcement       = Announcement::factory()->create();
    //     $editedAnnouncement = Announcement::factory()->make()->toArray();

    //     $this->response = $this->json(
    //         'PUT',
    //         '/api/notifications/announcements/' . $announcement->id,
    //         $editedAnnouncement
    //     );

    //     $this->assertApiResponse($editedAnnouncement);
    // }

    // /**
    //  * @test
    //  */
    // public function test_delete_announcement()
    // {
    //     $announcement = Announcement::factory()->create();

    //     $this->response = $this->json(
    //         'DELETE',
    //         '/api/notifications/announcements/' . $announcement->id
    //     );

    //     $this->assertApiSuccess();
    //     $this->response = $this->json(
    //         'GET',
    //         '/api/notifications/announcements/' . $announcement->id
    //     );

    //     $this->response->assertStatus(404);
    // }
}