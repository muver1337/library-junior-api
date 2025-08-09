<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'fantasy'],
            ['name' => 'detective'],
            ['name' => 'adventure'],
            ['name' => 'romance'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
