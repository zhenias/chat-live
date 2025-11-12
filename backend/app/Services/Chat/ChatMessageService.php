<?php

namespace App\Services\Chat;

use App\Models\Chat\ChatMessages;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChatMessageService extends ChatService
{
    public static function create(int $chatId, array $data): ?ChatMessages
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        return ChatMessages::query()->create([
            'chat_id' => $chat->id,
            'user_id' => request()->user()->id,
            'message' => $data['message'],
        ]);
    }

    public static function get(int $chatId): LengthAwarePaginator
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        return ChatMessages::query()
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'DESC')
            ->with([
                'user:id,name,photo_url',
            ])
            ->paginate();
    }

    public static function delete(int $chatId, int $messageId): void
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new NotFoundException('Chat not found.', 404);
        }

        $message = ChatMessages::query()
            ->where('chat_id', $chat->id)
            ->where('id', $messageId)
            ->where('user_id', request()->user()->id)
            ->first();

        if (! $message) {
            throw new BadRequestHttpException('Message not found or is you not owner.');
        }

        $message->delete();
    }
}
