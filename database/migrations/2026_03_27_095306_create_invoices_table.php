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
        // tabel invoices buat nyimpen data faktur pembelian
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique(); // nomor invoice otomatis
            $table->foreignId('user_id')->constrained('users');
            $table->string('alamat_pengiriman'); // alamat pengiriman pembeli
            $table->string('kode_pos'); // kode pos 5 digit
            $table->integer('total_harga'); // total semua barang
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
        Schema::dropIfExists('invoices');
    }
};
