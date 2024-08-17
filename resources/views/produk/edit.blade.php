@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Update Data Produk') }}</h1>

    <form method="post" action="{{ url('/produk/update' , $produk->id)  }}" class="form-horizontal">
        @method('POST')
        @csrf
        
        <div class="form-group row mb-3">
            <label for="namaProduk" class="col-md-2 col-form-label">Nama Produk</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="namaProduk" name="namaProduk" value="{{ old('namaProduk') }}">
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="hargaProduk" class="col-md-2 col-form-label">Harga Produk</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="hargaProduk" name="hargaProduk" value="{{ old('hargaProduk') }}">
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="kategoriProduk" class="col-md-2 col-form-label">Kategori Produk</label>
            <div class="col-md-4">
                <select class="form-control" id="kategoriProduk" name="kategoriProduk">
                    <option value="">Pilih Kategori</option>
                    <option value="Paket" {{ old('kategoriProduk') == 'Paket' ? 'selected' : '' }}>Paket</option>
                    <option value="Minuman" {{ old('kategoriProduk') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Makanan" {{ old('kategoriProduk') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                </select>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="deskripsiProduk" class="col-md-2 col-form-label">Deskripsi Produk</label>
            <div class="col-md-4">
                <select class="form-control" id="deskripsiProduk" name="deskripsiProduk">
                    <option value="">Pilih Deskripsi</option>
                    <option value="Nasi/Lauk/Minum" {{ old('deskripsiProduk') == 'Nasi/Lauk/Minum' ? 'selected' : '' }}>Nasi/Lauk/Minum</option>
                    <option value="Nasi/Lauk" {{ old('deskripsiProduk') == 'Nasi/Lauk' ? 'selected' : '' }}>Nasi/Lauk</option>
                    <option value="Lauk" {{ old('deskripsiProduk') == 'Lauk' ? 'selected' : '' }}>Lauk</option>
                    <option value="Minuman" {{ old('deskripsiProduk') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection