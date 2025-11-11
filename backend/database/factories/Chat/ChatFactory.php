<?php

namespace Database\Factories\Chat;

use app\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => null,
            'is_group'   => 0,
            'created_by' => User::factory()->create(),
        ];
    }
}
