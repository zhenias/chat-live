<?php

namespace App\Services\Chat;

use App\Models\Chat\ChatUsers;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChatUserService extends ChatService
{
    public static function get(int $chatId): Collection
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        return ChatUsers::query()
            ->where('chat_id', $chatId)
            ->with([
                'getUser:id,name,photo_url',
            ])
            ->get();
    }

    public static function create(int $chatId, array $data): array
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        if (! $chat->is_group) {
            throw new BadRequestHttpException('Chat is not group.');
        }

        if (! $chat->isAdmin()) {
            throw new BadRequestHttpException('You is not admin.');
        }

        $chatUsersCreate = [];

        foreach ($data['users'] as $user) {
            $chatUsersCreate[] = ChatUsers::query()
                ->updateOrCreate(
                    [
                        'chat_id' => $chat->id,
                        'user_id' => $user['id'],
                    ],
                    [
                        'is_admin' => $user['is_admin'] ?? false,
                    ]
                )
                ->load('getUser:id,name,photo_url');
        }

        return $chatUsersCreate;
    }
}
