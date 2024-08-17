<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);
        $produks = Produk::all();
        return view('order.index', ['orders' => $orders, 'produks' => $produks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produks = Produk::all();
        return view('order.create', ['produks' => $produks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
        'namaPembeli' => 'required|string|max:255',
        'jenisOrder' => 'required|string|max:255',
        'produk_id' => 'required|exists:produks,id',
        'jumlahProduk' => 'required|integer|min:1',
    ]);

        $produk = Produk::findOrFail($request->produk_id);
        
        $order = new Order();
        $order->namaPembeli = $request->namaPembeli;
        $order->jenisOrder = $request->jenisOrder;
        $order->namaProduk = $produk->namaProduk;
        $order->hargaProduk = $produk->hargaProduk;
        $order->kategoriProduk = $produk->kategoriProduk;
        $order->jumlahProduk = $request->jumlahProduk;
        $order->totalHarga = $produk->hargaProduk * $request->jumlahProduk;
        
        $order->save();
        
        return redirect('/order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $produks = Produk::all();
        return view('order.edit', ['order' => $order, 'produks' => $produks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaPembeli' => 'required|string|max:255',
            'jenisOrder' => 'required|string|max:255',
            'produk_id' => 'required|exists:produks,id',
            'jumlahProduk' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $produk = Produk::findOrFail($request->produk_id);

        $order->namaPembeli = $request->namaPembeli;
        $order->jenisOrder = $request->jenisOrder;
        $order->namaProduk = $produk->namaProduk;
        $order->hargaProduk = $produk->hargaProduk;
        $order->kategoriProduk = $produk->kategoriProduk;
        $order->jumlahProduk = $request->jumlahProduk;
        $order->totalHarga = $produk->hargaProduk * $request->jumlahProduk;

        $order->save();

        return redirect('/order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect('/order');
    }
}