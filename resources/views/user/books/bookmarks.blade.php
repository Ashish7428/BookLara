@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">My Bookmarked Books</h2>
    <hr>
    @if($bookmarks->count() > 0)
        <div class="row">
            @foreach($bookmarks as $bookmark)
                <div class="col-md-3 mb-4">
                    @include('components.book-card', ['book' => $bookmark->book])
                </div>
            @endforeach
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-bookmark fa-3x text-muted mb-3"></i>
                <h4>No Bookmarked Books</h4>
                <p class="text-muted">You haven't bookmarked any books yet.</p>
                <a href="{{ route('books.browse') }}" class="btn btn-primary mt-2">
                    Browse Books
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
