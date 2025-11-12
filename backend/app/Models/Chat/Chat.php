<?php

namespace App\Models\Chat;

use app\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'is_group',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_group' => 'bool',
            'name'     => 'string',
        ];
    }

    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function getNameAttribute(): string
    {
        if ($this->is_group) {
            return $this->name ?? 'Unnamed group.';
        }

        $currentUserId = request()->user()->id;

        $otherUser = $this->chatUsers()
            ->where('user_id', '!=', $currentUserId)
            ->with('getUser:id,name,photo_url')
            ->first()
            ?->getUser()?->first();

        return $otherUser?->name ?? 'Unknown user.';
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessages::class, 'chat_id', 'id');
    }

    public function chatUsers(): HasMany
    {
        return $this->hasMany(ChatUsers::class, 'chat_id', 'id');
    }
}
