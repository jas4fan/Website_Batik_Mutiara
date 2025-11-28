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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 100);
            $table->string('jenis_produk', 45); // Batik Tulis, Batik Cap, dll
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            // Tracking siapa yang input/edit (Kasir atau Admin)
            $table->unsignedBigInteger('id_kasir')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
