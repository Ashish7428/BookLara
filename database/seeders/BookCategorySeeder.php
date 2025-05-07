<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Category;


class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $bookCategories = [
            ['book_id' => 1, 'category_id' => 3],
            ['book_id' => 2, 'category_id' => 5],
            ['book_id' => 6, 'category_id' => 7],
            ['book_id' => 6, 'category_id' => 1],
            ['book_id' => 7, 'category_id' => 1],
            ['book_id' => 7, 'category_id' => 6],
            ['book_id' => 8, 'category_id' => 6],
            ['book_id' => 9, 'category_id' => 9],
            ['book_id' => 10, 'category_id' => 10],
            ['book_id' => 11, 'category_id' => 11],
            ['book_id' => 12, 'category_id' => 2],
            ['book_id' => 13, 'category_id' => 4],
            ['book_id' => 14, 'category_id' => 5],
            ['book_id' => 15, 'category_id' => 8],
            ['book_id' => 16, 'category_id' => 3],
            ['book_id' => 17, 'category_id' => 7],
            ['book_id' => 18, 'category_id' => 6],
            ['book_id' => 19, 'category_id' => 1],
            ['book_id' => 20, 'category_id' => 2],
        ];

        foreach ($bookCategories as $bookCategory) {
            if (!DB::table('book_category')->where('book_id', $bookCategory['book_id'])->where('category_id', $bookCategory['category_id'])->exists()) {
                DB::table('book_category')->insert($bookCategory);
            }
        }
    }
}
