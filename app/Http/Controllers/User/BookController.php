<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ReadingProgress;
use setasign\Fpdi\Fpdi;

class BookController extends Controller
{
    public function browse(Request $request)
    {
        $query = Book::with(['categories', 'author'])
                     ->where('status', 'approved');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $books = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::all();
                         
        return view('user.books.browse', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book = Book::with(['categories', 'author'])
            ->where('id', $book->id)
            ->first();
        
        return view('user.books.show', compact('book'));
    }

    public function read(Book $book)
    {
        // Increment the views count
        $book->increment('views');
        try {
            $pdfPath = base_path('public/storage/' . $book->pdf_path);
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);
            
            // Get or create reading progress
            $progress = ReadingProgress::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'book_id' => $book->id
                ],
                [
                    'status' => 'reading',
                    'total_pages' => $pageCount,
                    'current_page' => 1,
                    'progress' => 0
                ]
            );
            
            $currentPage = max(1, $progress->current_page);
            
            return view('user.books.read', compact('book', 'currentPage', 'pageCount'));
        } catch (\setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException $e) {
            return back()->with('error', 'This PDF uses a compression method not supported by our reader. Please contact support or try a different file.');
        }
    }

    public function saveProgress(Request $request, Book $book)
    {
        $progress = ReadingProgress::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($progress) {
            $currentPage = $request->page;
            $percentComplete = ($currentPage / $progress->total_pages) * 100;

            $progress->update([
                'current_page' => $currentPage,
                'progress' => $percentComplete,
                'status' => $currentPage >= $progress->total_pages ? 'completed' : 'reading'
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getPage(Book $book, $page)
    {
        // Update PDF path with absolute path
        $pdfPath = base_path('public/storage/' . $book->pdf_path);
        
        // Ensure page number is valid
        $page = max(1, min($page, $this->getPageCount($pdfPath)));
        
        // Create PDF instance
        $pdf = new Fpdi();
        $pdf->setSourceFile($pdfPath);
        $pdf->AddPage();
        $pdf->useTemplate($pdf->importPage($page));
        
        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf');
    }

    private function getPageCount($pdfPath)
    {
        $pdf = new Fpdi();
        return $pdf->setSourceFile($pdfPath);
    }

    public function bookmarks()
    {
        $user = auth()->user();
        $bookmarks = $user->bookmarks()->with('book.author')->get();
        return view('user.books.bookmarks', compact('bookmarks'));
    }
}