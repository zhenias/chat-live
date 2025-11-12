<?php

namespace Database\Factories\Chat;

use App\Models\Chat\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatUsersFactory extends Factory
{
    public function definition(): array
    {
        return [
            'chat_id' => Chat::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }
}
