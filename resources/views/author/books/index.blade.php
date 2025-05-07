@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Books</h2>
        <a href="{{ route('author.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Upload New Book
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($book->cover_image ?? 'images/default-book-cover.jpg') }}" 
                         class="card-img-top"
                         alt="{{ $book->title }}"
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text text-muted mb-2">
                            @forelse($book->categories as $category)
                                <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                            @empty
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-circle me-1"></i>No Category
                                </span>
                            @endforelse
                        </p>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($book->status) }}
                            </span>
                            <small class="text-muted">{{ $book->publication_year }}</small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex gap-2">
                            <a href="{{ route('author.books.edit', $book) }}" class="btn btn-outline-primary flex-grow-1 d-flex align-items-center justify-content-center">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('author.books.destroy', $book) }}" method="POST" class="flex-grow-1 m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-books fa-3x text-muted mb-3"></i>
                    <p class="h5 text-muted">You haven't uploaded any books yet.</p>
                    <a href="{{ route('author.books.create') }}" class="btn btn-primary mt-3">
                        Upload Your First Book
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

{{-- Remove this entire section as it's causing the unwanted text --}}