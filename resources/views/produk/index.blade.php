@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Data Menu') }}</h1>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-large btn-primary" href="{{ url('/produk/create') }}">Tambah Menu</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-13">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class="fw-bold fs-4">Menu</th>
                        <th class="fw-bold fs-4">Harga</th>
                        <th class="fw-bold fs-4">Kategori</th>
                        <th class="fw-bold fs-4">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                    <tr>
                        <td class="d-flex">
                            <a href="{{ url('/produk/edit/'.$produk->id) }}"class="btn btn-primary">Edit</a>&nbsp;
                            <form action="{{ url('/produk/destroy/'.$produk->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                            </form>
                        </td>
                        <td>{{ $produk->namaProduk }}</td>
                        <td>Rp {{ number_format($produk->hargaProduk, 0, ',', '.') }}</td>
                        <td>{{ $produk->kategoriProduk }}</td>
                        <td>{{ $produk->deskripsiProduk }}</td>
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
    </div>
    @if($produks)
    {{ $produks->links() }}
    @endif
</div>

@endsection
