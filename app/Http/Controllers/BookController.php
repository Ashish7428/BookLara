<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;  // Add this line
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $author = Auth::guard('author')->user();
        
        if (!$author) {
            return redirect()->route('author.login');
        }
        
        $books = Book::where('author_id', $author->id)
                     ->with('categories')  // Load the many-to-many relationship
                     ->latest()
                     ->get();
                     
        return view('author.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('author.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'pdf_file' => 'required|mimes:pdf|max:20480'
        ]);
    
        try {
            $book = new Book();
            $book->author_id = auth('author')->id();
            $book->title = $validatedData['title'];
            $book->slug = Str::slug($validatedData['title']);
            $book->description = $validatedData['description'];
            $book->category_id = $request->categories[0] ?? null;
            $book->publication_year = $validatedData['publication_year'];
            $book->status = 'pending';
    
            if ($request->hasFile('cover_image')) {
                $coverPath = 'covers/' . $request->file('cover_image')->hashName();
                $request->file('cover_image')->move(public_path('storage/covers'), $request->file('cover_image')->hashName());
                $book->setAttribute('cover_image', $coverPath);
            }
    
            if ($request->hasFile('pdf_file')) {
                $pdfPath = 'pdfs/' . $request->file('pdf_file')->hashName();
                $request->file('pdf_file')->move(public_path('storage/pdfs'), $request->file('pdf_file')->hashName());
                $book->pdf_path = $pdfPath;
            }
    
            $book->save();
            $book->categories()->sync($request->categories);
    
            return redirect()->route('author.books.index')
                ->with('success', 'Book uploaded successfully!');
        } catch (\Exception $e) {
            Log::error('Book upload error: ' . $e->getMessage());
            return back()
                ->with('error', 'Failed to upload book. Please try again.')
                ->withInput();
        }
    }

    public function edit(Book $book)
    {
        if (auth('author')->id() !== $book->author_id) {
            abort(403);
        }
    
        $categories = Category::orderBy('name')->get();
        $selectedCategory = $book->category_id ?? null;  // Handle null case
        
        return view('author.books.edit', compact('book', 'categories', 'selectedCategory'));
    }

    public function update(Request $request, Book $book)
    {
        if (auth('author')->id() !== $book->author_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        try {
            // Check if title already exists for another book
            $existingBook = Book::where('slug', Str::slug($request->title))
                               ->where('id', '!=', $book->id)
                               ->first();
            
            if ($existingBook) {
                return back()
                    ->with('error', 'A book with this title already exists. Please use a different title.')
                    ->withInput();
            }

            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
                'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'cover_image' => 'nullable|image|mimes:jpeg,png|max:2048',
                'pdf_file' => 'nullable|mimes:pdf|max:20480'
            ]);

            // Ensure directories exist in public/storage
            $coverDir = public_path('storage/covers');
            $pdfDir = public_path('storage/pdfs');
            
            if (!file_exists($coverDir)) {
                mkdir($coverDir, 0777, true);
            }
            if (!file_exists($pdfDir)) {
                mkdir($pdfDir, 0777, true);
            }

            $book->title = $validatedData['title'];
            $book->slug = Str::slug($validatedData['title']);
            $book->description = $validatedData['description'];
            $book->category_id = $request->categories[0] ?? null;
            $book->publication_year = $validatedData['publication_year'];

            if ($request->hasFile('cover_image')) {
                try {
                    // Delete old cover if exists
                    if ($book->cover_image && file_exists(public_path('storage/' . $book->cover_image))) {
                        unlink(public_path('storage/' . $book->cover_image));
                    }
                    
                    $coverPath = 'covers/' . $request->file('cover_image')->hashName();
                    $request->file('cover_image')->move(public_path('storage/covers'), $request->file('cover_image')->hashName());
                    $book->cover_image = $coverPath;
                } catch (\Exception $e) {
                    throw new \Exception('Error processing cover image: ' . $e->getMessage());
                }
            }

            if ($request->hasFile('pdf_file')) {
                try {
                    // Delete old PDF if exists
                    if ($book->pdf_path && file_exists(public_path('storage/' . $book->pdf_path))) {
                        unlink(public_path('storage/' . $book->pdf_path));
                    }
                    
                    $pdfPath = 'pdfs/' . $request->file('pdf_file')->hashName();
                    $request->file('pdf_file')->move(public_path('storage/pdfs'), $request->file('pdf_file')->hashName());
                    $book->pdf_path = $pdfPath;
                } catch (\Exception $e) {
                    throw new \Exception('Error processing PDF file: ' . $e->getMessage());
                }
            }

            if (!$book->save()) {
                throw new \Exception('Failed to save book details to database');
            }

            if (!$book->categories()->sync($request->categories)) {
                throw new \Exception('Failed to update book categories');
            }

            return redirect()->route('author.books.index')
                ->with('success', 'Book updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Book update error: ' . $e->getMessage());
            
            // Convert technical errors to user-friendly messages
            $errorMessage = match(true) {
                str_contains($e->getMessage(), 'Duplicate entry') => 'A book with this title already exists.',
                str_contains($e->getMessage(), 'Failed to upload') => 'Failed to upload files. Please try again.',
                str_contains($e->getMessage(), 'Failed to create') => 'System storage error. Please contact support.',
                default => 'An error occurred while updating the book. Please try again.'
            };

            return back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    public function destroy(Book $book)
    {
        if (auth('author')->id() !== $book->author_id) {
            abort(403);
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->pdf_path) {
            Storage::disk('public')->delete($book->pdf_path);
        }

        $book->delete();

        return redirect()->route('author.books.index')
            ->with('success', 'Book deleted successfully.');
    }

    public function list()
    {
        $books = Book::with(['author', 'categories'])
                         ->where('status', 'approved')
                         ->latest()
                         ->paginate(12);
                             
        return view('books.index', compact('books'));
    }

    
}