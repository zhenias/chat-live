<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatMessageRequest;
use App\Services\Chat\ChatMessageService;

class ChatMessageController extends Controller
{
    public function __construct(private readonly ChatMessageService $chatMessageService)
    {
    }

    public function create(int $chatId, ChatMessageRequest $request)
    {
        $message = $this->chatMessageService->create($chatId, $request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Message create.',
            'data'    => $message,
        ], 201);
    }

    public function get(int $chatId)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Get chat data.',
            'data'    => $this->chatMessageService->get($chatId),
        ]);
    }

    public function delete(int $chatId, int $messageId)
    {
        $this->chatMessageService->delete($chatId, $messageId);

        return response()->json(null, 204);
    }
}
