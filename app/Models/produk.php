<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';
    public $timestamps = true;
    protected $fillable = [
        'namaProduk',
        'hargaProduk',
        'kategoriProduk',
        'deskripsiProduk',
    ];
}
