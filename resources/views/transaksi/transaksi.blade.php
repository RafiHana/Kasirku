@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Transaksi Pembeli') }}</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Jenis Order</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->namaPembeli }}</td>
                            <td>{{ $transaksi->jenisOrder }}</td>
                            <td>{{ $transaksi->namaProduk }}</td>
                            <td>Rp {{ number_format($transaksi->hargaProduk, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->kategoriProduk }}</td>
                            <td>{{ $transaksi->jumlahProduk }}</td>
                            <td>Rp {{ number_format($transaksi->totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection
