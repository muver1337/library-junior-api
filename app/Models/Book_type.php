<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book_type extends Model
{
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
