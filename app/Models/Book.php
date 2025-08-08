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

    public function scopeFilterTitle($query, $title)
    {
        if ($title) {
            $query->where('title', 'like', '%'.$title.'%');
        }
    }

    public function scopeFilterAuthor($query, $user_id)
    {
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
    }

    public function scopeFilterGenre($query, $genreId)
    {
        if ($genreId) {
            $query->where('genre_id', $genreId);
        }
    }

    public function scopeFilterCreatedFrom($query, $dateFrom)
    {
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
    }

    public function scopeFilterCreatedTo($query, $dateTo)
    {
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
    }

    public function scopeSortTitle($query, $direction)
    {
        if (in_array($direction, ['asc', 'desc'])) {
            $query->orderBy('title', $direction);
        }
    }
}
