<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $author = Auth::guard('author')->user();
        
        if (!$author) {
            return redirect()->route('author.login');
        }
        
        $books = Book::where('author_id', $author->id)
                     ->with('category')  // Load the category relationship
                     ->latest()
                     ->get();
                     
        $categories = Category::all();  // Get all categories for the view
        
        return view('author.books.index', compact('books', 'categories'));
    }
}