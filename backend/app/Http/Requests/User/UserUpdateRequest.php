<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            // Example: Jan Kowalski Nowak
            'name'          => 'required|string|max:255',
            // Example: admin@example.com
            'email'         => 'required|email|max:255|unique:users,email,'.request()?->user()?->id,
            // Example: strongPassword!@#123
            'plainPassword' => [
                'nullable',
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'example' => 'Jan Kowalski'
            ],
            'email' => [
                'example' => 'jan.kowalski@example.com'
            ],
            'plainPassword' => [
                'example' => 'strongPassword!@#123'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'plainPassword.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ];
    }
}
