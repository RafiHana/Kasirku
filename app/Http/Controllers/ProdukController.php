<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produks = Produk::paginate(10);
        return view('produk.index', ['produks' => $produks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
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
        'namaProduk' => 'required|string|max:255',
        'hargaProduk' => 'required|string|max:255',
        'kategoriProduk' => 'required|string|max:255',
        'deskripsiProduk' => 'required|string|max:255',
    ]);

        $data = $request->all();
        Produk::create($data);
        return redirect('/produk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('produk.edit', ['produk' => Produk::find($id)]);
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
            'namaProduk' => 'required|string|max:255',
            'hargaProduk' => 'required|string|max:255',
            'kategoriProduk' => 'required|string|max:255',
            'deskripsiProduk' => 'required|string|max:255',
        ]);
        $data = $request->all();

        $produk = Produk::find($id);
        $produk->update($data);
        return redirect('/produk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return redirect('/produk');
    }
}