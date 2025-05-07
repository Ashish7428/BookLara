@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-books me-2"></i>Book Management</h5>
                <div class="search-container">
                    <form action="{{ route('admin.books.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by title or author..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" id="booksTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Uploaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($book->cover_image)
                                            <img src="{{ asset($book->cover_image ?? 'images/default-book-cover.jpeg') }}" 
                                                alt="Cover" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @endif
                                        {{ $book->title }}
                                    </div>
                                </td>
                                <td>{{ $book->author->full_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($book->status) }}
                                    </span>
                                </td>
                                <td>{{ $book->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ Storage::url($book->pdf_path) }}" 
                                            class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @if($book->status === 'pending')
                                            <form action="{{ route('admin.books.approve', $book) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.books.reject', $book) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-books fa-2x mb-3 text-muted d-block"></i>
                                    No books found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .search-container {
        width: 400px;
    }
    .search-container form {
        width: 100%;
    }
    .search-container .form-control {
        flex: 1;
    }
</style>
@endpush
@push('scripts')
<script>

    // Confirm before rejecting
    document.querySelectorAll('form[action*="reject"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to reject this book?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection