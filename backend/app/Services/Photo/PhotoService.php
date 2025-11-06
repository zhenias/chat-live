<?php

namespace App\Services\Photo;

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

        return Storage::url($path);
    }
}
