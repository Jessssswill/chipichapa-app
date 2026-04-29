@extends('layouts.app')

@section('title', 'Edit Barang - ChipiChapa Store')

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
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .btn-update {
        background-color: #f59e0b;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-update:hover {
        background-color: #d97706;
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

    .current-foto {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
    }

    .foto-preview-new {
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
        <h3><i class="bi bi-pencil-square"></i> Edit Barang</h3>
        <p class="subtitle">Ubah informasi barang "{{ $product->nama_barang }}"</p>

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

        <form action="/admin/edit/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kategori Barang</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $product->category_id == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ $product->nama_barang }}" required>
                <small class="form-hint">Minimal 5 huruf, maksimal 80 huruf</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Barang (Rp)</label>
                <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Saat Ini</label><br>
                @if($product->foto)
                    <img src="{{ asset('storage/' . $product->foto) }}" class="current-foto" alt="Foto saat ini">
                @else
                    <p class="text-muted">Belum ada foto</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*" id="inputFotoBaru">
                <small class="form-hint">Biarkan kosong jika tidak ingin ganti foto</small>
                <img id="previewFotoBaru" class="foto-preview-new" alt="Preview">
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-update text-white">
                    <i class="bi bi-check-circle"></i> Update Barang
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
    // preview foto baru sebelum upload
    document.getElementById('inputFotoBaru').addEventListener('change', function(e) {
        var preview = document.getElementById('previewFotoBaru');
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