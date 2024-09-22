<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\User;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and get the authentication token
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $response->json('token');
    }

    public function test_index_returns_all_clients()
    {
        Client::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/clients');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at']
            ]);
    }

    public function test_store_creates_new_client()
    {
        $clientData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/clients', $clientData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Successfully added']);

        $this->assertDatabaseHas('clients', $clientData);
    }

    public function test_show_returns_specific_client()
    {
        $client = Client::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJson($client->toArray());
    }

    public function test_update_modifies_existing_client()
    {
        $client = Client::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '1234567890',
            'address' => 'Updated Address',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/clients/{$client->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully Updated']);

        $this->assertDatabaseHas('clients', $updatedData);
    }

    public function test_destroy_deletes_client()
    {
        $client = Client::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully Deleted']);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_unauthenticated_access_is_denied()
    {
        $response = $this->getJson('/api/clients');

        $response->assertStatus(401);
    }
}
