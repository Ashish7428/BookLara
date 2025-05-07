<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Fiction', 'Non-Fiction', 'Science Fiction', 'Mystery',
            'Romance', 'Fantasy', 'Horror', 'Thriller', 'Biography',
            'History', 'Science', 'Technology', 'Business', 'Self-Help'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}