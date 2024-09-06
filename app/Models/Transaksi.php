<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    public $timestamps = true;
    protected $fillable = [
        'namaPembeli',
        'jenisOrder',
        'namaProduk',
        'hargaProduk',
        'kategoriProduk',
        'jumlahProduk',
        'totalHarga',
    ];
}

