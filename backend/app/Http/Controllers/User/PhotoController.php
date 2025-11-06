<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Photo\PhotoUpdateRequest;
use App\Services\Photo\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PhotoController extends Controller
{
    public function __construct(private readonly PhotoService $photoService)
    {
    }

    public function updatePhotoUser(PhotoUpdateRequest $request)
    {
        $user     = $request->user();
        $photoUrl = $this->photoService->update($user, $request->file('photo'));

        return response()->json([
            'status'    => 'success',
            'photo_url' => $photoUrl,
        ]);
    }
}
