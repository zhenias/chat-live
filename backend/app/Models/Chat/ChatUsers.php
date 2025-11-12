<?php

namespace App\Models\Chat;

use app\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatUsers extends Model
{
    use HasFactory;

    protected $table = 'chat_users';

    public $timestamps = true;

    protected $fillable = [
        'joined_at',
        'chat_id',
        'user_id',
        'is_admin',
    ];

    protected static function boot(): void
    {
        parent::boot();

        parent::creating(function (self $model) {
            $model->joined_at = $model->created_at ?? date('Y-m-d H:i:s');
        });
    }

    public function getChat(): HasOne
    {
        return $this->hasOne(Chat::class, 'id', 'chat_id');
    }

    public function getUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
