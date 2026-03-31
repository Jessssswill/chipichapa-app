<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
</head>
<body style="font-family: Arial; padding: 50px;">

    <h2>Form Tambah Barang</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <form action="/admin/tambah" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Kategori:</label><br>
        <select name="category_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->nama_kategori }}</option>
            @endforeach
        </select><br><br>

        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" required><br><br>

        <label>Harga (Angka saja):</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <label>Upload Foto Barang:</label><br>
        <input type="file" name="foto" required accept="image/*"><br><br>

        <button type="submit" style="padding: 10px; background: green; color: white;">Simpan Barang</button>
    </form>

    <br>
    <a href="/admin/dashboard">Kembali ke Dashboard</a>

</body>
</html>