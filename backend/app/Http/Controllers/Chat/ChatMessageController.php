<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatMessageRequest;
use App\Services\Chat\ChatMessageService;

/**
 * @group Chat messages
 * @urlParam chatId integer required Chat id.
 * @urlParam messageId integer required Message id.
 */
class ChatMessageController extends Controller
{
    public function __construct(private readonly ChatMessageService $chatMessageService)
    {
    }

    /**
    * @response status=404 {
    * "status": "error",
    * "message": "Chat not found.",
    * "code": 404
    * }
     *
     * @response status=201 {
     * "status": "success",
     * "message": "Message create.",
     * "data": {
     * "chat_id": 2,
     * "user_id": 1,
     * "message": "Hej.",
     * "updated_at": "2025-11-11T17:23:00.000000Z",
     * "created_at": "2025-11-11T17:23:00.000000Z",
     * "id": 4
     * }
     * }
    */
    public function create(int $chatId, ChatMessageRequest $request)
    {
        $message = $this->chatMessageService->create($chatId, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Message create.',
            'data'    => $message,
        ], 201);
    }

    /**
     * @response status=404 {
     * "status": "error",
     * "message": "Chat not found.",
     * "code": 404
     * }
     *
     * @response status=200 {
     * "current_page": 1,
     * "data": [
     * {
     * "id": 4,
     * "chat_id": 2,
     * "user_id": 1,
     * "message": "Hej.",
     * "created_at": "2025-11-11T17:23:00.000000Z",
     * "updated_at": "2025-11-11T17:23:00.000000Z",
     * "user": {
     * "id": 1,
     * "name": "Dump",
     * "photo_url": ""
     * }
     * }
     * ],
     * "first_page_url": "http://127.0.0.1:8000/api/chats/1/messages?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://127.0.0.1:8000/api/chats/1/messages?page=1",
     * "links": [
     * {
     * "url": null,
     * "label": "&laquo; Previous",
     * "page": null,
     * "active": false
     * },
     * {
     * "url": "http://127.0.0.1:8000/api/chats/1/messages?page=1",
     * "label": "1",
     * "page": 1,
     * "active": true
     * },
     * {
     * "url": null,
     * "label": "Next &raquo;",
     * "page": null,
     * "active": false
     * }
     * ],
     * "next_page_url": null,
     * "path": "http://127.0.0.1:8000/api/chats/1/messages",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     */
    public function get(int $chatId)
    {
        $messages = $this->chatMessageService->get($chatId);

        return response()->json($messages);
    }

    /**
     * @response status=404 {
     * "status": "error",
     * "message": "Chat not found.",
     * "code": 404
     * }
     *
     * @response status=400 {
     *  "status": "error",
     *  "message": "Message not found or is you not owner.",
     *  "code": 400
     *  }
     *
     * @response status=204 null
     */
    public function delete(int $chatId, int $messageId)
    {
        $this->chatMessageService->delete($chatId, $messageId);

        return response()->json(null, 204);
    }
}
