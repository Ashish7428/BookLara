@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4">Welcome, {{ $author->full_name }}!</h2>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <h2 class="card-text">{{ $totalBooks }}</h2>
                    <p class="mb-0">Published Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending Approval</h5>
                    <h2 class="card-text">{{ $pendingBooks }}</h2>
                    <p class="mb-0">Books in Review</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Views</h5>
                    <h2 class="card-text">{{ $totalViews }}</h2>
                    <p class="mb-0">Book Views</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('author.books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Upload New Book
                        </a>
                        <a href="{{ route('author.books.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-book me-2"></i>Manage Books
                        </a>
                        <a href="{{ route('author.profile') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Books -->
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recently Uploaded Books</h5>
                    <a href="{{ route('author.books.index') }}" class="btn btn-link">View All</a>
                </div>
                <div class="card-body">
                    @if($totalBooks > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Uploaded Date</th>
                                        <th>Views</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">Book list will be implemented later</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="mb-0">You haven't uploaded any books yet.</p>
                            <a href="{{ route('author.books.create') }}" class="btn btn-primary mt-3">
                                Upload Your First Book
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div> -->

    <!-- After the stats cards -->
    <!-- Remove the old "Recently Uploaded Books" section -->
    
    <!-- Update the "Your Recent Books" header -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Your Recent Books</h5>
                    <a href="{{ route('author.books.index') }}" class="btn btn-link">View All</a>
                </div>
                <div class="card-body">
                    <!-- Rest of the table remains the same -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    {{-- <th>Category</th>  <!-- Change from Genre to Category --> --}}
                                    <th>Status</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBooks as $book)
                                    <tr>
                                        <td>
                                            @if($book->cover_image)
                                                <img src="{{ $book->cover_image }}" 
                                                    alt="Cover" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-book fa-2x text-muted"></i>
                                            @endif
                                        </td>
                                        <td>{{ $book->title }}</td>
                                        {{-- <td>
                                            @if($book->category)
                                                <span class="badge bg-secondary me-1">{{ $book->category->name }}</span>
                                            @else
                                                <span class="text-muted">No category</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $book->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('author.books.edit', $book) }}" 
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ Storage::url($book->pdf_path) }}" 
                                                    class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-book fa-2x mb-3 text-muted d-block"></i>
                                            <p class="mb-0">You haven't uploaded any books yet.</p>
                                            <a href="{{ route('author.books.create') }}" class="btn btn-primary mt-3">
                                                <i class="fas fa-plus me-2"></i>Upload Your First Book
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection