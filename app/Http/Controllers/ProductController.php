<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Invoice;

class ProductController extends Controller
{
    // tampilin daftar barang di Dashboard Admin
    public function index()
    {
        // ambil semua produk beserta kategorinya
        $products = Product::with('category')->get();

        // ambil semua invoice beserta detail items, user, dll
        $invoices = Invoice::with(['user', 'items'])->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('products', 'invoices'));
    }

    // tampilin form tambah barang
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    // proses simpan barang baru ke database
    public function store(Request $request)
    {
        // validasi input sesuai requirement dari pak raja
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|min:5|max:80',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama_barang.min' => 'Nama barang minimal 5 huruf!',
            'nama_barang.max' => 'Nama barang maksimal 80 huruf!',
            'foto.max' => 'Ukuran foto maksimal 2MB!',
            'foto.image' => 'File harus berupa gambar!',
        ]);

        // upload foto ke folder storage/app/public/foto_barang
        $fotoPath = $request->file('foto')->store('foto_barang', 'public');

        // simpan data barang ke database
        Product::create([
            'category_id' => $request->category_id,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath
        ]);

        return redirect('/admin/dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    // hapus barang dari database
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect('/admin/dashboard')->with('error', 'Barang tidak ditemukan!');
        }

        $product->delete();
        return redirect('/admin/dashboard')->with('success', 'Barang berhasil dihapus!');
    }

    // tampilin form edit barang
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        if (!$product) {
            return redirect('/admin/dashboard')->with('error', 'Barang tidak ditemukan!');
        }

        return view('admin.edit', compact('product', 'categories'));
    }

    // proses update barang
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect('/admin/dashboard')->with('error', 'Barang tidak ditemukan!');
        }

        // validasi input
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|min:5|max:80',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // update data barang
        $product->category_id = $request->category_id;
        $product->nama_barang = $request->nama_barang;
        $product->harga = $request->harga;
        $product->stok = $request->stok;

        // kalo ada foto baru, upload dan ganti
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $product->foto = $fotoPath;
        }

        $product->save();

        return redirect('/admin/dashboard')->with('success', 'Barang berhasil diubah!');
    }

    // tampilin halaman katalog buat user biasa
    public function katalog()
    {
        // ambil semua produk beserta kategorinya
        $products = Product::with('category')->get();
        return view('katalog', compact('products'));
    }
}