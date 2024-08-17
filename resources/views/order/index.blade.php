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
                        <input type="text" class="form-control" id="totalPembayaran" name="totalPembayaran" required readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="mejaNomor" class="form-label">No. Meja</label>
                        <input type="text" class="form-control" id="mejaNomor" name="mejaNomor" required>
                    </div>
                    <div class="col-md-2 mb-" style="text-align: right; position: relative; top: 30px;">
                        <button type="submit" class="btn btn-danger">Proses Transaksi</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-10">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="fw-bold fs-6">Menu</th>
                                <th class="fw-bold fs-6">Harga</th>
                                <th class="fw-bold fs-6">Kategori</th>
                                <th class="fw-bold fs-6">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr>
                                <td class="d-flex">
                                    <a href="{{ url('/order/edit/'.$order->id) }}" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                                    <form action="{{ url('/order/destroy/'.$order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                    </form>
                                </td>
                                <td>{{ $order->namaProduk }}</td>
                                <td>Rp {{ number_format($order->hargaProduk, 0, ',', '.') }}</td>
                                <td>{{ $order->kategoriProduk }}</td>
                                <td>{{ $order->deskripsiProduk }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-warning">
                                        Tidak ada data!
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="col-md-2">
                    <h4 class="mb-3">Menu</h4>
                    <div class="overflow-auto" style="max-height: 500px;">
                        @forelse ($produks as $produk)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $produk->namaProduk }}</h5>
                                <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($produk->hargaProduk, 0, ',', '.') }}</p>
                                <p class="card-text"><strong>Kategori:</strong> {{ $produk->kategoriProduk }}</p>
                                <button class="btn btn-primary btn-sm" onclick="tambahKePesanan({{ $produk->id }})">Tambah ke Pesanan</button>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-warning">
                            Tidak ada menu tersedia!
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if($orders)
    {{ $orders->links() }}
    @endif
</div>

@endsection
