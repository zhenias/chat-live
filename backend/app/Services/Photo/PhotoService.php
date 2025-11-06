<?php

namespace App\Services\Photo;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PhotoService
{
    public static function update(User $user, UploadedFile $photo): string
    {
        $path = $photo->store('photos', 'public');
        $user->update([
            'photo_url' => $path
        ]);

        return Storage::url($path);
    }
}
