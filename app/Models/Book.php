<?php

namespace App\Models;

use App\Enums\BookType;
use Illuminate\Database\Eloquent\Model;

class   Book extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'book_type_id',
        'description',
        'genre_id',
    ];
    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookType()
    {
        return $this->belongsTo(Book_type::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
