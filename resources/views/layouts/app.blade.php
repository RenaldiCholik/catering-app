<!DOCTYPE html>
<html>
<head>
    <title>KateringApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
        <a class="navbar-brand" href="{{ url('/') }}">Katering App</a>
    
        <div class="ms-auto d-flex align-items-center">
            @auth
                <a href="{{ route('orders.index') }}" class="btn btn-light me-2">Pesanan Masuk</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            @endauth
    
            @guest
    <a href="{{ route('landing') }}" class="btn btn-outline-light me-2">Kembali ke Menu</a>
    <a href="{{ route('login') }}" class="btn btn-outline-light">Login Admin</a>
@endguest

        </div>
    </nav>
    
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center mt-4 mb-3 text-muted">
        © {{ date('Y') }} KateringApp. Dibuat oleh Renaldi Cholik.
    </footer>
</body>
</html>
