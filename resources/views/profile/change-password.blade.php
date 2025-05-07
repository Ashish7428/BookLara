@extends('layouts.app')

@section('content')
<div class="container py-4 custom-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Change Password</h4>
                    <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Profile
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update-password') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" placeholder="Current Password">
                            <label for="current_password">Current Password</label>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                id="new_password" name="new_password" placeholder="New Password">
                            <label for="new_password">New Password</label>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .custom-container {
        margin-bottom: 144px;
    }
</style>
@endsection