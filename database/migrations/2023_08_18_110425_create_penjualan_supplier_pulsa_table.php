<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_supplier_pulsa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier');
            $table->unsignedBigInteger('supplier_pulsa_id');
            $table->foreign('supplier_pulsa_id')->references('id')->on('supplier_pulsa');
            $table->unsignedBigInteger('pulsa_id');
            $table->foreign('pulsa_id')->references('id')->on('pulsa');
            $table->unsignedBigInteger('kartu_id');
            $table->foreign('kartu_id')->references('id')->on('kartu');
            $table->integer('nominal');
            $table->integer('harga_jual');
            $table->integer('jumlah_transaksi');
            $table->integer('harga_beli');
            $table->integer('total_harga_jual');
            $table->integer('total_harga_beli');
            $table->integer('keuntungan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_supplier_pulsa');
    }
};
