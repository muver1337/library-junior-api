<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    protected $table = 'book_types';

    protected $fillable = ['name'];
}
