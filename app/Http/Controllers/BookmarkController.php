<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Request $request, $bookId)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json([
                'success' => true,
                'status' => 'removed',
                'message' => 'Bookmark removed successfully'
            ]);
        }

        Bookmark::create([
            'user_id' => auth()->id(),
            'book_id' => $bookId
        ]);

        return response()->json([
            'success' => true,
            'status' => 'added',
            'message' => 'Bookmark added successfully'
        ]);
    }
}
