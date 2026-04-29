@extends('layouts.app')

@section('title', 'Tambah Barang - ChipiChapa Store')

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 14px;
        padding: 35px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card h3 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .form-card .subtitle {
        color: #6b7280;
        margin-bottom: 25px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        transition: border-color 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .btn-simpan {
        background-color: #22c55e;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-simpan:hover {
        background-color: #16a34a;
        transform: translateY(-1px);
    }

    .btn-batal {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: #6b7280;
        background: white;
        transition: all 0.2s;
    }

    .btn-batal:hover {
        border-color: #9ca3af;
        color: #374151;
    }

    /* preview foto */
    .foto-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        margin-top: 10px;
        display: none;
    }
</style>
@endsection

@section('content')

    <div class="form-card">
        <h3><i class="bi bi-plus-circle"></i> Tambah Barang Baru</h3>
        <p class="subtitle">Isi form di bawah untuk menambahkan barang ke katalog</p>

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

        <form action="/admin/tambah" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kategori Barang</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" value="{{ old('nama_barang') }}" required>
                <small class="form-hint">Minimal 5 huruf, maksimal 80 huruf</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Barang (Rp)</label>
                <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000" value="{{ old('harga') }}" min="0" required>
                <small class="form-hint">Masukkan angka saja tanpa titik</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="Contoh: 100" value="{{ old('stok') }}" min="0" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Foto Barang</label>
                <input type="file" name="foto" class="form-control" accept="image/*" id="inputFoto" required>
                <small class="form-hint">Format: JPG, PNG. Maksimal 2MB</small>
                {{-- preview foto --}}
                <img id="previewFoto" class="foto-preview" alt="Preview">
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-simpan text-white">
                    <i class="bi bi-check-circle"></i> Simpan Barang
                </button>
                <a href="/admin/dashboard" class="btn btn-batal">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script>
    // preview foto sebelum upload
    document.getElementById('inputFoto').addEventListener('change', function(e) {
        var preview = document.getElementById('previewFoto');
        var file = e.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection