<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Services\Chat\ChatUserService;

class ChatUserController extends Controller
{
    public function __construct(private readonly ChatUserService $chatUserService)
    {
    }

    public function get(int $chatId)
    {
        $chatUsers = $this->chatUserService->get($chatId);

        return response()->json([
            'status'  => 'success',
            'message' => 'Get users in chat.',
            'data'    => $chatUsers,
        ]);
    }
}
