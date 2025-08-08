<?php

namespace App\Models;

use App\Models\BookType;
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
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookType()
    {
        return $this->belongsTo(BookType::class, 'book_type_id');
    }

    public function genre(){
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function scopeFilterTitle($query, $title)
    {
        if ($title) {
            $query->where('title', 'like', '%'.$title.'%');
        }
        return $query;
    }

    public function scopeFilterAuthor($query, $user_id)
    {
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
        return $query;
    }

    public function scopeFilterGenre($query, $genreId)
    {
        if ($genreId) {
            $query->where('genre_id', $genreId);
        }
        return $query;
    }

    public function scopeFilterCreatedFrom($query, $dateFrom)
    {
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        return $query;
    }

    public function scopeFilterCreatedTo($query, $dateTo)
    {
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
        return $query;
    }

    public function scopeSortTitle($query, $direction)
    {
        if (in_array($direction, ['asc', 'desc'])) {
            $query->orderBy('title', $direction);
        }
        return $query;
    }
}
