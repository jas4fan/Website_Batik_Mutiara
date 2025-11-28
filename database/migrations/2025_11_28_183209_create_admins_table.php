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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('id_admin'); // Primary Key
            $table->string('nama_admin', 100);
            $table->string('username', 15)->unique();
            $table->string('password'); // Akan di-hash
            $table->enum('hak_akses', ['admin', 'owner'])->default('admin'); // Tambahan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
