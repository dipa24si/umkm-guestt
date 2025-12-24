<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UMKM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
                        class="nav-item nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">Warga</a>

                    <a href="{{ route('ulasan.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('ulasan.*') ? 'active' : '' }}">Ulasan</a>

                    @guest
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                    @endguest

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

    <!-- Ulasan Produk Section Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Ulasan Produk</h5>
                <h1 class="mb-5">Daftar Ulasan Produk</h1>
            </div>

            <div class="text-center mb-4">
                {{-- TOMBOL TAMBAH ULASAN --}}
                @if (\Illuminate\Support\Facades\Auth::check())
                    <div class="text-center mb-4">
                        <a href="{{ url('/ulasan/create') }}" class="btn btn-success">
                            <i class="fa fa-plus me-1"></i> Tambah Ulasan
                        </a>
                    </div>
                @else
                    <div class="text-center mb-4">
                        <p class="text-muted">
                            Login terlebih dahulu untuk menulis ulasan
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Login
                        </a>
                    </div>
                @endif
            </div>

            <div class="row g-4">
                @forelse ($ulasan as $item)
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body p-4">

                                <!-- optional thumbnails (up to 3) -->
                                @php
                                    // if controller eager-loaded medias -> use $item->medias
                                    $medias = $item->medias ?? collect();
                                @endphp

                                @if ($medias->count())
                                    <div class="d-flex justify-content-center gap-2 mb-3">
                                        @foreach ($medias->take(3) as $m)
                                            <img src="{{ asset('storage/media/ulasan_produk/' . $m->file_name) }}"
                                                alt="{{ $m->caption ?? '' }}"
                                                style="width:60px; height:45px; object-fit:cover; border-radius:6px;">
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Icon -->
                                <div class="text-center mb-3">
                                    <i class="fa fa-star fa-3x text-warning"></i>
                                </div>

                                <!-- Produk -->
                                <h5 class="card-title text-center mb-2">
                                    {{ $item->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}
                                </h5>

                                <!-- Rating bintang -->
                                <p class="text-center mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fa fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </p>

                                <!-- Komentar -->
                                <p class="small text-muted mb-2">"{{ $item->komentar }}"</p>

                                <!-- Nama warga -->
                                <p class="small text-muted">
                                    <i class="fa fa-user me-1"></i>
                                    {{ $item->warga->nama ?? 'Anonim' }}
                                </p>

                                <!-- Tombol aksi -->
                                <div class="text-center">
                                    @auth
                                        @if (auth()->user()->role === 'warga' && auth()->user()->id == $item->warga_id)
                                            <a href="{{ route('ulasan.edit', $item->ulasan_id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>

                                            <form action="{{ route('ulasan.destroy', $item->ulasan_id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada ulasan produk yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            @if ($ulasan instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4 text-center">
                    <div class="text-muted small mb-2">
                        Showing {{ $ulasan->firstItem() }} to {{ $ulasan->lastItem() }} of {{ $ulasan->total() }}
                        results
                    </div>
                    <div class="d-inline-block">
                        {{ $ulasan->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Ulasan Produk Section End -->

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
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/guest/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

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
