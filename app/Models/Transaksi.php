<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{

    protected $fillable = ['kode_transaksi', 'nama_pelanggan', 'total_harga', 'bayar', 'kembalian'];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}