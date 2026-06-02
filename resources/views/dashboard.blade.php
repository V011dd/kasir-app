@extends ('layouts.app')

@section ('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class= "bi bi-speedometer2"></i> Dashboard</h4>
    <span class="text-muted">{{ now()->format('d F Y') }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div
                    <p class="mb-1 small">Penjualan Hari Ini</p>
                        <h5 class="fw-bold">Rp {{number_format($penjualanHariIni, 0, ',', '.')}}</h5>
                    </div>
                    <i class="bi bi-cash-coin fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 small">Transaksi Hari ini</p>
                        <h5 class="fw-bold">{{$transaksiHariIni}} Transaksi</h5>
                    </div>
                    <i class="bi bi-cart fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 small">Penjualan Bulan Ini</p>
                        <h5 class="fw-bold">Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}</h5>
                    </div>
                    <i class="bi bi-graph-up fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 small">Total Produk</p>
                        <h5 class="fw-bold">{{ $totalProduk }} Produk</h5>
                    </div>
                    <i class="bi bi-box-seam fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Grafik Penjualan --}}
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                <i class="bi bi-bar-chart"></i> Grafik Penjualan 7 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="grafikChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header fw-bold text-danger">
                <i class="bi bi-exclamation-triangle"></i> Stok Menipis
            </div>
            <div class="card-body p-0">
                @forelse($stokMenupis as $produk)
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <span>{{ $produk->nama }}</span>
                    <span class="badge bg-danger">{{ $produk->stok }} sisa</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-check-circle text-success fs-4"></i>
                    <p class="mb-0 mt-1">Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">
        <i class="bi bi-clock-history"></i> Transaksi Terbaru
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $trx)
                <tr>
                    <td><span class="badge bg-secondary">{{ $trx->kode_transaksi }}</span></td>
                    <td>{{ $trx->nama_pelanggan }}</td>
                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $trx) }}" class="btn btn-info btn-sm text-white">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($grafikPenjualan->pluck('tanggal'));
    const data   = @json($grafikPenjualan->pluck('total'));

    new Chart(document.getElementById('grafikChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: data,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
            }
        }
    });
</script>

@endsection