<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use app\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function getCollection()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get users global.',
            'data' => User::query()->whereNotNull('users.email_verified_at')->get()
        ]);
    }

    public function get(Request $request)
    {
        return $request->user();
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $updateUser = $this->userService->update($request->validated(), $user);

        return response()->json([
            'status' => 'success',
            'message' => 'User successful updated.',
            'data'    => $updateUser,
        ]);
    }

    public function create()
    {
    }
}
