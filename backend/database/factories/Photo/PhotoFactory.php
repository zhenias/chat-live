<?php

namespace Database\Factories\Photo;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'photo_url' => 'path/to/image/get.jpg',
        ];
    }
}
