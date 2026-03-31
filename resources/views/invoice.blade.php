<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembelian</title>
    <style>
        .nota {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 2px dashed #333;
            font-family: 'Courier New', Courier, monospace;
            background-color: #fcfcfc;
        }
        .garis { border-bottom: 1px dashed #333; margin: 10px 0; }
    </style>
</head>
<body>

    <div class="nota">
        <h2 style="text-align: center; margin: 0;">TOKO CHIPICHAPA</h2>
        <p style="text-align: center; margin: 5px 0;">Struk Pembelian Resmi</p>
        <div class="garis"></div>
        
        <p><strong>No. Invoice :</strong> #INV-00{{ $invoice->id }}</p>
        <p><strong>Tanggal     :</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
        
        <div class="garis"></div>
        
        <p><strong>Barang      :</strong> {{ $product->nama_barang }}</p>
        <p><strong>Harga Satuan:</strong> Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        <p><strong>Jumlah Beli :</strong> {{ $invoice->jumlah }} pcs</p>
        
        <div class="garis"></div>
        
        <h3 style="text-align: right;">TOTAL: Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</h3>
        
        <div class="garis"></div>
        <p style="text-align: center;">Terima kasih telah berbelanja!</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/" style="text-decoration: none; background: #333; color: white; padding: 5px 10px; border-radius: 3px;">Kembali ke Katalog</a>
        </div>
    </div>

</body>
</html>