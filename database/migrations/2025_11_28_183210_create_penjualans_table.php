<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->string('no_invoice')->unique(); // Tambahan untuk invoice (INV-2025-XXX)
            $table->date('tanggal_penjualan');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->unsignedBigInteger('id_kasir')->nullable(); // Kasir yg melayani
            $table->foreign('id_kasir')->references('id_kasir')->on('kasirs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
