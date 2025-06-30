@extends('layouts.app')

@section('content')
<div class="container py-5 custom-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card shadow">
                <div style="background-color:#000000;" class="card-header  text-white" >
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remove the remember me checkbox section -->

                        <div class="mb-0">
                            <button type="submit" class="btn btn-custom" style="background-color:#000000;color:white;">Login</button> <br>
                            <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Passsword?</a><br>
                            <a href="{{ route('register') }}" class="btn btn-link">Need an account?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* .btn-custom {
        background-color: #2c3e50;
        color: white;
    } */
     .custom-container{
        margin-bottom: 70px;
     }
</style>