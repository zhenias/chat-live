<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatRequest;
use App\Services\Chat\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private readonly ChatService $chatService)
    {
    }

    public function create(ChatRequest $request)
    {
        $chat = $this->chatService->createChat($request->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Chat is created.',
            'data'    => $chat,
        ], 201);
    }

    public function get()
    {
        $chats = $this->chatService->getChatsList();

        return response()->json([
            'status'  => 'success',
            'message' => 'Get chats.',
            'data'    => $chats,
        ]);
    }

    public function delete(int $chatId)
    {
        $this->chatService->deleteChat($chatId);

        return response()->json(null, 204);
    }
}
