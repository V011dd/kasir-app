<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    
    protected $fillable = ['transaksi_id', 'produk_id', 'qty', 'harga_satuan', 'subtotal'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}