<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatRequest;
use App\Services\Chat\ChatService;

/**
 * @group Chat
 * @urlParam chatId integer required Chat id.
 */
class ChatController extends Controller
{
    public function __construct(private readonly ChatService $chatService)
    {
    }

    /**
     * @response status=201 {
     * "status": "success",
     * "message": "Chat is created.",
     * "data": {
     * "name": "Verlie Rippin",
     * "is_group": false,
     * "created_by": {
     * "id": 1,
     * "name": "Dump",
     * "photo_url": ""
     * },
     * "updated_at": "2025-11-11T15:48:02.000000Z",
     * "created_at": "2025-11-11T15:48:02.000000Z",
     * "id": 2
     * }
     * }
     *
     * @response status=400 {
     * "status": "error",
     * "message": "Chat is exits.",
     * "code": 400
     * }
     */
    public function create(ChatRequest $request)
    {
        $chat = $this->chatService->createChat($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Chat is created.',
            'data'    => $chat,
        ], 201);
    }

    /**
     * @response status=200 {
     * "status": "success",
     * "message": "Get chats.",
     * "data": [
     * {
     * "id": 1,
     * "name": "Verlie Rippin",
     * "is_group": false,
     * "created_by": {
     * "id": 1,
     * "name": "Dump",
     * "photo_url": ""
     * }
     * }
     * ]
     * }
     */
    public function get()
    {
        $chats = $this->chatService->getChatsList();

        return response()->json([
            'status'  => 'success',
            'message' => 'Get chats.',
            'data'    => $chats,
        ]);
    }

    /**
     * @response status=204 null
     * @response status=404 {
     *  "status": "error",
     *  "message": "Chat not found.",
     *  "code": 404
     *  }
     */
    public function delete(int $chatId)
    {
        $this->chatService->deleteChat($chatId);

        return response()->json(null, 204);
    }
}
