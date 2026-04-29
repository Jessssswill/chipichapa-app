<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - ChipiChapa Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            padding: 30px 15px;
        }

        .invoice-container {
            max-width: 650px;
            margin: 0 auto;
        }

        /* header sukses */
        .success-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .success-icon {
            font-size: 4rem;
            color: #22c55e;
        }

        .success-header h3 {
            font-weight: 700;
            color: #1f2937;
            margin-top: 10px;
        }

        /* struk invoice */
        .invoice-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .invoice-header h4 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .invoice-body {
            padding: 30px;
        }

        /* info baris */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            text-align: right;
        }

        /* tabel item */
        .items-table {
            width: 100%;
            margin: 20px 0;
        }

        .items-table thead {
            background-color: #f8fafc;
        }

        .items-table th {
            padding: 10px 12px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .items-table td {
            padding: 12px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        /* total */
        .total-section {
            background: #f8fafc;
            padding: 20px 30px;
            border-top: 2px solid #e5e7eb;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2563eb;
        }

        /* footer invoice */
        .invoice-footer {
            text-align: center;
            padding: 20px 30px;
            background: #fafafa;
            border-top: 1px dashed #e5e7eb;
        }

        .invoice-footer p {
            color: #9ca3af;
            margin-bottom: 0;
        }

        .btn-kembali {
            background-color: #2563eb;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-kembali:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-print {
            background-color: #6b7280;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-print:hover {
            background-color: #4b5563;
        }

        /* sembunyiin tombol pas print */
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .invoice-card { box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        {{-- header sukses --}}
        <div class="success-header no-print">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3>Pembelian Berhasil!</h3>
            <p class="text-muted">Berikut adalah faktur pembelian kamu</p>
        </div>

        {{-- struk invoice --}}
        <div class="invoice-card">
            <div class="invoice-header">
                <h4><i class="bi bi-bag-heart-fill"></i> TOKO CHIPICHAPA</h4>
                <p class="mb-0" style="opacity: 0.9;">Struk Pembelian Resmi</p>
            </div>

            <div class="invoice-body">
                {{-- info invoice --}}
                <div class="info-row">
                    <span class="info-label">No. Invoice</span>
                    <span class="info-value">{{ $invoice->nomor_invoice }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value">{{ $invoice->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pembeli</span>
                    <span class="info-value">{{ $invoice->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat Pengiriman</span>
                    <span class="info-value" style="max-width: 60%;">{{ $invoice->alamat_pengiriman }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Pos</span>
                    <span class="info-value">{{ $invoice->kode_pos }}</span>
                </div>

                <hr>

                {{-- tabel barang yang dibeli --}}
                <h6 class="fw-bold mb-2"><i class="bi bi-box-seam"></i> Detail Barang</h6>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->nama_barang }}</td>
                                <td class="text-center">x{{ $item->jumlah }}</td>
                                <td class="text-end">Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- total harga --}}
            <div class="total-section">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="font-size: 1.1rem;">TOTAL HARGA</span>
                    <span class="total-amount">Rp. {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- footer --}}
            <div class="invoice-footer">
                <p><i class="bi bi-heart-fill" style="color: #ef4444;"></i> Terima kasih telah berbelanja di ChipiChapa!</p>
            </div>
        </div>

        {{-- tombol aksi --}}
        <div class="text-center mt-4 no-print">
            <a href="/" class="btn btn-kembali text-white me-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Katalog
            </a>
            <button onclick="window.print()" class="btn btn-print text-white">
                <i class="bi bi-printer"></i> Cetak Faktur
            </button>
        </div>
    </div>

</body>
</html>