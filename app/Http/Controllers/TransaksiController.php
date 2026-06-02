<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::latest()->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'produk_id'   => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'qty.*'       => 'required|integer|min:1',
            'bayar'       => 'required|integer|min:0',
        ]);

        // Hitung total
        $total = 0;
        foreach ($request->produk_id as $i => $id) {
            $produk = Produk::find($id);
            $total += $produk->harga * $request->qty[$i];
        }

        // Validasi uang bayar
        if ($request->bayar < $total) {
            return back()->with('error', 'Uang bayar kurang!')->withInput();
        }

        // Buat transaksi
        $transaksi = Transaksi::create([
            'nama_pelanggan'  => $request->nama_pelanggan,
            'kode_transaksi' => 'TRX-' . date('YmdHis'),
            'total_harga'    => $total,
            'bayar'          => $request->bayar,
            'kembalian'      => $request->bayar - $total,
        ]);

        // Simpan detail & kurangi stok
        foreach ($request->produk_id as $i => $id) {
            $produk = Produk::find($id);
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $id,
                'qty'          => $request->qty[$i],
                'harga_satuan' => $produk->harga,
                'subtotal'     => $produk->harga * $request->qty[$i],
            ]);

            // Kurangi stok produk
            $produk->decrement('stok', $request->qty[$i]);
        }

        return redirect()->route('transaksi.show', $transaksi)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('details.produk');
        return view('transaksi.show', compact('transaksi'));
    }
}