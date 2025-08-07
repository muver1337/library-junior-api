<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'string',
                Rule::unique('books', 'title')->ignore($this->route('id')),
            ],
            'description' => 'sometimes|nullable|string',
            'type' => 'sometimes|in:printed,digital,graphic',
            'genre_ids' => 'sometimes|array',
            'genre_ids.*' => 'exists:genres,id',
        ];
    }
}
