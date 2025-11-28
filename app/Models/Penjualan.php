<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $primaryKey = 'id_penjualan';
    protected $guarded = [];

    public function kasir() {
        return $this->belongsTo(Kasir::class, 'id_kasir');
    }

    public function details() {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
}