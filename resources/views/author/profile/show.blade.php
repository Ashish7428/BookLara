@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Author Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Full Name:</div>
                        <div class="col-md-8">{{ $author->full_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $author->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phone:</div>
                        <div class="col-md-8">{{ $author->phone }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Username:</div>
                        <div class="col-md-8">{{ $author->username }}</div>
                    </div>

                    @if($author->bio)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Bio:</div>
                        <div class="col-md-8">{{ $author->bio }}</div>
                    </div>
                    @endif

                    @if($author->facebook_url || $author->twitter_url || $author->instagram_url || $author->linkedin_url)
                        <hr class="my-4">
                        <h5 class="mb-3">Social Media Links</h5>
                        
                        <div class="d-flex gap-3">
                            @if($author->facebook_url)
                                <a href="{{ $author->facebook_url }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            @endif
                            
                            @if($author->twitter_url)
                                <a href="{{ $author->twitter_url }}" target="_blank" class="btn btn-outline-info">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            
                            @if($author->instagram_url)
                                <a href="{{ $author->instagram_url }}" target="_blank" class="btn btn-outline-danger">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            
                            @if($author->linkedin_url)
                                <a href="{{ $author->linkedin_url }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('author.profile.edit') }}" class="btn btn-dark me-2">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('author.profile.change-password') }}" class="btn btn-light">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection