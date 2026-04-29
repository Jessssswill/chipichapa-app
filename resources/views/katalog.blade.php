@extends('layouts.app')

@section('title', 'Katalog Barang - ChipiChapa Store')

@section('styles')
<style>
    /* hero section di atas katalog */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
    }

    .hero-section h1 {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .hero-section p {
        opacity: 0.9;
        font-size: 1.05rem;
    }

    /* card produk */
    .product-card {
        border-radius: 14px;
        overflow: hidden;
        background: white;
        height: 100%;
    }

    .product-card .card-img-top {
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .product-card .img-wrapper {
        overflow: hidden;
        position: relative;
    }

    /* badge kategori di atas foto */
    .category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(37, 99, 235, 0.9);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    /* badge habis */
    .sold-out-badge {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }

    .sold-out-badge span {
        background: #ef4444;
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* harga styling */
    .product-price {
        color: #2563eb;
        font-weight: 700;
        font-size: 1.2rem;
    }

    /* stok */
    .stock-info {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .stock-info.low {
        color: #f59e0b;
    }

    .stock-info.empty {
        color: #ef4444;
        font-weight: 600;
    }

    /* tombol tambah keranjang */
    .btn-add-cart {
        background-color: #2563eb;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-add-cart:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-add-cart:disabled {
        background-color: #9ca3af;
        cursor: not-allowed;
    }

    /* input jumlah */
    .qty-input {
        width: 65px;
        text-align: center;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .qty-input:focus {
        border-color: #2563eb;
        box-shadow: none;
    }
</style>
@endsection

@section('content')

    <!-- Hero Section -->
    <div class="hero-section">
        <h1><i class="bi bi-shop"></i> Selamat Datang di ChipiChapa Store!</h1>
        <p>Temukan berbagai barang pilihan dengan harga terbaik. Yuk belanja sekarang!</p>
    </div>

    <!-- Daftar Produk -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card">
                    {{-- gambar produk --}}
                    <div class="img-wrapper">
                        {{-- badge kategori --}}
                        @if($product->category)
                            <span class="category-badge">{{ $product->category->nama_kategori }}</span>
                        @endif

                        {{-- kalo stok habis, kasih overlay --}}
                        @if($product->stok <= 0)
                            <div class="sold-out-badge">
                                <span><i class="bi bi-x-circle"></i> STOK HABIS</span>
                            </div>
                        @endif

                        <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top" alt="{{ $product->nama_barang }}">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold mb-1">{{ $product->nama_barang }}</h6>

                        <p class="product-price mb-1">
                            Rp. {{ number_format($product->harga, 0, ',', '.') }}
                        </p>

                        {{-- info stok --}}
                        @if($product->stok > 10)
                            <p class="stock-info mb-3">
                                <i class="bi bi-box-seam"></i> Stok: {{ $product->stok }}
                            </p>
                        @elseif($product->stok > 0)
                            <p class="stock-info low mb-3">
                                <i class="bi bi-exclamation-triangle"></i> Sisa {{ $product->stok }} lagi!
                            </p>
                        @else
                            <p class="stock-info empty mb-3">
                                <i class="bi bi-x-circle"></i> Barang sudah habis
                            </p>
                        @endif

                        {{-- form tambah ke keranjang --}}
                        <div class="mt-auto">
                            @auth
                                @if($product->stok > 0)
                                    <form action="/keranjang/tambah/{{ $product->id }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        <input type="number" name="jumlah" value="1" min="1" max="{{ $product->stok }}" class="form-control qty-input" required>
                                        <button type="submit" class="btn btn-add-cart text-white flex-grow-1">
                                            <i class="bi bi-cart-plus"></i> Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-add-cart text-white w-100" disabled>
                                        <i class="bi bi-cart-x"></i> Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="/login" class="btn btn-outline-primary w-100" style="border-radius: 8px;">
                                    <i class="bi bi-box-arrow-in-right"></i> Login untuk Beli
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
                    <h5 class="text-muted mt-3">Belum ada barang</h5>
                    <p class="text-muted">Tunggu admin menambahkan barang ya!</p>
                </div>
            </div>
        @endforelse
    </div>

@endsection