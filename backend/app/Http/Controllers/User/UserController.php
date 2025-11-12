<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserSearchRequest;
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
     * @group Get users collection
     *
     * @response status=200 {
     * "status": "success",
     * "message": "Get users global.",
     * "data": [
     * {
     * "name": "Dump",
     * "id": 1,
     * "photo_url": ""
     * },
     * {
     * "name": "Verlie Rippin",
     * "id": 2,
     * "photo_url": ""
     * }
     * ]
     * }
     */
    public function getCollection()
    {
        $users = User::query()->select(['name', 'id', 'photo_url']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Get users global.',
            'data'    => $users->get(),
        ]);
    }

    /**
     * @group Get users collection
     *
     * @response status=200 {
     * "status": "success",
     * "message": "Get users search.",
     * "data": [
     * {
     * "name": "Jan Kowalski",
     * "id": 1,
     * "photo_url": ""
     * }
     * ]
     * }
     */
    public function getCollectionSearch(UserSearchRequest $request)
    {
        $users = User::query()->select(['name', 'id', 'photo_url']);

        $users = $users->when($request['search'], function ($query) use ($request) {
            $query->whereLike('name', "%".$request['search']."%");
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Get users search.',
            'data'    => $users->get(),
        ]);
    }

    /**
     * @response status=200 {
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
     * @response status=200 {
     * "status": "success",
     * "message": "User successful updated.",
     * "data": {
     * "id": 1,
     * "name": "Jan Kowalski",
     * "email": "jan.kowalski@example.com",
     * "email_verified_at": null,
     * "created_at": "2025-11-02T16:28:30.000000Z",
     * "updated_at": "2025-11-10T21:30:17.000000Z",
     * "photo_url": "/path/to/photo.jpg"
     * }
     * }
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

    // TODO: Napisać endpoint tworzenia użytkownika.
    public function create()
    {
    }
}
