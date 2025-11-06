<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function get(Request $request)
    {
        return $request->user();
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $this->userService->update($request->validated(), $user);

        return response()->json([
            'message' => 'User successful updated.',
        ]);
    }

    public function create()
    {
    }
}
