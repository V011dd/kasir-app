@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Struk Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h6 class="text-muted">Kode: <strong>{{ $transaksi->kode_transaksi }}</strong></h6>
                    <small class="text-muted">{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</small>
                </div>

                <hr>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama }}</td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr class="table-secondary">
                            <td colspan="3">Total</td>
                            <td class="text-end">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Bayar</td>
                            <td class="text-end">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="3">Kembalian</td>
                            <td class="text-end">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-success">
                        <i class="bi bi-plus"></i> Transaksi Baru
                    </a>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list"></i> Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection