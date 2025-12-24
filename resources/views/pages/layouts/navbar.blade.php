<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ route('dashboard') }}" class="navbar-brand p-0 d-flex align-items-center">
            <img src="{{ asset('assets/guest/img/logo/logo-umkm-vertikal.jpg') }}" alt="Logo UMKM" class="mb-2"
                style="max-height:40px;">
            <span class="text-primary fw-bold">UMKM Lokal</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">

                {{-- HOME --}}
                <a href="{{ route('dashboard') }}"
                    class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Home
                </a>

                {{-- ABOUT --}}
                <a href="{{ route('about') }}"
                    class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    About
                </a>

                {{-- WARGA (INI YANG PENTING) --}}
                <a href="{{ route('warga.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                    Warga
                </a>

                {{-- ULASAN --}}
                <a href="{{ route('ulasan.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('ulasan.*') ? 'active' : '' }}">
                    Ulasan
                </a>

                {{-- GUEST --}}
                @guest
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                @endguest

                {{-- AUTH --}}
                @auth

                    {{-- ROLE WARGA --}}
                    @if (auth()->user()->role === 'warga')
                        <a href="{{ route('ulasan.create') }}" class="nav-item nav-link">
                            Tulis Ulasan
                        </a>
                    @endif

                    {{-- ROLE UMKM --}}
                    @if (auth()->user()->role === 'umkm')
                        <a href="{{ route('produk.create') }}" class="nav-item nav-link">
                            Tambah Produk
                        </a>
                    @endif

                    {{-- ROLE ADMIN --}}
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('warga.index') }}" class="nav-item nav-link">
                            Kelola Warga
                        </a>
                    @endif

                    {{-- USER DROPDOWN --}}
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

                {{-- CONTACT --}}
                <a href="https://wa.me/6281234567890?text=Halo%20saya%20mau%20bertanya%20tentang%20UMKM" target="_blank"
                    class="nav-item nav-link">
                    Contact
                </a>

            </div>
        </div>
    </nav>
</div>
