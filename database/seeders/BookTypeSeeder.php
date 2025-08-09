<?php

namespace Database\Seeders;

use App\Models\BookType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'printed'],
            ['name' => 'digital'],
            ['name' => 'graphic'],
        ];

        foreach ($types as $type) {
            BookType::create($type);
        }
    }
}
