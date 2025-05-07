@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h2>
        <div class="text-muted">Welcome, Admin!</div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">Total Books</h5>
                            <p class="display-4 mb-0">{{ $totalBooks }}</p>
                        </div>
                        <div class="rounded-circle bg-white p-3">
                            <i class="fas fa-books fa-2x text-primary"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0">
                        <i class="fas fa-chart-line me-2"></i>All books in system
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">Pending Books</h5>
                            <p class="display-4 mb-0">{{ $pendingBooks }}</p>
                        </div>
                        <div class="rounded-circle bg-white p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>Awaiting approval
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">Total Authors</h5>
                            <p class="display-4 mb-0">{{ $totalAuthors }}</p>
                        </div>
                        <div class="rounded-circle bg-white p-3">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                    <p class="mt-3 mb-0">
                        <i class="fas fa-user-pen me-2"></i>Registered authors
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Books</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Book::with('author')->latest()->take(5)->get() as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author->full_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $book->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Book Status Distribution</h6>
                        <div class="progress" style="height: 25px;">
                            @php
                                $approved = \App\Models\Book::where('status', 'approved')->count();
                                $rejected = \App\Models\Book::where('status', 'rejected')->count();
                                $total = $totalBooks > 0 ? $totalBooks : 1;
                                $approvedPercent = ($approved / $total) * 100;
                                $rejectedPercent = ($rejected / $total) * 100;
                                $pendingPercent = 100 - $approvedPercent - $rejectedPercent;
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $approvedPercent }}%" 
                                title="Approved: {{ $approved }}">{{ round($approvedPercent) }}%</div>
                            <div class="progress-bar bg-danger" style="width: {{ $rejectedPercent }}%" 
                                title="Rejected: {{ $rejected }}">{{ round($rejectedPercent) }}%</div>
                            <div class="progress-bar bg-warning" style="width: {{ $pendingPercent }}%" 
                                title="Pending: {{ $pendingBooks }}">{{ round($pendingPercent) }}%</div>
                        </div>
                    </div>
                    <div class="list-group">
                        <a href="{{ route('admin.books.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-book me-2"></i>Manage Books</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        {{-- <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i>Manage Authors</span>
                            <i class="fas fa-chevron-right"></i>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .progress {
        border-radius: 15px;
    }
    .progress-bar {
        transition: width 1s ease-in-out;
    }
</style>
@endpush
@endsection