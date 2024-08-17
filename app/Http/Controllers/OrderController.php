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
        
        $total = 0;
        foreach (session('cart', []) as $item) {
            $total += $item['hargaProduk'] * ($item['jumlah'] ?? 1); 
        }
        
        return view('order.orderIndex', [
            'orders' => $orders,
            'produks' => $produks,
            'total' => $total
        ]);
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
            'cart' => 'required|json',
        ]);
    
        $cart = json_decode($request->cart, true);
    
        foreach ($cart as $id => $item) {
            $order = new Order();
            $order->namaPembeli = $request->namaPembeli;
            $order->jenisOrder = $request->jenisOrder;
            $order->namaProduk = $item['namaProduk'];
            $order->hargaProduk = $item['hargaProduk'];
            $order->kategoriProduk = $item['kategoriProduk'];
            $order->jumlahProduk = 1;
            $order->totalHarga = $item['hargaProduk'];
            $order->save();
        }
    
        session()->forget('cart');
    
        return redirect('/order')->with('success', 'Pesanan berhasil diproses.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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


    public function addItem(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);
    
        $produk = Produk::findOrFail($request->produk_id);
    
        $cart = session()->get('cart', []);
        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['jumlah'] += 1;
        } else {
            $cart[$produk->id] = [
                'namaProduk' => $produk->namaProduk,
                'hargaProduk' => $produk->hargaProduk,
                'kategoriProduk' => $produk->kategoriProduk,
                'deskripsiProduk' => $produk->deskripsiProduk,
                'jumlah' => 1, 
            ];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke pesanan.');
    }
    
    public function removeItem(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);
    
        $cart = session()->get('cart', []);
    
        if (isset($cart[$request->produk_id])) {
            unset($cart[$request->produk_id]);
            session()->put('cart', $cart);
        }
    
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari pesanan.');
    }


   public function increaseItem(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->produk_id])) {
            $cart[$request->produk_id]['jumlah'] = $cart[$request->produk_id]['jumlah'] ?? 1;
            $cart[$request->produk_id]['jumlah'] += 1;
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Jumlah item ditambah.');
    }

    public function decreaseItem(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->produk_id])) {
            $cart[$request->produk_id]['jumlah'] = $cart[$request->produk_id]['jumlah'] ?? 1;
            if ($cart[$request->produk_id]['jumlah'] > 1) {
                $cart[$request->produk_id]['jumlah'] -= 1;
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Jumlah item dikurangi.');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $produks = Produk::where('namaProduk', 'like', "%$search%")->get();
        $cart = session('cart', []);
    
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['hargaProduk'] * ($item['jumlah'] ?? 1); 
        }
    
        $orders = Order::paginate(10);
        return view('order.orderIndex', [
            'produks' => $produks,
            'total' => $total,
            'orders' => $orders 
        ]);
    }
    
    

    
}