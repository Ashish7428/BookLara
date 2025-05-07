@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mb-3">
                            <span class="initials">{{ substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) }}</span>
                        </div>
                        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-muted">Member since {{ $user->created_at->format('F Y') }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted">First Name</label>
                                <p class="h5">{{ $user->first_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted">Last Name</label>
                                <p class="h5">{{ $user->last_name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted">Email</label>
                                <p class="h5">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted">Age</label>
                                <p class="h5">{{ $user->age }} years</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="text-muted">Gender</label>
                                <p class="h5">{{ ucfirst($user->gender) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <a href="{{ route('profile.change-password') }}" class="btn btn-secondary">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background-color: #007bff;
    border-radius: 50%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.initials {
    font-size: 40px;
    color: white;
    font-weight: bold;
}

.info-group label {
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
}

.info-group p {
    margin-bottom: 0;
}
</style>
@endsection