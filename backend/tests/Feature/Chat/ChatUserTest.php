<?php

namespace Tests\Feature\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\ChatUsers;
use App\Models\User;
use Tests\TestCase;

class ChatUserTest extends TestCase
{
    public function testGetUsers(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $chat = Chat::factory()->create([
            'created_by' => $user,
        ]);

        ChatUsers::factory()->create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
        ]);

        ChatUsers::factory()->create([
            'chat_id' => $chat->id,
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/chats/'.$chat->id.'/participants');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                ['id', 'chat_id', 'user_id', 'joined_at', 'created_at', 'updated_at', 'get_user' => ['id', 'name', 'photo_url']]
            ],
        ]);
    }
}
