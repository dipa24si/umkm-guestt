<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UMKM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/guest/img/favicon.jpg') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/guest/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/guest/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/guest/css/style.css') }}" rel="stylesheet">
</head>

<body>
    {{-- <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End --> --}}


    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
            <a href="{{ url('/') }}" class="navbar-brand p-0 d-flex align-items-center">
                <img src="{{ asset('assets/guest/img/logo/logo-umkm-vertikal.jpg') }}" alt="Logo UMKM" class="mb-2"
                    style="max-height:40px;">
                <h1 class="text-primary m-0">UMKM</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0 pe-4">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}"
                        class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                    <a href="{{ route('warga.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Warga</a>
                    <a href="{{ url('/ulasan') }}"
                        class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Ulasan</a>
                    {{-- Kalau BELUM login: tampilkan Login & Register sebagai menu biasa --}}
                    @guest
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                    @endguest

                    {{-- Kalau SUDAH login: tampilkan nama user sebagai dropdown --}}
                    @auth
                        <div class="nav-item dropdown user-dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
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
                        target="_blank" class="nav-item nav-link">
                        Contact
                    </a>
                </div>
            </div>
        </nav>

        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">
                            Dukung UMKM<br>Lokal Indonesia
                        </h1>

                        <p class="text-white animated slideInLeft mb-4 pb-2">
                            Temukan data warga pelaku UMKM serta berbagai produk lokal yang dapat Anda beli untuk
                            mendukung ekonomi masyarakat.
                        </p>

                        <div class="d-flex flex-wrap">
                            <a href="{{ route('warga.index') }}"
                                class="btn btn-primary py-sm-3 px-sm-5 me-3 mb-2 animated slideInLeft">
                                LIHAT WARGA UMKM
                            </a>

                            <a href="{{ route('ulasan.index') }}"
                                class="btn btn-primary py-sm-3 px-sm-5 mb-2 animated slideInLeft">
                                LIHAT PRODUK & ULASAN
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        <img class="img-fluid" src="{{ asset('assets/guest/img/hero.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Warga Section Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Data Warga</h5>
                <h1 class="mb-5">Daftar Warga Terdaftar</h1>
            </div>

            {{-- FORM FILTER + SEARCH --}}
            <form method="GET" action="{{ route('warga.index') }}" class="row justify-content-center mb-4 g-2">
                {{-- FILTER JENIS KELAMIN --}}
                <div class="col-md-3">
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Semua Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>

                {{-- SEARCH NAMA / NO KTP --}}
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari nama atau No. KTP..." value="{{ request('search') }}">
                </div>

                {{-- TOMBOL FILTER / SEARCH --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-warning text-white fw-bold">
                        FILTER & SEARCH
                    </button>
                </div>

                {{-- RESET --}}
                <div class="col-md-2 d-grid">
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                        RESET
                    </a>
                </div>
            </form>

            <div class="row g-4 mt-4">

                @forelse ($warga as $item)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                        <div class="card shadow-sm border-0 rounded-4 h-100">
                            <div class="card-body text-center p-4 d-flex flex-column align-items-center">

                                {{-- FOTO --}}
                                <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/guest/img/placeholder.png') }}"
                                    class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">

                                {{-- NAMA --}}
                                <h5 class="fw-bold mb-1">{{ $item->nama }}</h5>

                                {{-- INFO --}}
                                <p class="text-muted small mb-1">
                                    No. KTP: {{ $item->no_ktp }}
                                </p>

                                <p class="text-muted small mb-1">
                                    {{ $item->jenis_kelamin }} - {{ $item->agama }}
                                </p>

                                <p class="text-muted small mb-3">
                                    {{ $item->pekerjaan }}
                                </p>

                                {{-- KONTAK --}}
                                @if ($item->email)
                                    <p class="small mb-1">
                                        <i class="fa fa-envelope me-1"></i>{{ $item->email }}
                                    </p>
                                @endif

                                @if ($item->telp)
                                    <p class="small mb-3">
                                        <i class="fa fa-phone me-1"></i>{{ $item->telp }}
                                    </p>
                                @endif

                                {{-- BUTTON --}}
                                <div class="mt-auto w-100">
                                    @auth
                                        <a href="{{ route('warga.edit', $item->warga_id) }}"
                                            class="btn btn-warning btn-sm w-100 mb-2">
                                            EDIT
                                        </a>

                                        <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm w-100">
                                                HAPUS
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">
                            Belum ada data warga yang ditambahkan.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $warga->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <!-- Warga Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Company</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Reservation</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Opening</h4>
                    <h5 class="text-light fw-normal">Monday - Saturday</h5>
                    <p>09AM - 09PM</p>
                    <h5 class="text-light fw-normal">Sunday</h5>
                    <p>10AM - 08PM</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Your email">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com"
                            target="_blank">ThemeWagon</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('assets/guest/https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/guest/https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('assets/guest/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('assets/guest/js/main.js') }}"></script>

    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/6281234567890?text=Halo%20saya%20mau%20bertanya%20tentang%20UMKM" target="_blank"
        aria-label="Chat via WhatsApp"
        style="
       position: fixed;
       bottom: 25px;
       left: 25px;
       width: 65px;
       height: 65px;
       background: #25D366;
       color: #fff;
       border-radius: 50%;
       display: flex;
       align-items: center;
       justify-content: center;
       font-size: 32px;
       z-index: 99999;
       box-shadow: 0 0 15px rgba(0,0,0,.3);
   ">
        <i class="fab fa-whatsapp"></i>
    </a>
</body>

</html>
