<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use app\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

/**
 * @group User
 */
class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @response scenario=success {
     * "status": "success",
     * "message": "Get users global.",
     * "data": [
     * {
     * "id": 1,
     * "name": "Jan Kowalski",
     * "email": "jan@example.com",
     * "email_verified_at": "2025-11-02T16:28:30.000000Z",
     * "created_at": "2025-11-02T16:28:30.000000Z",
     * "updated_at": "2025-11-10T21:30:17.000000Z",
     * "photo_url": "/path/to/photo.jpg"
     * }
     * ]
     * }
     */
    public function getCollection()
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Get users global.',
            'data'    => User::query()->get(),
        ]);
    }

    /**
     * @response scenario=success {
     * "id": 1,
     * "name": "Jan Kowalski",
     * "email": "jan@example.com",
     * "email_verified_at": "2025-11-02T16:28:30.000000Z",
     * "created_at": "2025-11-02T16:28:30.000000Z",
     * "updated_at": "2025-11-10T21:30:17.000000Z",
     * "photo_url": "/path/to/photo.jpg"
     * }
     */
    public function get(Request $request)
    {
        return $request->user();
    }

    /**
     * @bodyParam name string required Username user.
     * @bodyParam email string required Email user.
     * @bodyParam plainPassword string
     */
    public function update(UserUpdateRequest $request)
    {
        $user       = $request->user();
        $updateUser = $this->userService->update($request->validated(), $user);

        return response()->json([
            'status'  => 'success',
            'message' => 'User successful updated.',
            'data'    => $updateUser,
        ]);
    }

    public function create()
    {
    }
}
