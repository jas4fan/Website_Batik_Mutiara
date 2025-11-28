<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk Login

class Admin extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'id_admin';
    protected $guarded = [];

    // Relasi: Admin mengelola banyak Kasir
    public function kasirs() {
        return $this->hasMany(Kasir::class, 'id_admin');
    }
}