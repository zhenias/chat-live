<?php

namespace App\Models\Photo;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'photo_url',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        $path = $this->attributes['photo_url'] ?? null;

        return $path ? asset('storage/' . $path) : null;
    }
}
