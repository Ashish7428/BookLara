<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    public function dashboard()
    {
        $totalBooks = \App\Models\Book::count();
        $pendingBooks = \App\Models\Book::where('status', 'pending')->count();
        $totalAuthors = \App\Models\Author::count();
        
        return view('admin.dashboard', compact('totalBooks', 'pendingBooks', 'totalAuthors'));
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', 'Password confirmation does not match.')
                        ->with('closeModal', true);
        }
    
        $admin = Auth::guard('admin')->user();
    
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'The current password is incorrect.')
                        ->with('closeModal', true);
        }
    
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully')
            ->with('closeModal', true);
    }


    
}
