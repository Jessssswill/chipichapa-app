<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    // relasi ke products (satu kategori punya banyak barang)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
