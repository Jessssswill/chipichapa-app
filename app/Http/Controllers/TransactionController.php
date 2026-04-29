<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // tambah barang ke keranjang
    public function tambahKeKeranjang(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect('/')->with('error', 'Barang tidak ditemukan!');
        }

        // cek stok dulu, kalo habis kasih tau user
        if ($product->stok <= 0) {
            return redirect('/')->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang.');
        }

        $jumlah = $request->jumlah ?? 1;

        // cek apakah stok cukup
        if ($product->stok < $jumlah) {
            return redirect('/')->with('error', 'Stok ' . $product->nama_barang . ' tidak mencukupi! Sisa stok: ' . $product->stok);
        }

        // cek apakah barang ini sudah ada di keranjang user
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $id)
                            ->first();

        if ($cartItem) {
            // kalo udah ada, tambahin jumlahnya aja
            $jumlahBaru = $cartItem->jumlah + $jumlah;

            // pastiin total jumlah di keranjang ga lebih dari stok
            if ($jumlahBaru > $product->stok) {
                return redirect('/')->with('error', 'Jumlah di keranjang melebihi stok yang tersedia!');
            }

            $cartItem->jumlah = $jumlahBaru;
            $cartItem->save();
        } else {
            // kalo belum ada, bikin baru
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'jumlah' => $jumlah,
            ]);
        }

        return redirect('/')->with('success', $product->nama_barang . ' berhasil ditambahkan ke keranjang!');
    }

    // tampilin halaman keranjang
    public function lihatKeranjang()
    {
        // ambil semua item di keranjang user yang lagi login
        $cartItems = CartItem::with('product.category')
                             ->where('user_id', Auth::id())
                             ->get();

        // hitung total harga semua barang di keranjang
        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $totalHarga += $item->product->harga * $item->jumlah;
        }

        return view('keranjang', compact('cartItems', 'totalHarga'));
    }

    // update jumlah barang di keranjang
    public function updateKeranjang(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        if (!$cartItem) {
            return redirect('/keranjang')->with('error', 'Item tidak ditemukan di keranjang!');
        }

        $jumlahBaru = $request->jumlah;

        // validasi jumlah
        if ($jumlahBaru < 1) {
            return redirect('/keranjang')->with('error', 'Jumlah minimal 1!');
        }

        // cek stok
        if ($jumlahBaru > $cartItem->product->stok) {
            return redirect('/keranjang')->with('error', 'Stok ' . $cartItem->product->nama_barang . ' tidak mencukupi!');
        }

        $cartItem->jumlah = $jumlahBaru;
        $cartItem->save();

        return redirect('/keranjang')->with('success', 'Jumlah berhasil diubah!');
    }

    // hapus barang dari keranjang
    public function hapusDariKeranjang($id)
    {
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect('/keranjang')->with('success', 'Barang dihapus dari keranjang!');
    }

    // proses checkout / bikin faktur
    public function checkout(Request $request)
    {
        // validasi alamat dan kode pos
        $request->validate([
            'alamat_pengiriman' => 'required|string|min:10|max:100',
            'kode_pos' => 'required|digits:5',
        ], [
            'alamat_pengiriman.min' => 'Alamat pengiriman minimal 10 huruf!',
            'alamat_pengiriman.max' => 'Alamat pengiriman maksimal 100 huruf!',
            'kode_pos.digits' => 'Kode pos harus 5 digit angka!',
        ]);

        // ambil semua item di keranjang user
        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        // cek keranjang kosong atau engga
        if ($cartItems->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong! Silakan tambahkan barang dulu.');
        }

        // validasi stok semua barang sebelum checkout
        foreach ($cartItems as $item) {
            if ($item->product->stok < $item->jumlah) {
                return redirect('/keranjang')->with('error', 'Stok ' . $item->product->nama_barang . ' tidak mencukupi! Sisa: ' . $item->product->stok);
            }
        }

        // hitung total harga semua barang
        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $totalHarga += $item->product->harga * $item->jumlah;
        }

        // generate nomor invoice otomatis
        // format: INV-20260429-0001
        $tanggal = date('Ymd');
        $lastInvoice = Invoice::whereDate('created_at', today())->count();
        $urutan = str_pad($lastInvoice + 1, 4, '0', STR_PAD_LEFT);
        $nomorInvoice = 'INV-' . $tanggal . '-' . $urutan;

        // bikin invoice baru
        $invoice = Invoice::create([
            'nomor_invoice' => $nomorInvoice,
            'user_id' => Auth::id(),
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'kode_pos' => $request->kode_pos,
            'total_harga' => $totalHarga,
        ]);

        // masukin detail barang ke invoice_items
        foreach ($cartItems as $item) {
            $subtotal = $item->product->harga * $item->jumlah;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item->product->id,
                'nama_barang' => $item->product->nama_barang,
                'harga_satuan' => $item->product->harga,
                'jumlah' => $item->jumlah,
                'subtotal' => $subtotal,
            ]);

            // kurangi stok barang
            $item->product->stok -= $item->jumlah;
            $item->product->save();
        }

        // kosongkan keranjang user setelah checkout
        CartItem::where('user_id', Auth::id())->delete();

        // tampilin halaman invoice / faktur
        $invoice = Invoice::with(['items', 'user'])->find($invoice->id);
        return view('invoice', compact('invoice'));
    }
}