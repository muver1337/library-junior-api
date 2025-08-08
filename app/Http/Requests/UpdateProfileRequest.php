<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->user()->id;

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'bio' => 'sometimes|string|nullable',
            'password' => 'sometimes|string|min:6|confirmed',
            'role' => 'prohibited',
            'created_at' => 'prohibited',
            'updated_at' => 'prohibited',
            'id' => 'prohibited',
        ];
    }
}
