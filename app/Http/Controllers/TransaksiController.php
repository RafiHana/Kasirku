<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Order;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::paginate(10);
        
        return view('transaksi.transaksi', [
            'transaksis' => $transaksis,
        ]);
    }
    
}
