<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk Login

class Kasir extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'id_kasir';
    protected $guarded = [];

    // Relasi: Kasir melakukan banyak Penjualan
    public function penjualans() {
        return $this->hasMany(Penjualan::class, 'id_kasir');
    }
}