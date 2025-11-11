<?php

namespace App\Services\Chat;

use App\Models\Chat\ChatUsers;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ChatUserService extends ChatService
{
    public static function get(int $chatId): Collection
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new BadRequestException('Chat not found.', 400);
        }

        return ChatUsers::query()
            ->where('chat_id', $chatId)
            ->with([
                'getUser:id,name,photo_url',
            ])
            ->get();
    }
}
