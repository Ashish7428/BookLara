<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class UpdateTrendingBooks extends Command
{
    protected $signature = 'books:update-trending';
    protected $description = 'Update the cached trending books list';

    public function handle()
    {
        $trendingBooks = Book::where('status', 'approved')
            ->where('views', '>', 0)
            ->orderByDesc('views')
            ->take(8)
            ->get();

        if ($trendingBooks->count() < 8) {
            $needed = 8 - $trendingBooks->count();
            $randomBooks = Book::where('status', 'approved')
                ->where('views', 0)
                ->inRandomOrder()
                ->take($needed)
                ->get();
            $trendingBooks = $trendingBooks->concat($randomBooks);
        }

        // Cache for 11 minutes to avoid overlap
        Cache::put('trending_books', $trendingBooks, now()->addMinutes(11));
        $this->info('Trending books cache updated.');
    }
}
