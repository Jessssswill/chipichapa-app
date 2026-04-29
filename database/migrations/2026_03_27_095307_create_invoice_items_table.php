<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tabel invoice_items buat nyimpen detail barang di setiap invoice
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->string('nama_barang'); // simpan nama barang waktu beli (biar kalo nama produk berubah, invoice tetep)
            $table->integer('harga_satuan'); // harga per satuan waktu beli
            $table->integer('jumlah'); // berapa banyak dibeli
            $table->integer('subtotal'); // harga_satuan x jumlah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};
