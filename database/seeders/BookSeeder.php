<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'author_id' => 1,
                'title' => 'Malgudi Days',
                'slug' => 'malgudi-days',
                'description' => 'A collection of short stories set in the fictional town of Malgudi, showcasing everyday life in India.',
                'cover_image' => 'covers/1.jpg',
                'pdf_path' => 'pdfs/1.pdf',
                'publication_year' => 1943,
                'status' => 'pending',
                // 'genres' => [1, 4]
            ],
            [
                'author_id' => 2,
                'title' => 'The Blue Umbrella',
                'slug' => 'the-blue-umbrella',
                'description' => 'A heartwarming tale of a little girl and her prized blue umbrella in a small Indian village.',
                'cover_image' => 'covers/2.jpg',
                'pdf_path' => 'pdfs/2.pdf',
                'publication_year' => 1980,
                'status' => 'pending',
                // 'genres' => [2, 5]
            ],
            [
                'author_id' => 3,
                'title' => 'The God of Small Things',
                'slug' => 'the-god-of-small-things',
                'description' => 'A Booker Prize-winning novel exploring forbidden love and social discrimination in Kerala, India.',
                'cover_image' => 'covers/3.jpg',
                'pdf_path' => 'pdfs/3.pdf',
                'publication_year' => 1997,
                'status' => 'pending',
                // 'genres' => [3, 6]
            ],
            [
                'author_id' => 4,
                'title' => 'Five Point Someone',
                'slug' => 'five-point-someone',
                'description' => 'A humorous take on college life in India, highlighting the struggles of three friends at IIT.',
                'cover_image' => 'covers/4.jpg',
                'pdf_path' => 'pdfs/4.pdf',
                'publication_year' => 2004,
                'status' => 'pending',
                // 'genres' => [4, 7]
            ],
            [
                'author_id' => 4,
                'title' => 'Revolution 2020',
                'slug' => 'revolution-2020',
                'description' => 'A love story set against the backdrop of corruption in India’s education system.',
                'cover_image' => 'covers/5.jpg',
                'pdf_path' => 'pdfs/5.pdf',
                'publication_year' => 2011,
                'status' => 'pending',
                // 'genres' => [2, 8]
            ],
            [
                'author_id' => 5,
                'title' => 'The Immortals of Meluha',
                'slug' => 'the-immortals-of-meluha',
                'description' => 'A mythological fiction novel reimagining the legend of Lord Shiva.',
                'cover_image' => 'covers/6.jpg',
                'pdf_path' => 'pdfs/6.pdf',
                'publication_year' => 2010,
                'status' => 'pending',
                // 'genres' => [1, 9]
            ],
            [
                'author_id' => 6,
                'title' => 'Train to Pakistan',
                'slug' => 'train-to-pakistan',
                'description' => 'A powerful narrative on the partition of India and its impact on ordinary people.',
                'cover_image' => 'covers/7.jpg',
                'pdf_path' => 'pdfs/7.pdf',
                'publication_year' => 1956,
                'status' => 'pending',
                // 'genres' => [10, 6]
            ],
            [
                'author_id' => 6,
                'title' => 'Shadow Lines',
                'slug' => 'shadow-lines',
                'description' => 'A novel that blurs the boundaries between past and present, reality and memory.',
                'cover_image' => 'covers/8.jpg',
                'pdf_path' => 'pdfs/8.pdf',
                'publication_year' => 1988,
                'status' => 'pending',
                // 'genres' => [11, 5]
            ],
            [
                'author_id' => 7,
                'title' => "'Midnight's Children'",
                'slug' => 'midnights-children',
                'description' => 'A landmark novel narrating the story of India’s transition to independence.',
                'cover_image' => 'covers/9.jpg',
                'pdf_path' => 'pdfs/9.pdf',
                'publication_year' => 1981,
                'status' => 'pending',
                // 'genres' => [12, 3]
            ],
            [
                'author_id' => 8,
                'title' => 'A Suitable Boy',
                'slug' => 'a-suitable-boy',
                'description' => 'A sweeping tale of family, politics, and love in post-independence India.',
                'cover_image' => 'covers/10.jpg',
                'pdf_path' => 'pdfs/10.pdf',
                'publication_year' => 1993,
                'status' => 'pending',
                // 'genres' => [13, 7]
            ],
            [
                'author_id' => 9,
                'title' => 'The White Tiger',
                'slug' => 'the-white-tiger',
                'description' => 'A darkly humorous novel exploring class struggle and ambition in modern India.',
                'cover_image' => 'covers/11.jpg',
                'pdf_path' => 'pdfs/11.pdf',
                'publication_year' => 2008,
                'status' => 'pending',
                // 'genres' => [14, 5]
            ],
            [
                'author_id' => 10,
                'title' => 'Interpreter of Maladies',
                'slug' => 'interpreter-of-maladies',
                'description' => 'A collection of poignant short stories exploring the Indian diaspora and cultural identity.',
                'cover_image' => 'covers/12.jpg',
                'pdf_path' => 'pdfs/12.pdf',
                'publication_year' => 1999,
                'status' => 'pending',
                // 'genres' => [14, 2]
            ],
            [
                'author_id' => 11,
                'title' => 'The Inheritance of Loss',
                'slug' => 'the-inheritance-of-loss',
                'description' => 'A novel depicting the complexities of globalization and its impact on individuals.',
                'cover_image' => 'covers/13.jpg',
                'pdf_path' => 'pdfs/13.pdf',
                'publication_year' => 2006,
                'status' => 'pending',
                // 'genres' => [15, 7]
            ]
        ];

        foreach ($books as $book) {
            if (!Book::where('slug', $book['slug'])->exists()) {
                $createdBook = Book::create($book);
                // $createdBook->genres()->attach($book['genres']);
            }
        }
    }
}
