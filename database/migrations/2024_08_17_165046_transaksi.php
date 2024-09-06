<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('namaPembeli');
            $table->string('jenisOrder');
            $table->string('namaProduk');
            $table->integer('hargaProduk');
            $table->string('kategoriProduk');
            $table->integer('jumlahProduk');
            $table->integer('totalHarga');
            $table->timestamps();
        });
    }    

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};

