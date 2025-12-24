<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tambah Ulasan Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/guest/img/favicon.jpg') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">

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
            margin-right: 8px;
        }

        .preview-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="container-xxl p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3"
            style="background-color:#0e3350 !important; position:relative;">
            <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('assets/guest/img/logo/logo-umkm-vertikal.jpg') }}" style="height:40px;">
                <h1 class="text-primary m-0 ms-2">UMKM</h1>
            </a>

            <div class="collapse navbar-collapse">
                <div class="navbar-nav ms-auto">
                    <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                    <a href="{{ route('ulasan.index') }}" class="nav-link active">Ulasan</a>

                    @auth
                        <span class="nav-link text-warning">{{ auth()->user()->name }}</span>
                    @endauth
                </div>
            </div>
        </nav>
    </div>

    <!-- CONTENT -->
    <div class="container py-5">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">

                <h3 class="text-center text-primary mb-4">Tambah Ulasan Produk</h3>

                {{-- ERROR --}}
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

                    {{-- PRODUK --}}
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select name="produk_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produk as $p)
                                <option value="{{ $p->produk_id }}"
                                    {{ old('produk_id') == $p->produk_id ? 'selected' : '' }}>
                                    {{ $p->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- RATING --}}
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="">-- Pilih Rating --</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} ⭐
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- KOMENTAR --}}
                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea name="komentar" rows="4" class="form-control" required>{{ old('komentar') }}</textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" name="files[]" id="filesInputCreate" multiple accept="image/*"
                            class="form-control">
                        <div id="previewCreate" class="d-flex flex-wrap mt-2"></div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        <a href="{{ route('ulasan.index') }}" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
        document.getElementById('filesInputCreate').addEventListener('change', function() {
            const preview = document.getElementById('previewCreate');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'preview-thumb';
                    div.innerHTML = `<img src="${e.target.result}">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

</body>

</html>
