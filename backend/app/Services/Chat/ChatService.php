<?php

namespace App\Services\Chat;

use App\Models\Chat\Chat;
use App\Models\Chat\ChatUsers;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChatService
{
    public static function createChat(array $data): ?Chat
    {
        $user = request()->user();

        if (isset($data['is_group']) && ! $data['is_group'] && self::isExistChatWithUsers($user->id, $data['user_id'])) {
            throw new BadRequestHttpException('Chat is exists.');
        }

        $chat = Chat::query()->create([
            'name'       => $data['name_group'] ?? null,
            'is_group'   => $data['is_group']   ?? false,
            'created_by' => $user->id,
        ])
        ->load([
            'createdBy:id,name,photo_url',
        ]);

        ChatUsers::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
        ]);

        if (! isset($data['name_group'])) {
            ChatUsers::create([
                'chat_id' => $chat->id,
                'user_id' => $data['user_id'],
            ]);
        }

        return $chat;
    }

    public static function deleteChat(int $chatId): void
    {
        $chat = self::getChat($chatId);

        if (! $chat) {
            throw new BadRequestException('Chat not found.', 400);
        }

        $chat->delete();
    }

    public static function getChatsList(): Collection
    {
        $uid = request()->user()->id;

        return Chat::query()->select([
            'id',
            'name',
            'is_group',
            'created_by',
        ])
        ->with([
            'createdBy:id,name,photo_url',
        ])
        ->where('created_by', $uid)
        ->orWhereHas('chatUsers', function ($q) use ($uid) {
            $q->select('user_id')
            ->where('user_id', $uid);
        })
        ->get();
    }

    protected static function getChat(int $chatId): ?Chat
    {
        $uid = request()->user()->id;

        return Chat::query()->select([
            'id',
            'name',
            'is_group',
            'created_by',
        ])
        ->where('id', $chatId)
        ->where('created_by', $uid)
        ->orWhereHas('chatUsers', function ($q) use ($uid) {
            $q->select('user_id')
            ->where('user_id', $uid);
        })
        ->first();
    }

    protected static function isExistChatWithUsers(int $user1, int $user2): ?Chat
    {
        return Chat::query()
            ->select(['created_by'])
            ->where('is_group', false)
            ->whereHas('chatUsers', fn ($q) => $q->where('user_id', $user1))
            ->whereHas('chatUsers', fn ($q) => $q->where('user_id', $user2))
            ->first();
    }
}
