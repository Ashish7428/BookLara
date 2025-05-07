@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Available Books</h1>

    <div class="row g-4">
        @forelse($books as $book)
            <div class="col-md-3">
                <x-book-card :book="$book" />
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No books available at the moment.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        <nav aria-label="Page navigation">
            {{ $books->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</div>

@push('styles')
<style>
    .pagination {
        justify-content: center;
    }
    .page-link {
        color: #000000;
        padding: 0.5rem 1rem;
    }
    .page-item.active .page-link {
        background-color: #000000;
        border-color: #999999;
    }
</style>
@endpush
@endsection