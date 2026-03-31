<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h1>Dashboard Admin - Daftar Barang</h1>
    
    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    <a href="/admin/tambah">
        <button style="margin-bottom: 15px; padding: 10px; background: blue; color: white;">+ Tambah Barang Baru</button>
    </a>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr style="background: #eee;">
            <th>Foto</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        
        @foreach($products as $p)
        <tr>
            <td><img src="{{ asset('storage/' . $p->foto) }}" width="80"></td>
            <td>{{$p->nama_barang}}</td>
            <td>Rp{{number_format($p->harga, 0, ',', '.')}}</td>
            <td>{{$p->stok}}</td>
            <td>
                <a href="/admin/edit/{{ $p->id }}">
                    <button style="color: white; background: orange; margin-bottom: 5px;">Edit</button>
                </a>
                <form action="/admin/hapus/{{ $p->id }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                    @csrf
                    <button type="submit" style="color: red;">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
    <br><hr><br>
    
    <h2>Riwayat Transaksi Masuk</h2>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr style="background: #d4edda;">
            <th>No. Struk</th>
            <th>Tanggal</th>
            <th>Nama Pembeli</th>
            <th>Barang dibeli</th>
            <th>Jumlah</th>
            <th>Total Pendapatan</th>
        </tr>
        
        @foreach($invoices as $i)
        <tr>
            <td>#INV-00{{ $i->id }}</td>
            <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $i->user->name }}</td> 
            <td>{{ $i->product->nama_barang }}</td>
            <td>{{ $i->jumlah }} pcs</td>
            <td style="color: green; font-weight: bold;">Rp {{ number_format($i->total_harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>