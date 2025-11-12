<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\ChatMessages;
use App\Models\User;
use Database\Factories\Chat\ChatMessagesFactory;
use Tests\TestCase;

class ChatMessageTest extends TestCase
{
    public function testGetMessages(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        ChatMessages::factory()->create([
            'chat_id' => $chat,
            'user_id' => $user,
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/chats/'.$chat->id.'/messages');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'id',
                    'chat_id',
                    'user_id',
                    'message',
                    'created_at',
                    'updated_at',
                    'user' => [
                        'id',
                        'name',
                        'photo_url'
                    ],
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'per_page',
        ]);
    }

    public function testCreateMessage(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        $payload = [
            'message' => fake()->text(20000)
        ];

        $response = $this->actingAs($user, 'api')->postJson(
            '/api/chats/'.$chat->id.'/messages',
            $payload
        );

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'chat_id',
                'user_id',
                'message',
                'updated_at',
                'created_at',
                'id',
            ],
        ]);
    }

    public function testCreateMessageProvideLongMessage(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        $payload = [
            'message' => fake()->text(200001)
        ];

        $response = $this->actingAs($user, 'api')->postJson(
            '/api/chats/'.$chat->id.'/messages',
            $payload
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'message' => ['The message field must not be greater than 20000 characters.'],
        ]);
    }

    public function testCreateMessageNotProvideMessage(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        $response = $this->actingAs($user, 'api')->postJson(
            '/api/chats/'.$chat->id.'/messages',
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'message' => ['The message field is required.'],
        ]);
    }

    public function testDeleteMessage(): void
    {
        $user = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        $message = ChatMessages::factory()->create([
            'chat_id' => $chat,
            'user_id' => $user,
        ]);

        $response = $this->actingAs($user, 'api')->delete('/api/chats/'.$chat->id.'/messages/'.$message->id);

        $response->assertStatus(204);
    }
}
