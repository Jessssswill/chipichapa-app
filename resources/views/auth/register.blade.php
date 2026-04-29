<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ChipiChapa Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }

        .register-card h2 {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .register-card .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .brand-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
        }

        .form-hint {
            font-size: 0.8rem;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="text-center">
            <div class="brand-icon">
                <i class="bi bi-bag-heart-fill"></i>
            </div>
            <h2>Daftar Akun</h2>
            <p class="subtitle">Buat akun baru untuk mulai belanja</p>
        </div>

        {{-- error validation --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                <small class="form-hint">Minimal 3 huruf, maksimal 40 huruf</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
                <small class="form-hint">Wajib menggunakan @gmail.com</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Handphone</label>
                <input type="text" name="nomor_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('nomor_hp') }}" required>
                <small class="form-hint">Harus diawali dengan 08</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                <small class="form-hint">Minimal 6 huruf, maksimal 12 huruf</small>
            </div>

            <button type="submit" class="btn btn-register text-white mt-2">
                <i class="bi bi-person-plus"></i> Submit Button
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted">Sudah punya akun?
                <a href="/login" style="color: #667eea; font-weight: 600; text-decoration: none;">Login di sini</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>