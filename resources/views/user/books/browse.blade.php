@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Browse Books</h2>
            <p class="text-muted">Discover your next favorite book</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filters</h5>
                    <form action="{{ route('books.browse') }}" method="GET">
                        <!-- Add search input -->
                        <div class="mb-3">
                            <label class="form-label">Search Books</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by title or author..." 
                                   value="{{ request('search') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn w-100 btn-custom" >Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="col-md-9">
            <div class="row">
                @forelse($books as $book)
                    <div class="col-md-4 mb-4">
                        @include('components.book-card', ['book' => $book])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No books available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted mb-0">
                        Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }} of {{ $books->total() }} books
                    </p>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $books->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .book-card {
        transition: transform 0.3s ease;
    }
    .book-card:hover {
        transform: translateY(-5px);
    }

    .btn-custom{
        color: white;
        border: none;
        background-color: #000000;
    }
    .btn-custom:hover{
        color: rgb(0, 0, 0);
        background-color: #fffcfc;
        border: 1px solid #000000;
    }
</style>
@endpush
@endsection