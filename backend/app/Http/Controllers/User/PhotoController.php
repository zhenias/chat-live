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

    /**
     * @response status=200 {
     * "status": "success",
     * "message": "Get photos user.",
     * "data": [
     * {
     * "id": 1,
     * "user_id": 1,
     * "photo_url": "http://127.0.0.1:8000/storage/photos/Rx3g7HkySVEmjx604iQs8LhX5RdV8PuRBVYS7HG2.png",
     * "created_at": "2025-11-12T21:20:46.000000Z",
     * "updated_at": "2025-11-12T21:20:46.000000Z"
     * }
     * ]
     * }
     */
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
