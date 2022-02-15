<?php

namespace Tests\APIs;

use Nitm\Notifications\Models\CommunicationToken;
use Tests\TestCase;

class CommunicationTokensApiTest extends TestCase
{

    /**
     * @test
     */
    public function test_create_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/notifications/communication-tokens',
            $communicationToken
        );

        $this->assertApiResponse($communicationToken);
    }

    /**
     * @test
     */
    public function test_read_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/notifications/communication-tokens/' . $communicationToken->id
        );

        $this->assertApiResponse($communicationToken->toArray());
    }

    /**
     * @test
     */
    public function test_update_communication_token()
    {
        $communicationToken       = CommunicationToken::factory()->create();
        $editedCommunicationToken = CommunicationToken::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/notifications/communication-tokens/' . $communicationToken->id,
            $editedCommunicationToken
        );

        $this->assertApiResponse($editedCommunicationToken);
    }

    /**
     * @test
     */
    public function test_delete_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/notifications/communication-tokens/' . $communicationToken->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/notifications/communication-tokens/' . $communicationToken->id
        );

        $this->response->assertStatus(404);
    }
}