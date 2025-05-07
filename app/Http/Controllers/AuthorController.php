<?php

namespace App\Http\Controllers;

use App\Models\Book;  // Update this import
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'username' => 'required|string|max:255|unique:authors',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $author = Author::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username, 
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('author.login')
            ->with('success', 'Registration successful! Please login with your credentials.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('author')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/author/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('author')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    // Remove the first dashboard method and keep only this one
    public function dashboard()
    {
        $author = Auth::guard('author')->user();
        
        if (!$author) {
            return redirect()->route('author.login');
        }
        
        $books = Book::where('author_id', $author->id)
                 ->with('category')  // Make sure we're using 'category' not 'genres'
                 ->latest()
                 ->get();
        
        $totalBooks = $books->count();
        $publishedBooks = $books->where('status', 'approved')->count();
        $pendingBooks = $books->where('status', 'pending')->count();
        $totalViews = $books->sum('views');
        $recentBooks = $books->take(5);
        
        return view('author.dashboard', compact(
            'books',
            'totalBooks',
            'publishedBooks',
            'pendingBooks',
            'totalViews',
            'recentBooks',
            'author'
        ));
    }

    public function profile()
    {
        $author = Auth::guard('author')->user();
        return view('author.profile.show', compact('author'));
    }

    public function edit()
    {
        $author = Auth::guard('author')->user();
        return view('author.profile.edit', compact('author'));
    }

    public function update(Request $request)
    {
        $author = Auth::guard('author')->user();
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            // username validation removed
            'bio' => 'nullable|string|max:1000',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $updateData = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                // username removed from update data
                'bio' => $request->bio,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'instagram_url' => $request->instagram_url,
                'linkedin_url' => $request->linkedin_url,
            ];

            // Debug the update data
            Log::info('Update Data:', $updateData);

            $updated = Author::where('id', $author->id)->update($updateData);
            
            // Debug the result
            Log::info('Update Result:', ['success' => $updated]);

            if (!$updated) {
                return back()->with('error', 'Failed to update profile.');
            }

            return redirect()->route('author.profile')
                ->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile Update Error:', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while updating profile: ' . $e->getMessage());
        }
    }

    public function changePassword()
    {
        return view('author.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $author = Auth::guard('author')->user();
    
        if (!Hash::check($request->current_password, $author->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        Author::where('id', $author->id)->update([
            'password' => Hash::make($request->password)
        ]);
    
        return redirect()->route('author.profile')
            ->with('success', 'Password changed successfully.');
    }

    public function index()
    {
        $author = Auth::guard('author')->user();
        
        if (!$author) {
            return redirect()->route('author.login');
        }
        
        $books = Book::where('author_id', $author->id)
                     ->with('category')
                     ->latest()
                     ->get() ?? collect();
        
        return view('author.books.index', compact('books'));
    }
}
