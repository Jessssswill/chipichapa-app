@extends('layouts.app')

@section('title', 'Keranjang Belanja - ChipiChapa Store')

@section('styles')
<style>
    .cart-header {
        margin-bottom: 25px;
    }

    .cart-header h2 {
        font-weight: 700;
        color: #1f2937;
    }

    /* tabel keranjang */
    .cart-table {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .cart-table thead {
        background-color: #f8fafc;
    }

    .cart-table thead th {
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        padding: 14px 16px;
    }

    .cart-table td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    .cart-table .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-table .product-name {
        font-weight: 600;
        color: #1f2937;
    }

    .cart-table .product-category {
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* qty input di keranjang */
    .qty-input-cart {
        width: 70px;
        text-align: center;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 6px;
    }

    /* summary card */
    .summary-card {
        background: white;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        position: sticky;
        top: 90px;
    }

    .summary-card h5 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .summary-card .total-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2563eb;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-hapus {
        border: none;
        background: none;
        color: #ef4444;
        font-size: 1.1rem;
        transition: color 0.2s;
        cursor: pointer;
    }

    .btn-hapus:hover {
        color: #dc2626;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 10px 14px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }
</style>
@endsection

@section('content')

    <div class="cart-header">
        <h2><i class="bi bi-cart3"></i> Keranjang Belanja</h2>
        <p class="text-muted">Cek dulu pesanan kamu sebelum checkout</p>
    </div>

    @if($cartItems->isEmpty())
        {{-- keranjang kosong --}}
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 5rem; color: #d1d5db;"></i>
            <h4 class="text-muted mt-3">Keranjang kamu masih kosong</h4>
            <p class="text-muted">Yuk mulai belanja!</p>
            <a href="/" class="btn btn-primary mt-2" style="border-radius: 10px; padding: 10px 25px;">
                <i class="bi bi-grid"></i> Lihat Katalog
            </a>
        </div>
    @else
        <div class="row g-4">
            {{-- kolom kiri: daftar barang --}}
            <div class="col-lg-8">
                <div class="cart-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('storage/' . $item->product->foto) }}" class="product-img" alt="">
                                            <div>
                                                <div class="product-name">{{ $item->product->nama_barang }}</div>
                                                @if($item->product->category)
                                                    <div class="product-category">{{ $item->product->category->nama_kategori }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp. {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                                    <td>
                                        {{-- form update jumlah --}}
                                        <form action="/keranjang/update/{{ $item->id }}" method="POST" class="d-flex align-items-center gap-1">
                                            @csrf
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->product->stok }}" class="qty-input-cart" required>
                                            <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">
                                        Rp. {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{-- tombol hapus --}}
                                        <form action="/keranjang/hapus/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini dari keranjang?')">
                                            @csrf
                                            <button type="submit" class="btn-hapus" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="/" class="btn btn-outline-secondary mt-3" style="border-radius: 8px;">
                    <i class="bi bi-arrow-left"></i> Lanjut Belanja
                </a>
            </div>

            {{-- kolom kanan: ringkasan & form checkout --}}
            <div class="col-lg-4">
                <div class="summary-card">
                    <h5><i class="bi bi-receipt"></i> Ringkasan Pesanan</h5>

                    {{-- daftar subtotal --}}
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted" style="font-size: 0.9rem;">{{ $item->product->nama_barang }} x{{ $item->jumlah }}</span>
                            <span style="font-size: 0.9rem;">Rp. {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="total-price">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>

                    {{-- form checkout --}}
                    <form action="/checkout" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Alamat Pengiriman</label>
                            <textarea name="alamat_pengiriman" class="form-control" rows="3" placeholder="Masukkan alamat lengkap pengiriman..." required>{{ old('alamat_pengiriman') }}</textarea>
                            <small class="text-muted">Minimal 10 huruf, maksimal 100 huruf</small>
                            @error('alamat_pengiriman')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" placeholder="Contoh: 12345" maxlength="5" value="{{ old('kode_pos') }}" required>
                            <small class="text-muted">Harus 5 digit angka</small>
                            @error('kode_pos')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-checkout text-white" onclick="return confirm('Yakin checkout? Pesanan akan diproses.')">
                            <i class="bi bi-bag-check"></i> Checkout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection
