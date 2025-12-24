<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UMKM Guest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-box {
            background: #ffffff10;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            background: #ffffff20;
            color: #fff;
            border: none;
        }

        .form-control:focus {
            background: #ffffff30;
            color: #fff;
            border-color: #38bdf8;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
        }

        .btn-custom {
            background-color: #38bdf8;
            color: #fff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0ea5e9;
        }

        a {
            color: #38bdf8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <h3 class="text-center mb-4">Daftar Akun</h3>

        {{-- Pesan sukses / error --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>

            <div class="form-group mb-4">
                <label>Daftar sebagai</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="warga">Warga</option>
                    <option value="umkm">UMKM</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Daftar
            </button>

            <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </form>
    </div>
</body>

</html>
