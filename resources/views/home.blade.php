@extends('layouts.app')

@section('content')
<div class="container custom-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Continue Browsing</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .custom-container {
        margin-top: 100px;
        margin-bottom: 320px;
    }
</style>
