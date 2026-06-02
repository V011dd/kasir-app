@extends('layouts.app')

@section('content')
<h4 class="fw-bold mb-3"><i class="bi bi-cart-plus"></i> Transaksi Baru</h4>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <div id="item-container">


<div class="mb-4">
    <label class="form-label fw-bold">Nama Pelanggan</label>
    <input type="text" name="nama_pelanggan" 
        class="form-control @error('nama_pelanggan') is-invalid @enderror"
        value="{{ old('nama_pelanggan') }}"
        placeholder="Contoh: Budi Santoso" required>
    @error('nama_pelanggan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                <div class="row item-row mb-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Produk</label>
                        <select name="produk_id[]" class="form-select produk-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->id }}"
                                    data-harga="{{ $produk->harga }}"
                                    data-stok="{{ $produk->stok }}">
                                    {{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    (Stok: {{ $produk->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Qty</label>
                        <input type="number" name="qty[]" class="form-control qty-input" value="1" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly value="Rp 0">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="btn-add-item" class="btn btn-outline-primary btn-sm mb-4">
                <i class="bi bi-plus"></i> Tambah Produk
            </button>

            <hr>

            <div class="row justify-content-end">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-5">Total Harga</label>
                        <input type="text" id="total-display" class="form-control form-control-lg fw-bold"
                            readonly value="Rp 0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uang Bayar</label>
                        <input type="number" name="bayar" id="bayar" class="form-control" 
                            placeholder="Masukkan jumlah bayar" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kembalian</label>
                        <input type="text" id="kembalian-display" class="form-control fw-bold text-success"
                            readonly value="Rp 0">
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="bi bi-check-circle"></i> Simpan Transaksi
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
let total = 0;

function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function hitungTotal() {
    total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.produk-select');
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const harga = parseInt(select.selectedOptions[0]?.dataset.harga) || 0;
        const subtotal = harga * qty;
        row.querySelector('.subtotal-display').value = formatRupiah(subtotal);
        total += subtotal;
    });
    document.getElementById('total-display').value = formatRupiah(total);
    hitungKembalian();
}

function hitungKembalian() {
    const bayar = parseInt(document.getElementById('bayar').value) || 0;
    const kembalian = bayar - total;
    const el = document.getElementById('kembalian-display');
    el.value = formatRupiah(kembalian < 0 ? 0 : kembalian);
    el.classList.toggle('text-danger', kembalian < 0);
    el.classList.toggle('text-success', kembalian >= 0);
}

document.addEventListener('change', e => {
    if (e.target.classList.contains('produk-select') || e.target.classList.contains('qty-input')) {
        hitungTotal();
    }
});

document.addEventListener('input', e => {
    if (e.target.classList.contains('qty-input')) hitungTotal();
    if (e.target.id === 'bayar') hitungKembalian();
});

document.getElementById('btn-add-item').addEventListener('click', () => {
    const container = document.getElementById('item-container');
    const firstRow = container.querySelector('.item-row');
    const newRow = firstRow.cloneNode(true);
    newRow.querySelector('.produk-select').value = '';
    newRow.querySelector('.qty-input').value = 1;
    newRow.querySelector('.subtotal-display').value = 'Rp 0';
    container.appendChild(newRow);
});

document.addEventListener('click', e => {
    if (e.target.closest('.btn-remove')) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            e.target.closest('.item-row').remove();
            hitungTotal();
        }
    }
});
</script>
@endsection