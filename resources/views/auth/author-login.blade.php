@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white text-center py-3" >
                    <h4 class="mb-0"><i class="fas fa-feather-alt me-2"></i>Author Login</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('author.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn" style="background-color:#000000;color:white;">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Don't have an author account?</p>
                        <a href="{{ route('author.register') }}" class="btn btn-link">Sign up as Author</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .container{
        margin-bottom:18px;
    }
</style>