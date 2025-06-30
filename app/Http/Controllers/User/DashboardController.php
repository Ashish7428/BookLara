<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingProgress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Reading Statistics
        $currentlyReading = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'reading')
            ->count();

        $completedBooks = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $readingHours = ReadingProgress::where('user_id', $user->id)
            ->sum('reading_time') ?? 0;

        $reviewsCount = $user->comments()->count() ?? 0;

        $bookmarksCount = $user->bookmarks()->count() ?? 0;

        // Last Book (currently reading)
        $lastBook = ReadingProgress::where('user_id', $user->id)
            ->where('status', 'reading')
            ->latest()
            ->first()?->book;

        // My Books (recent reading progress)
        $myBooks = ReadingProgress::where('user_id', $user->id)
            ->with('book')
            ->latest()
    
            ->get();

        // Trending Books (from cache if available)
        $trendingBooks = \Cache::get('trending_books');
        if (!$trendingBooks) {
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
        }

        // Categories with book counts
        $categories = Category::withCount('books')->get();

        return view('user.dashboard', compact(
            'currentlyReading',
            'completedBooks',
            'readingHours',
            'reviewsCount',
            'bookmarksCount',
            'lastBook',
            'myBooks',
            'trendingBooks',
            'categories'
        ));
    }
}
