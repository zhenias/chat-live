<?php

namespace App\Models\Chat;

use app\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessages extends Model
{
    protected $table = 'chat_messages';

    public $timestamps = true;

    protected $fillable = [
        'chat',
        'user',
        'message',
        'chat_id',
        'user_id',
    ];

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class, 'id', 'chat_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
