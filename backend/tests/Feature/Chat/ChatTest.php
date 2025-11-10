<?php

namespace Tests\Feature\Chat;

use App\Models\User;
use App\Models\Chat\Chat;
use Illuminate\Support\Str;
use Tests\TestCase;

class ChatTest extends TestCase
{
    public function testGetChats(): void
    {
        $user = User::factory()->create();

        Chat::factory()->count(2)->create([
            'created_by' => $user,
        ]);

        $response = $this->actingAs($user, 'api')->get('/api/chats');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                ['id', 'name', 'is_group', 'created_by' => ['id', 'name']],
            ],
        ]);
    }

    public function testGetChatsWhenEmpty(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('/api/chats');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [],
        ]);
    }

    public function testCreateGroupChat(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name_group' => 'Nowy czat',
            'is_group' => 1,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Chat is created.',
        ]);
    }

    public function testCreateChat(): void
    {
        $user = User::factory()->create();

        $chatUser = User::factory()->create();

        $payload = [
            'user_id' => $chatUser->id,
            'is_group' => 0,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Chat is created.',
        ]);
    }

    public function testCreateChatWithoutUserId(): void
    {
        $user = User::factory()->create();

        $payload = [
            'is_group' => 0,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'user_id' => ['The user id field is required when is group is 0.'],
        ]);
    }

    public function testCreateChatProvideInvalidUserId(): void
    {
        $user = User::factory()->create();

        $payload = [
            'user_id' => rand(),
            'is_group' => 0,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'user_id' => ['The selected user id is invalid.'],
        ]);
    }

    public function testCreateChatWithoutName(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name_group' => '',
            'is_group' => 1,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name_group' => ['The name group field is required when is group is 1.'],
        ]);
    }

    public function testCreateChatWithTooLongName(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name_group' => Str::random(256),
            'is_group' => 1,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/chats', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name_group' => ['The name group field must not be greater than 255 characters.'],
        ]);
    }

    public function testDeleteChat(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        $response = $this->actingAs($user, 'api')->deleteJson("/api/chats/{$chat->id}");

        $response->assertStatus(204);
    }

    public function testDeleteNonExistingChat(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson('/api/chats/999999');

        $response->assertStatus(400);
    }

    public function testCreateChatUnauthenticated(): void
    {
        $payload = [
            'name' => 'Czat testowy',
        ];

        $response = $this->postJson('/api/chats', $payload);

        $response->assertStatus(401);
    }

    public function testGetChatsUnauthenticated(): void
    {
        $response = $this->getJson('/api/chats');

        $response->assertStatus(401);
    }

    public function testDeleteChatUnauthenticated(): void
    {
        $chat = Chat::factory()->create();

        $response = $this->deleteJson("/api/chats/{$chat->id}");

        $response->assertStatus(401);
    }
}
