<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Война и мир',
            'description' => 'Роман-эпопея в четырёх томах',
            'user_id' => 2,
            'book_type_id' => 1,
            'genre_id' => 4,
        ]);

        Book::create([
            'title' => 'Преступление и наказание',
            'description' => 'Роман о нравственных терзаниях',
            'user_id' => 2,
            'book_type_id' => 1,
            'genre_id' => 4,
        ]);
    }
}
