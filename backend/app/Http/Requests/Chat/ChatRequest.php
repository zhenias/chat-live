<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'is_group'   => 'nullable|boolean',
            'name_group' => 'required_if:is_group,true|string|max:255',
            'user_id'    => 'required_if:is_group,false|integer|exists:users,id',
        ];
    }

    public function queryParameters(): array
    {
        return [
            'is_group' => [
                'example' => false,
            ],
            'name_group' => [
                'example' => 'Nazwa grupy',
            ],
            'user_id' => [
                'example' => 1,
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->sometimes('name_group', 'required|string|max:255', function ($input) {
            return $input->is_group === true;
        });

        $validator->sometimes('user_id', 'required|integer|exists:users,id', function ($input) {
            return $input->is_group === false;
        });

        $validator->after(function ($validator) {
            if (! $this->is_group && $this->user_id == auth()->id()) {
                $validator->errors()->add('user_id', 'You cannot start a chat with yourself.');
            }
        });
    }
}
