<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|unique:books,title',
            'description' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
            'genre_id' => 'required|integer|exists:genres,id',
            'book_type_id' => 'required|integer|exists:book_types,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Название книги обязательно',
            'title.unique' => 'Книга с таким названием уже существует',
            'author_id.required' => 'Автор обязателен',
            'author_id.exists' => 'Автор не найден',
        ];
    }
}
