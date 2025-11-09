<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatMessageRequest;
use App\Services\Chat\ChatMessageService;
use Illuminate\Http\Request;

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
        ]);
    }

    public function delete()
    {
    }
}
