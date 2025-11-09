<?php

namespace App\Services\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\ChatMessages;
use Http\Discovery\Exception\NotFoundException;

class ChatMessageService extends ChatService
{
    public static function create(int $chatId, array $data): ?ChatMessages
    {
        $chat = self::getChat($chatId);

        if (!$chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        $message = ChatMessages::create([
            'chat_id' => $chat->id,
            'user_id' => request()->user()->id,
            'message' => $data['message'],
        ]);

        return $message;
    }
}
