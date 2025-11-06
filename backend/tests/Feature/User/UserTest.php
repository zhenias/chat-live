<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testGetUser(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
            'photo_url',
        ]);
    }

    public function testUpdateUserNotProvideData(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->patchJson('/api/user');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "name" => [
                "The name field is required."
            ],
            "email" => [
                "The email field is required."
            ]
        ]);
    }

    public function testUpdateUser(): void
    {
        $user = User::factory()->create();

        $name = fake()->name();
        $email = fake()->unique()->safeEmail();
        $plainPassword = 'strongPassword123$!';

        $response = $this->actingAs($user, 'api')->patch('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(200);
    }

    public function testUpdateUserProvideLongName(): void
    {
        $user = User::factory()->create();

        $name = Str::random(256);
        $email = fake()->unique()->safeEmail();
        $plainPassword = 'strongPassword123$!';

        $response = $this->actingAs($user, 'api')->patchJson('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "name" => [
                "The name field must not be greater than 255 characters."
            ]
        ]);
    }

    public function testUpdateUserProvideLongEmail(): void
    {
        $user = User::factory()->create();

        $name = fake()->name();
        $localPart = str_repeat('a', 256);
        $email = $localPart . '@x.pl';
        $plainPassword = 'strongPassword123$!';

        $response = $this->actingAs($user, 'api')->patchJson('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "email" => [
                "The email field must not be greater than 255 characters."
            ]
        ]);
    }

    public function testUpdateUserProvideInvalidEmail(): void
    {
        $user = User::factory()->create();

        $name = fake()->name();
        $email = 'jankowalski';
        $plainPassword = 'strongPassword123$!';

        $response = $this->actingAs($user, 'api')->patchJson('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "email" => [
                "The email field must be a valid email address."
            ]
        ]);
    }

    public function testUpdateUserProvideSmallPlainPassword(): void
    {
        $user = User::factory()->create();

        $name = fake()->name();
        $email = fake()->unique()->safeEmail();
        $plainPassword = 'strong';

        $response = $this->actingAs($user, 'api')->patchJson('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "plainPassword" => [
                "The plain password field must be at least 8 characters.",
                "Password must contain at least one uppercase letter, one lowercase letter, and one number."
            ]
        ]);
    }

    public function testUpdateUserProvideLongPlainPassword(): void
    {
        $user = User::factory()->create();

        $name = fake()->name();
        $email = fake()->unique()->safeEmail();
        $plainPassword = Str::random(256);

        $response = $this->actingAs($user, 'api')->patchJson('/api/user', [
            'name' => $name,
            'email' => $email,
            'plainPassword' => $plainPassword,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            "plainPassword" => [
                "The plain password field must not be greater than 255 characters."
            ]
        ]);
    }
}
