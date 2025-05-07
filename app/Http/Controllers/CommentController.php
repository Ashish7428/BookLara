<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Book;
use Illuminate\Http\Request;
use voku\helper\ASCII;

class CommentController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
