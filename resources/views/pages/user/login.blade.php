<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - UMKM Guest</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="{{ asset('assets/guest/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

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
    <div class="container-xxl position-relative p-0">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
            <a href="{{ route('dashboard') }}" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>UMKM</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
        </nav>
        <!-- Navbar End -->

        <!-- Hero Header Start -->
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5 text-center">
                <h1 class="display-4 text-white mb-3 animated slideInDown">Login</h1>
                <p class="text-white-50">Silakan masuk untuk mengelola data UMKM</p>
            </div>
        </div>
        <!-- Hero Header End -->
    </div>

    <!-- Login Form Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-5">
                            <h4 class="text-center mb-4 text-primary">Login ke Akun Anda</h4>

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('login.process') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email Anda" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary py-2">Login</button>
                                </div>
                                <div class="text-center">
                                    <p class="small mb-0">Belum punya akun? <a href="{{ url('/register') }}" class="text-primary">Daftar sekarang</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} UMKM Guest. All rights reserved.</p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/guest/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/guest/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/guest/js/main.js') }}"></script>
</body>

</html>
