<?php

namespace App\Services\Photo;

use App\Models\Photo\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    public static function update(User $user, UploadedFile $photo): string
    {
        $path = $photo->store('photos', 'public');
        $user->update([
            'photo_url' => $path,
        ]);

        self::addPhotoLibrary($path, $user);

        return Storage::url($path);
    }

    private static function addPhotoLibrary(string $path, User $user): void
    {
        Photo::create([
            'user_id' => $user->id,
            'photo_url' => $path,
        ]);
    }
}
