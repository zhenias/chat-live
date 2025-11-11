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
     * @bodyParam photo file required The image for profile user.
     *
     * @response scenario=success {
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
}
