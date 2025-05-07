<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
// use App\Http\Controllers\Author\BookController;  // Updated namespace
use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Http\Controllers\Admin\AuthorManagementController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    $search = request('search');
    $query = Book::where('status', 'approved');
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('author', function($q) use ($search) {
                  $q->where('full_name', 'like', "%{$search}%");
              });
        });
    }
    
    $books = $query->latest()->take(8)->get();
    return view('welcome', compact('books', 'search'));
});

// Authentication Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register']);

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
// Update the admin login route
Route::get('/admin', function () {
    return view('auth.admin-login');
})->name('admin.login.form');  // This matches the route name used in navbar

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Add these routes with your other authenticated routes
Route::middleware('auth')->group(function () {
    Route::middleware(['auth'])->group(function () {
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-`password`', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    });
   
});

// Add user dashboard route
Route::middleware(['auth'])->group(function () {
    // Remove all duplicate middleware groups and keep only one set of user routes
    Route::middleware(['auth'])->group(function () {
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
        // Dashboard
        Route::middleware(['auth'])->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
        });
        
        // Books - Make sure these routes are in the correct order
        Route::get('/books/browse', [App\Http\Controllers\User\BookController::class, 'browse'])->name('books.browse');
        Route::get('/books/{book}/read', [App\Http\Controllers\User\BookController::class, 'read'])->name('books.read');
        Route::get('/books/{book}/page/{page}', [App\Http\Controllers\User\BookController::class, 'getPage'])->name('books.page');
        Route::get('/books/{book}', [App\Http\Controllers\User\BookController::class, 'show'])->name('books.show');
        Route::post('/books/{book}/save-progress', [App\Http\Controllers\User\BookController::class, 'saveProgress']);
    });
});

// Author Routes
Route::middleware('auth:author')->group(function () {
    Route::get('/author/dashboard', [AuthorController::class, 'dashboard'])->name('author.dashboard');
    Route::post('/author/logout', [AuthorController::class, 'logout'])->name('author.logout');
    Route::get('/author/profile', [AuthorController::class, 'profile'])->name('author.profile');
    Route::get('/author/profile/edit', [AuthorController::class, 'edit'])->name('author.profile.edit');
    Route::put('/author/profile', [AuthorController::class, 'update'])->name('author.profile.update');
    Route::get('/author/profile/change-password', [AuthorController::class, 'changePassword'])->name('author.profile.change-password');
    Route::put('/author/profile/change-password', [AuthorController::class, 'updatePassword'])->name('author.profile.update-password');
    
    // Book routes with updated controller
     // Update this line
    
    // In your routes
    Route::resource('author/books', BookController::class, ['as' => 'author']);
});
Route::get('/author/login', function () {
    return view('auth.author-login');
})->name('author.login');

Route::post('/author/login', [AuthorController::class, 'login'])->name('author.login.submit');
Route::get('/author/register', function () {
    return view('auth.author-register');
})->name('author.register');

Route::post('/author/register', [AuthorController::class, 'register'])->name('author.register.submit');

// Admin Routes
use App\Http\Controllers\Admin\BookManagementController;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/author', [AuthorManagementController::class, 'index'])->name('admin.author');
    Route::get('/admin/books', [BookManagementController::class, 'index'])->name('admin.books.index');
    Route::post('/admin/books/{book}/approve', [BookManagementController::class, 'approve'])->name('admin.books.approve');
    Route::post('/admin/books/{book}/reject', [BookManagementController::class, 'reject'])->name('admin.books.reject');
    Route::resource('admin/categories', CategoryController::class)->except(['show', 'create', 'edit'])->names([
        'index' => 'admin.categories.index',
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::post('/admin/password/update', [AdminController::class, 'updatePassword'])->name('admin.password.update');
});
Auth::routes();
// Route::post('/bookmark/{book}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
Route::post('/bookmark/{book}', [BookmarkController::class, 'toggle'])
    ->middleware('auth')
    ->name('bookmark.toggle');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'list'])->name('books.index');


Route::get('/verify-otp', [OtpVerificationController::class, 'showForm'])->name('otp.form');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');

Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');