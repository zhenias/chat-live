<?php

namespace App\Services\User;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function update(array $data, User $user): void
    {
        if (!empty($data['plainPassword'])) {
            $data['password'] = Hash::make($data['plainPassword']);

            unset($data['plainPassword']);
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ?? $user->password,
        ]);
    }
}
