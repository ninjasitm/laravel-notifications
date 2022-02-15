<?php

namespace Tests\Repositories;

use Nitm\Notifications\Models\CommunicationToken;
use Nitm\Notifications\Repositories\CommunicationTokenRepository;
use Tests\TestCase;

class CommunicationTokenRepositoryTest extends TestCase
{

    /**
     * @var CommunicationTokenRepository
     */
    protected $communicationTokenRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->communicationTokenRepo = \App::make(CommunicationTokenRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->make()->toArray();

        $createdCommunicationToken = $this->communicationTokenRepo->create($communicationToken);

        $createdCommunicationToken = $createdCommunicationToken->toArray();
        $this->assertArrayHasKey('id', $createdCommunicationToken);
        $this->assertNotNull($createdCommunicationToken['id'], 'Created CommunicationToken must have id specified');
        $this->assertNotNull(CommunicationToken::find($createdCommunicationToken['id']), 'CommunicationToken with given id must be in DB');
        $this->assertModelData($communicationToken, $createdCommunicationToken);
    }

    /**
     * @test read
     */
    public function test_read_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->create();

        $dbCommunicationToken = $this->communicationTokenRepo->find($communicationToken->id);

        $dbCommunicationToken = $dbCommunicationToken->toArray();
        $this->assertModelData($communicationToken->toArray(), $dbCommunicationToken);
    }

    /**
     * @test update
     */
    public function test_update_communication_token()
    {
        $communicationToken     = CommunicationToken::factory()->create();
        $fakeCommunicationToken = CommunicationToken::factory()->make()->toArray();

        $updatedCommunicationToken = $this->communicationTokenRepo->update($fakeCommunicationToken, $communicationToken->id);

        $this->assertModelData($fakeCommunicationToken, $updatedCommunicationToken->toArray());
        $dbCommunicationToken = $this->communicationTokenRepo->find($communicationToken->id);
        $this->assertModelData($fakeCommunicationToken, $dbCommunicationToken->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_communication_token()
    {
        $communicationToken = CommunicationToken::factory()->create();

        $resp = $this->communicationTokenRepo->delete($communicationToken->id);

        $this->assertTrue($resp);
        $this->assertNull(CommunicationToken::find($communicationToken->id), 'CommunicationToken should not exist in DB');
    }
}
