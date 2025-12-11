<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tambah Ulasan Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/guest/img/favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/guest/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/css/style.css') }}" rel="stylesheet">

    <style>
        .preview-thumb {
            width: 120px;
            height: 80px;
            overflow: hidden;
            border-radius: 6px;
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        .preview-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <style>
        .navbar {
            background-color: #0e3350 !important;
            box-shadow: 0 6px 20px rgba(3, 37, 65, 0.25);
        }

        .navbar .navbar-brand h1 {
            color: #ffb21a;
            margin: 0;
            font-weight: 700;
        }

        .navbar .nav-link {
            color: #fff !important;
        }

        .navbar .nav-link.active {
            color: #ffb21a !important;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
            <a href="{{ url('/') }}" class="navbar-brand p-0 d-flex align-items-center">
                <img src="{{ asset('assets/guest/img/favicon.jpg') }}" alt="Logo UMKM" style="height: 40px;" class="me-2">
                <h1 class="text-primary m-0">UMKM</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0 pe-4">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link">Home</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                    <a href="{{ route('warga.index') }}" class="nav-item nav-link">Warga</a>
                    <a href="{{ route('ulasan.index') }}" class="nav-item nav-link active">Ulasan</a>

                    @guest
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                    @endguest

                    @auth
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </div>

    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">
                <h3 class="text-center mb-4 text-primary">Tambah Ulasan Produk</h3>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('ulasan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- PRODUK -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select name="produk_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produk_id as $p)
                                <option value="{{ $p->produk_id }}" {{ old('produk_id') == $p->produk_id ? 'selected' : '' }}>
                                    {{ $p->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- WARGA -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Warga</label>
                        <select name="warga_id" class="form-select" required>
                            <option value="">-- Pilih Warga --</option>
                            @foreach ($warga_id as $w)
                                <option value="{{ $w->warga_id }}" {{ old('warga_id') == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- RATING -->
                    <div class="mb-3">
                        <label class="form-label">Rating (1–5)</label>
                        <select name="rating" class="form-select" required>
                            <option value="">-- Pilih Rating --</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} ⭐
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- KOMENTAR -->
                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea name="komentar" rows="4" class="form-control" required>{{ old('komentar') }}</textarea>
                    </div>

                    <!-- FOTO -->
                    <div class="mb-3">
                        <label class="form-label">Foto (boleh lebih dari 1)</label>
                        <input type="file" name="files[]" id="filesInputCreate" multiple accept="image/*" class="form-control">
                        <div id="previewCreate" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        <a href="{{ route('ulasan.index') }}" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const input = document.getElementById('filesInputCreate');
            const preview = document.getElementById('previewCreate');
            if (!input) return;
            input.addEventListener('change', function() {
                preview.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const fr = new FileReader();
                    fr.onload = e => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-thumb';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        wrapper.appendChild(img);
                        preview.appendChild(wrapper);
                    };
                    fr.readAsDataURL(file);
                });
            });
        })();
    </script>

</body>

</html>
