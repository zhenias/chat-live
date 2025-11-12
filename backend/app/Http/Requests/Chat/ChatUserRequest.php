<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ChatUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'users'    => 'required|array',
            'users.*.id'  => 'required|integer|exists:users,id',
            'users.*.is_admin' => 'nullable|boolean',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'users' => [
                'type' => 'array',
                'description' => 'Lista użytkowników przypisywanych do czatu.',
                'example' => [
                    ['id' => 1, 'is_admin' => true],
                    ['id' => 2, 'is_admin' => false],
                ],
            ],
            'users[].id' => [
                'type' => 'integer',
                'description' => 'ID użytkownika.',
                'example' => 1,
            ],
            'users[].is_admin' => [
                'type' => 'boolean',
                'description' => 'Czy użytkownik jest administratorem czatu.',
                'example' => true,
            ],
        ];
    }
}
