
@extends('layouts.app')

@section('content')
<div class="container py-4 custom-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header  d-flex justify-content-between align-items-center custom-heading">
                    <h4 class="mb-0">Edit Profile</h4>
                    <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left "></i> Back to Profile
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                        id="first_name" name="first_name" placeholder="First Name"
                                        value="{{ old('first_name', $user->first_name) }}">
                                    <label for="first_name">First Name</label>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                        id="last_name" name="last_name" placeholder="Last Name"
                                        value="{{ old('last_name', $user->last_name) }}">
                                    <label for="last_name">Last Name</label>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                        id="age" name="age" placeholder="Age"
                                        value="{{ old('age', $user->age) }}">
                                    <label for="age">Age</label>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" aria-label="Gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="gender">Gender</label>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .custom-heading {
        background-color: #000000;       
        color: white;
    }
    .custom-i:hover {
        color: rgb(0, 0, 0);
        background-color: white;
    }
    .custom-container{
        margin-bottom: 194px;
    }
    </style>
@endsection