@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Author Management</h5>
                <div class="search-container">
                    <form action="{{ route('admin.author') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($authors->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-users fa-2x mb-3 text-muted d-block"></i>
                    No authors found
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" id="authorsTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Bio</th>
                                <th>Social Links</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td class="fw-bold">{{ $author->full_name }}</td>
                                <td>{{ $author->email }}</td>
                                <td>{{ Str::limit($author->bio, 100) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($author->facebook_url)
                                            <a href="{{ $author->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if($author->twitter_url)
                                            <a href="{{ $author->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if($author->instagram_url)
                                            <a href="{{ $author->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if($author->linkedin_url)
                                            <a href="{{ $author->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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



    .table th {
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    .search-container {
        width: 300px;
    }
    #searchInput {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 4px;
        padding: 0.5rem 1rem;
    }
    #searchInput:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
    }
</style>
@endpush





@endsection
