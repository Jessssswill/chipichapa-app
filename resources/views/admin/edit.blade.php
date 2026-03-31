<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
</head>
<body style="font-family: Arial; padding: 50px;">

    <h2>Form Edit Barang</h2>

    <form action="/admin/edit/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Nama Produk:</label><br>
        <input type="text" name="nama_barang" value="{{$product->nama_barang}}" required><br><br>

        <label>Harga (Angka saja):</label><br>
        <input type="number" name="harga" value="{{ $product->harga }}" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" value="{{ $product->stok }}" required><br><br>

        <label>Upload Foto Baru (Biarkan kosong jika tidak ingin ganti foto):</label><br>
        <input type="file" name="foto" accept="image/*"><br><br>

        <button type="submit" style="padding: 10px; background: orange; color: white;">Update Barang</button>
    </form>

    <br>
    <a href="/admin/dashboard">Batal dan Kembali</a>

</body>
</html>