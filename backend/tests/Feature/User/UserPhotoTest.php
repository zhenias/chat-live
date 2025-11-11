<?php

namespace Tests\Feature\User;

use app\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserPhotoTest extends TestCase
{
    public function testPhotoIsRequired(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/user/photo', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'photo' => ['The photo field is required.'],
        ]);
    }

    public function testPhotoMustBeImage(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user, 'api')->postJson('/api/user/photo', [
            'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'photo' => ['The photo field must be an image.'],
        ]);
    }

    public function testPhotoMustHaveAllowedMimeType(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('photo.gif');

        $response = $this->actingAs($user, 'api')->postJson('/api/user/photo', [
            'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'photo' => ['The photo field must be a file of type: jpg, jpeg, png.'],
        ]);
    }

    public function testPhotoMustNotExceedMaxSize(): void
    {
        $user = User::factory()->create();

        // 3 MB fake image (limit = 2 MB)
        $file = UploadedFile::fake()->image('photo.png')->size(3072);

        $response = $this->actingAs($user, 'api')->postJson('/api/user/photo', [
            'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'photo' => ['The photo field must not be greater than 2048 kilobytes.'],
        ]);
    }

    public function testPhotoUploadSuccess(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('photo.jpg', 300, 300);

        $response = $this->actingAs($user, 'api')->postJson('/api/user/photo', [
            'photo' => $file,
        ]);

        $response->assertStatus(200);

        Storage::disk('public')->assertExists('photos/' . $file->hashName());
    }
}
