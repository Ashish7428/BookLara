@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $book->title }}</h2>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Author:</div>
                        <div class="col-md-9">{{ $book->author->full_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Genre:</div>
                        <div class="col-md-9">{{ $book->genre }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Publication Year:</div>
                        <div class="col-md-9">{{ $book->publication_year }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $book->status === 'approved' ? 'success' : ($book->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Description:</div>
                        <div class="col-md-9">{{ $book->description }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">PDF File:</div>
                        <div class="col-md-9">
                            <a href="{{ Storage::url($book->pdf_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-file-pdf me-2"></i>View PDF
                            </a>
                        </div>
                    </div>

                    @if($book->status === 'pending')
                    <hr>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.books.approve', $book) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Approve Book
                            </button>
                        </form>
                        <form action="{{ route('admin.books.reject', $book) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Reject Book
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cover Image</h5>
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" 
                            alt="Book cover" class="img-fluid rounded">
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-book fa-4x mb-3"></i>
                            <p>No cover image available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection