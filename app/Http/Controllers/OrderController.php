<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;

class OrderController extends Controller {

    public function index()
    {
        $orders = Order::paginate(10);
        $produks = Produk::all();
    
        $total = 0;
        foreach (session('cart', []) as $item) {
            $total += $item['hargaProduk'] * ($item['jumlah'] ?? 1); 
        }
    
        $orderForm = session('order_form', []);
        return view('order.orderIndex', [
            'orders' => $orders,
            'produks' => $produks,
            'total' => $total,
            'order_form' => $orderForm
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPembeli' => 'required|string|max:255',
            'jenisOrder' => 'required|string|max:255',
        ]);
    
        session()->put('order_form', [
            'namaPembeli' => $request->namaPembeli,
            'jenisOrder' => $request->jenisOrder,
        ]);
    
        session()->forget('cart');
        return redirect('/order')->with('success', 'Pesanan berhasil diproses.');
    }
    
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

    public function processTransaction(Request $request)
    {
        $request->validate([
            'namaPembeli' => 'required|string|max:255',
            'jenisOrder' => 'required|string|max:255',
        ]);
    
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect('/order')->with('error', 'Keranjang kosong. Silakan tambahkan item terlebih dahulu.');
        }
    
        foreach ($cart as $id => $item) {
            $order = new Order([
                'namaPembeli' => $request->namaPembeli,
                'jenisOrder' => $request->jenisOrder,
                'namaProduk' => $item['namaProduk'],
                'hargaProduk' => $item['hargaProduk'],
                'kategoriProduk' => $item['kategoriProduk'],
                'jumlahProduk' => $item['jumlah'] ?? 1,
                'totalHarga' => $item['hargaProduk'] * ($item['jumlah'] ?? 1),
            ]);
    
            $order->save();
        }
    
        session()->forget(['cart', 'order_form']);
        return redirect('/order')->with('success', 'Transaksi berhasil diproses dan disimpan.');
    }

    
       
}