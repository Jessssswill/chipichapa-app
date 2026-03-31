<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function beli(Request $request, $id) {
        $product = Product::find($id);
        $jumlah_beli = $request->jumlah;

        if ($product->stok < $jumlah_beli) {
            return redirect('/')->with('error', 'Maaf, stok ' . $product->nama_barang . ' tidak mencukupi!');
        }

        $product->stok = $product->stok - $jumlah_beli;
        $product->save();
        $total_harga = $product->harga * $jumlah_beli;

        $invoice = Invoice::create([
            'user_id' => Auth::id(), 
            'product_id' => $product->id,
            'jumlah' => $jumlah_beli,
            'total_harga' => $total_harga
        ]);

        return view('invoice', compact('invoice', 'product'));
    }
}