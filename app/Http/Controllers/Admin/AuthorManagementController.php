<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;


class AuthorManagementController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Build the query to fetch authors
        $query = Author::query();

        // If a search term exists, filter by name or email
        if ($search) {
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Fetch the authors (You can use paginate() if you need pagination)
        $authors = $query->get();

        return view('admin.author', compact('authors'));
    }


}
