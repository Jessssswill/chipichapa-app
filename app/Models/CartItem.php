<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // relasi ke user (punya siapa keranjangnya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke product (barang apa yang dimasukin)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
