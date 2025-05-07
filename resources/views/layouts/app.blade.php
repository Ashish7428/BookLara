<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-auth" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>Book Reader - Your Digital Reading Companion</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-custom {
            background-color: #000000;
        }
        
            .navbar-logo {
                object-fit: contain;
                border-radius: 4px;
                display: inline-block;
                vertical-align: middle;
            }
        
        .footer {
            background-color: #000000;
            color: white;
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
            
        }
        .main-content {
            padding-bottom: 2rem;
        }
        
    </style>
    @stack('styles')
</head>
    <body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
            <div class="container">
                <div class="d-flex align-items-center me-4">
                    <img src="{{asset('images/logo.jpg')}}" alt="Book Reader Logo" class="navbar-logo me-2" height="40" 
                         onclick="window.location.href='{{ Auth::check() ? route('user.dashboard') : url('/') }}'" 
                         style="cursor: pointer;">
                    <a class="navbar-brand mb-0" href="{{ Auth::check() ? route('user.dashboard') : url('/') }}">Book Reader</a>
                </div>
                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Search Bar -->
                   

                    <!-- Navigation Links -->
                    <ul class="navbar-nav ms-auto">

                      
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/mybooks') }}">My Books</a>
                        </li> --}}

                        <!-- Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @else
        <!-- Original navbar for guests -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
            <div class="container">
                <div class="d-flex align-items-center me-4">
                    <img src="{{asset('images/logo.jpg')}}" alt="Book Reader Logo" class="navbar-logo me-2" height="40">
                    <a class="navbar-brand mb-0" href="{{ url('/') }}">Book Reader</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/books') }}">Books</a>
                        </li>
                        
                    </ul>
                                        <!-- Add search form if on welcome page -->
                                        @if(Request::is('/'))
                                        <form class="d-flex mx-auto" style="min-width: 300px; max-width: 500px;" action="{{ url('/') }}" method="GET">
                                            <div class="input-group">
                                                <input class="form-control" type="search" name="search" placeholder="Search books, authors..." value="{{ request('search') }}">
                                                <button class="btn btn-outline-light" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                    <!-- Rest of the navbar content -->
                    <div class="navbar-nav">
                        @auth
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light me-2">Logout</button>
                            </form>
                        @else
                            {{-- <a href="{{ route('admin.login.form') }}" class="btn btn-outline-light me-2">Admin</a> --}}
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light me-2">Sign Up</a>
                            <a href="{{ route('author.login') }}" class="btn btn-light">
                                <i class="fas fa-feather-alt me-1"></i>Author
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <div class="container main-content">
        @yield('content')
    </div>

    <footer class="footer ">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Book Reader</h5>
                    <p class="mb-0">Your digital gateway to endless knowledge.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} Book Reader. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>