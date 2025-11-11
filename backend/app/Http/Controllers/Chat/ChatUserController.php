<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Services\Chat\ChatUserService;

/**
 * @group Chat user for group
 * @urlParam chatId integer required Chat id.
 */
class ChatUserController extends Controller
{
    public function __construct(private readonly ChatUserService $chatUserService)
    {
    }

    /**
     * @response status=200 {
     * "status": "success",
     * "message": "Get users in chat.",
     * "data": [
     * {
     * "id": 3,
     * "chat_id": 2,
     * "user_id": 1,
     * "joined_at": "2025-11-11 16:48:02",
     * "created_at": "2025-11-11T15:48:02.000000Z",
     * "updated_at": "2025-11-11T15:48:02.000000Z",
     * "get_user": {
     * "id": 1,
     * "name": "Dump",
     * "photo_url": ""
     * }
     * },
     * {
     * "id": 4,
     * "chat_id": 2,
     * "user_id": 2,
     * "joined_at": "2025-11-11 16:48:02",
     * "created_at": "2025-11-11T15:48:02.000000Z",
     * "updated_at": "2025-11-11T15:48:02.000000Z",
     * "get_user": {
     * "id": 2,
     * "name": "Verlie Rippin",
     * "photo_url": ""
     * }
     * }
     * ]
     * }
     */
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
