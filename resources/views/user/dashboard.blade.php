@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-book-reader fa-2x text-primary mb-2"></i>
                    <h3 class="h2 mb-0">{{ $currentlyReading ?? 0 }}</h3>
                    <p class="text-muted">Currently Reading</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="h2 mb-0">{{ $completedBooks }}</h3>
                    <p class="text-muted">Books Completed</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x text-danger mb-2"></i>
                    <h3 class="h2 mb-0">{{ $reviewsCount }}</h3>
                    <p class="text-muted">Reviews Written</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Library Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>My Library</h3>
                <div>
                    <a href="{{ route('books.browse') }}" class="btn btn-outline-primary">Browse More</a>
                </div>
            </div>
            <hr>
            <div class="row" id="booksContainer">
                @forelse($myBooks as $book)
                <div class="col-md-3 mb-3 book-item {{ $loop->index >= 4 ? 'd-none' : '' }}">
                    <div class="card h-100 border-0 shadow-sm book-card">
                        <img src="{{ asset($book->book->cover_image ?? 'images/default-book-cover.jpg') }}" 
                             class="card-img-top" 
                             alt="{{ $book->book->title ?? 'Book Cover' }}"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->book->title ?? 'Untitled' }}</h5>
                            <p class="card-text text-muted">By {{ $book->book->author->full_name ?? 'Unknown Author' }}</p>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $book->progress }}%"
                                     aria-valuenow="{{ $book->progress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $book->progress }}% completed</small>
                                <span class="badge bg-{{ $book->status === 'completed' ? 'success' : ($book->status === 'in_progress' ? 'primary' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $book->status)) }}
                                </span>
                            </div>
                            <a href="{{ route('books.read', $book->book_id) }}" 
                               class="btn btn-primary btn-sm w-100 mt-3">
                                {{ $book->status === 'completed' ? 'Read Again' : 'Continue Reading' }}
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-books fa-3x text-muted mb-3"></i>
                            <h4>Your library is empty</h4>
                            <p class="text-muted">Start your reading journey by adding some books!</p>
                            <a href="{{ route('books.browse') }}" class="btn btn-primary mt-2">
                                Browse Books
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Trending Books -->
    <div class="row mb-4">
        <div class="col-12">
            <h3>Trending Now</h3>
            <hr>
            @if(isset($trendingBooks) && count($trendingBooks) > 0)
                <div class="row">
                    @foreach($trendingBooks as $book)
                        <div class="col-md-3 mb-4">
                            @include('components.book-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <p class="text-muted">No trending books available at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

  
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<style>
    .book-card {
        transition: transform 0.3s ease;
    }
    .book-card:hover {
        transform: translateY(-5px);
    }
    .category-card {
        transition: all 0.3s ease;
    }
    .category-card:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
    }
    .progress-circle {
        width: 150px;
        height: 150px;
        position: relative;
        /* Add more styling for circular progress */
    }
</style>
@endpush


@endsection
