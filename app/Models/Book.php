<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function authors(){
        return $this->belongsTo(Author::class);
    }

    public function genres(){
        return $this->belongsTo(Genre::class);
    }
}
