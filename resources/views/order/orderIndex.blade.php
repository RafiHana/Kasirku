@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Order') }}</h1>
    <div class="row">
        <div class="col-md-15">

            <form action="{{ url('/order/store') }}" method="POST" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="namaPembeli" class="form-label">Nama Pembeli</label>
                        <input type="text" class="form-control" id="namaPembeli" name="namaPembeli" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="jenisOrder" class="form-label">Jenis Order</label>
                        <select class="form-select" id="jenisOrder" name="jenisOrder" required>
                            <option value="">Pilih Jenis Order</option>
                            <option value="Dine In">Dine In</option>
                            <option value="Take Away">Take Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="totalPembayaran" class="form-label">Total Pembayaran</label>
                        <input type="text" class="form-control" id="totalPembayaran" name="totalPembayaran" value="Rp {{ number_format($total, 0, ',', '.') }}" required readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="mejaNomor" class="form-label">No. Meja</label>
                        <input type="text" class="form-control" id="mejaNomor" name="mejaNomor" required>
                    </div>
                    <div class="col-md-2 mb-" style="text-align: right; position: relative; top: 30px;">
                        <input type="hidden" name="cart" value="{{ json_encode(session('cart')) }}">
                        <button type="submit" class="btn btn-danger">Proses Transaksi</button>
                    </div>
                    
                </div>
            </form>

            <div class="row">
                <div class="col-md-10">
                <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session('cart', []) as $id => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['namaProduk'] }}</td>
                                    <td>Rp {{ number_format($item['hargaProduk'], 0, ',', '.') }}</td>
                                    <td>{{ $item['kategoriProduk'] }}</td>
                                    <td>{{ $item['deskripsiProduk'] }}</td>
                                    <td>
                                        <form action="{{ route('order.decreaseItem') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm btn-secondary">-</button>
                                        </form>
                                        <span>{{ $item['jumlah'] ?? 1 }}</span> 
                                        <form action="{{ route('order.increaseItem') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm btn-secondary">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('order.removeItem') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="col-md-2">
                    <h4 class="mb-3">Menu</h4>
                    <form action="{{ route('order.search') }}" method="GET" class="mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Cari menu..." value="{{ request()->get('search') }}" oninput="this.form.submit()">
                    </form>
                    <div class="overflow-auto" style="max-height: 500px;">
                        @foreach ($produks as $produk)
                            <div class="card mb-3 {{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produk->namaProduk }}</h5>
                                    <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($produk->hargaProduk, 0, ',', '.') }}</p>
                                    <p class="card-text"><strong>Kategori:</strong> {{ $produk->kategoriProduk }}</p>
                                    <form action="{{ route('order.addItem') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if(isset($orders))
    {{ $orders->links() }}
    @endif
</div>
@endsection
