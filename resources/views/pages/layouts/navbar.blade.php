<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand p-0 d-flex align-items-center">
            <img src="{{ asset('assets/guest/img/favicon.jpg') }}" alt="Logo UMKM"
                 style="height: 40px; width: auto;" class="me-2">
            <h1 class="text-primary m-0">UMKM</h1>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('warga.index') }}" class="nav-item nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">Warga</a>
                <a href="{{ route('ulasan.index') }}" class="nav-item nav-link {{ request()->routeIs('ulasan.*') ? 'active' : '' }}">Ulasan</a>

                @guest
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                @endguest

                @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{ auth()->user()->name ?? auth()->user()->email }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <a href="https://wa.me/6281234567890?text=Halo%20saya%20mau%20bertanya%20tentang%20UMKM"
                   target="_blank" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>
</div>
