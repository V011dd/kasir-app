<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $penjualanHariIni = Transaksi::whereDate('created_at', today())
        ->sum('total_harga');
        
        $transaksiHariIni = Transaksi::whereDate('created_at', today())
        ->count();

        $penjualanBulanIni = Transaksi::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)
        ->sum('total_harga');

        $totalProduk = Produk::count();

        $stokMenupis = Produk::where('stok', '<=', 5)->get();

        $transaksiTerbaru = Transaksi::latest()->take(5)->get();

        $grafikPenjualan = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as total'))

        ->whereBetween('created_at', [now()->subDays(6), now()])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

         return view('dashboard', compact(
            'penjualanHariIni',
            'transaksiHariIni',
            'penjualanBulanIni',
            'totalProduk',
            'stokMenupis',
            'transaksiTerbaru',
            'grafikPenjualan'

            ));
        }
    
}
