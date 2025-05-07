<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookGenreSeeder extends Seeder
{
    public function run()
    {
        DB::table('book_genre')->insert([
            'book_id' => 1,
            'genre_id' => 1
        ]);
    }
}