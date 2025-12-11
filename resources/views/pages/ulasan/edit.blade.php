<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Ulasan Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/guest/img/favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/guest/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/css/style.css') }}" rel="stylesheet">

    <style>
        .preview-thumb {
            width: 120px;
            height: 80px;
            overflow: hidden;
            border-radius: 6px;
            margin-right: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .preview-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .navbar {
            background-color: #0e3350 !important;
            box-shadow: 0 6px 20px rgba(3,37,65,0.25);
        }
        .navbar .nav-link { color: white !important; }
        .navbar .nav-link.active { color: #ffb21a !important; }
    </style>
</head>

<body>

<!-- NAVBAR -->
@include('pages.layouts.navbar')

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">

            <h3 class="text-center mb-4 text-primary">Edit Ulasan Produk</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ================= FORM UPDATE ULASAN ================= -->
            <form action="{{ route('ulasan.update', $ulasan->ulasan_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- PILIH PRODUK -->
                <div class="mb-3">
                    <label class="form-label">Pilih Produk</label>
                    <select name="produk_id" class="form-select" required>
                        @foreach ($produk_id as $p)
                            <option value="{{ $p->produk_id }}"
                                {{ old('produk_id', $ulasan->produk_id) == $p->produk_id ? 'selected' : '' }}>
                                {{ $p->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PILIH WARGA -->
                <div class="mb-3">
                    <label class="form-label">Pilih Warga</label>
                    <select name="warga_id" class="form-select" required>
                        @foreach ($warga as $w)
                            <option value="{{ $w->warga_id }}"
                                {{ old('warga_id', $ulasan->warga_id) == $w->warga_id ? 'selected' : '' }}>
                                {{ $w->nama }} ({{ $w->no_ktp }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- RATING -->
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('rating', $ulasan->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} ⭐
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- KOMENTAR -->
                <div class="mb-3">
                    <label class="form-label">Komentar</label>
                    <textarea name="komentar" rows="4" class="form-control" required>{{ old('komentar', $ulasan->komentar) }}</textarea>
                </div>

                <div class="text-center mb-4">
                    <button class="btn btn-primary px-4">Update Ulasan</button>
                    <a href="{{ route('ulasan.index') }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>

            <hr>

            <!-- ================= FOTO LAMA ================= -->
            <h4 class="text-primary mb-3">Foto yang Sudah Diupload</h4>

            @if ($ulasanMedia->count() == 0)
                <p class="text-muted">Belum ada foto.</p>
            @endif

            <div class="row">
                @foreach ($ulasanMedia as $m)
                    <div class="col-md-3 mb-3 text-center">
                        <div class="preview-thumb mx-auto mb-2">
                            <img src="{{ asset('storage/media/ulasan_produk/' . $m->file_name) }}" alt="Foto">
                        </div>

                        <form action="{{ route('ulasan.media.destroy', $m->media_id) }}"
                            method="POST" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100">Hapus Foto</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <hr>

            <!-- ================= FORM UPLOAD FOTO BARU (ROUTE KHUSUS) ================= -->
            <h4 class="text-primary mb-3">Upload Foto Baru</h4>

            <form action="{{ route('ulasan.uploadFoto', $ulasan->ulasan_id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <input type="file" name="files[]" id="newImages" multiple accept="image/*" class="form-control">
                </div>

                <div id="previewNew" class="d-flex flex-wrap gap-2 mb-3"></div>

                <div class="text-center">
                    <button class="btn btn-success px-4">Upload Foto Baru</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newImages = document.getElementById('newImages');
    const previewNew = document.getElementById('previewNew');

    newImages.addEventListener('change', function() {
        previewNew.innerHTML = '';
        Array.from(newImages.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = 'preview-thumb';

                const img = document.createElement('img');
                img.src = e.target.result;

                wrapper.appendChild(img);
                previewNew.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>

</body>
</html>
