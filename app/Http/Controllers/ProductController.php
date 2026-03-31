<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // show daftar barang di Dashboard Admin
    public function index() {
        $products = Product::all();
        $invoices = \App\Models\Invoice::with(['user', 'product'])->get();
        return view('admin.dashboard', compact('products', 'invoices'));
    }

    //buat show form tambah barang
    public function create() {
        $categories = \App\Models\Category::all(); 
        return view('admin.create', compact('categories'));
    }

    //Proses nyimpan barang + Upload Foto ke database
    public function store(Request $request) {
        $request->validate([
            'category_id' => 'required', 
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = $request->file('foto')->store('foto_barang', 'public');

        Product::create([
            'category_id' => $request->category_id,
            'nama_barang' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath
        ]);

        return redirect('/admin/dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    //buat delete barang
    public function destroy($id) {
        Product::find($id)->delete();
        return redirect('/admin/dashboard')->with('success', 'Barang berhasil dihapus!');
    }

    //form edit barang
    public function edit($id) {
        $product = Product::find($id); 
        return view('admin.edit', compact('product'));
    }

    //buat proses update barang
    public function update(Request $request, $id) {
        $product = Product::find($id);
        $product->nama_barang = $request->nama_barang;
        $product->harga = $request->harga;
        $product->stok = $request->stok;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $product->foto = $fotoPath;
        }

        $product->save();

        return redirect('/admin/dashboard')->with('success', 'Barang berhasil diubah!');
    }

    public function katalog() {
        $products = Product::all(); 
        return view('katalog', compact('products'));
    }
}