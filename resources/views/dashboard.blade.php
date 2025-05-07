@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x mb-3 text-primary"></i>
                    <h4>My Books</h4>
                    <p class="text-muted">Access your reading collection</p>
                    <a href="{{ url('/my-books') }}" class="btn btn-outline-primary">View Books</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-3x mb-3 text-primary"></i>
                    <h4>Browse</h4>
                    <p class="text-muted">Discover new books to read</p>
                    <a href="{{ url('/browse') }}" class="btn btn-outline-primary">Browse Books</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-bookmark fa-3x mb-3 text-primary"></i>
                    <h4>Reading List</h4>
                    <p class="text-muted">Manage your reading wishlist</p>
                    <a href="{{ url('/reading-list') }}" class="btn btn-outline-primary">View List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection