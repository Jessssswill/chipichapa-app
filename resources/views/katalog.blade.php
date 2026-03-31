<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog ChipiChapa</title>
    <style>
        .card { 
            border: 1px solid #ccc; 
            border-radius: 8px;
            padding: 15px; 
            margin: 10px; 
            width: 200px; 
            display: inline-block; 
            text-align: center; 
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; padding: 30px;">

    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
        <h1>🛒 Toko ChipiChapa</h1>
        
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Logout</button>
        </form>
    </div>

    @if(session('error'))
        <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
    @endif

    <div>
        @foreach($products as $p)
        <div class="card">
            <img src="{{ asset('storage/' . $p->foto) }}" width="150" height="150" style="object-fit: cover; border-radius: 5px;">
            
            <h3>{{ $p->nama_barang }}</h3>
            <p style="color: #28a745; font-weight: bold; font-size: 18px;">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
            <p style="color: gray; font-size: 14px;">Stok Tersedia: {{ $p->stok }}</p>
            
            <form action="/beli/{{ $p->id }}" method="POST">
                @csrf
                <input type="number" name="jumlah" value="1" min="1" max="{{ $p->stok }}" required style="width: 50px; margin-bottom: 10px; padding: 5px;">
                <button type="submit" style="background: #007bff; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor: pointer;">
                    Beli Sekarang
                </button>
            </form>
        </div>
        @endforeach
    </div>

</body>
</html>