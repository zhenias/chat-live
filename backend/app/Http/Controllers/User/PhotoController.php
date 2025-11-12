<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Photo\PhotoUpdateRequest;
use App\Services\Photo\PhotoService;

/**
 * @group User
 */
class PhotoController extends Controller
{
    public function __construct(private readonly PhotoService $photoService)
    {
    }

    /**
     * @response status=200 {
     * "status": "success",
     * "photo_url": "/path/to/photo.jpg"
     * }
     */
    public function updatePhotoUser(PhotoUpdateRequest $request)
    {
        $user     = $request->user();
        $photoUrl = $this->photoService->update($user, $request->file('photo'));

        return response()->json([
            'status'    => 'success',
            'photo_url' => $photoUrl,
        ]);
    }

    public function get()
    {
        $userPhotos = $this->photoService->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Get photos user.',
            'data' => $userPhotos,
        ]);
    }
}
