@extends('layouts.app')

@section('title', 'Dashboard Admin - ChipiChapa Store')

@section('styles')
<style>
    .dashboard-header {
        margin-bottom: 25px;
    }

    .dashboard-header h2 {
        font-weight: 700;
        color: #1f2937;
    }

    /* stats card */
    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
    }

    .stat-card .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-card .stat-label {
        color: #6b7280;
        font-size: 0.85rem;
    }

    /* tabel */
    .table-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .table-card .table {
        margin-bottom: 0;
    }

    .table-card thead {
        background-color: #f8fafc;
    }

    .table-card thead th {
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        padding: 14px 16px;
        font-size: 0.9rem;
    }

    .table-card td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* tombol aksi */
    .btn-edit {
        background-color: #f59e0b;
        border: none;
        color: white;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-edit:hover {
        background-color: #d97706;
        color: white;
    }

    .btn-hapus {
        background: none;
        border: 1px solid #ef4444;
        color: #ef4444;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-hapus:hover {
        background-color: #ef4444;
        color: white;
    }

    .btn-tambah {
        background-color: #22c55e;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-tambah:hover {
        background-color: #16a34a;
        transform: translateY(-1px);
    }

    /* badge section */
    .section-title {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 15px;
        margin-top: 35px;
    }
</style>
@endsection

@section('content')

    <div class="dashboard-header">
        <h2><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
        <p class="text-muted">Kelola semua barang dan lihat transaksi masuk</p>
    </div>

    {{-- Statistik singkat --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #2563eb;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $products->count() }}</div>
                    <div class="stat-label">Total Barang</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #22c55e;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $invoices->count() }}</div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #f59e0b;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    @php
                        $totalPendapatan = $invoices->sum('total_harga');
                    @endphp
                    <div class="stat-number">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Barang --}}
    <a href="/admin/tambah" class="btn btn-tambah text-white mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Barang Baru
    </a>

    {{-- Tabel Daftar Barang --}}
    <h5 class="section-title"><i class="bi bi-box-seam"></i> Daftar Barang</h5>
    <div class="table-card mb-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $p->foto) }}" class="product-img" alt="">
                        </td>
                        <td class="fw-bold">{{ $p->nama_barang }}</td>
                        <td>
                            @if($p->category)
                                <span class="badge bg-primary bg-opacity-10 text-primary" style="border-radius: 6px;">
                                    {{ $p->category->nama_kategori }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>Rp. {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($p->stok > 0)
                                <span class="text-success fw-bold">{{ $p->stok }}</span>
                            @else
                                <span class="text-danger fw-bold">Habis</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/edit/{{ $p->id }}" class="btn btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="/admin/hapus/{{ $p->id }}" method="POST" onsubmit="return confirm('Yakin mau hapus barang ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-hapus">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox"></i> Belum ada barang. Yuk tambahkan!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tabel Riwayat Transaksi --}}
    <h5 class="section-title"><i class="bi bi-clock-history"></i> Riwayat Transaksi Masuk</h5>
    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Barang Dibeli</th>
                    <th>Alamat</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $i)
                    <tr>
                        <td class="fw-bold">{{ $i->nomor_invoice }}</td>
                        <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $i->user->name ?? '-' }}</td>
                        <td>
                            @foreach($i->items as $item)
                                <span>{{ $item->nama_barang }} x{{ $item->jumlah }}</span><br>
                            @endforeach
                        </td>
                        <td style="max-width: 150px; font-size: 0.85rem;">
                            {{ $i->alamat_pengiriman }}<br>
                            <small class="text-muted">Kode Pos: {{ $i->kode_pos }}</small>
                        </td>
                        <td class="fw-bold text-success">
                            Rp. {{ number_format($i->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-clock"></i> Belum ada transaksi masuk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection