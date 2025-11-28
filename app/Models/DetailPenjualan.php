<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $primaryKey = 'id_detail';
    protected $guarded = [];

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}