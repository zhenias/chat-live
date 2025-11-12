<?php

namespace App\Http\Requests\Photo;

use Illuminate\Foundation\Http\FormRequest;

class PhotoUpdateRequest extends FormRequest
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
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=50,min_height=50,max_width=8000,max_height=8000',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'photo' => [
                'example' => 'storage/app/public/image.jpg'
            ],
        ];
    }
}
