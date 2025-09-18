@extends('layout.app')
@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Saldo</h3>

    @php
        $user = Auth::user();
        $role = $user->role;
    @endphp

    {{-- Form pencarian hanya untuk admin --}}
    @if($role === 'admin')
        <form action="{{ route('laporan.saldo') }}" method="GET" class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari berdasarkan nama nasabah..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('laporan.saldo') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    @endif

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>NO</th>
                <th>NASABAH</th>
                <th>JUMLAH SETOR</th>
                <th>JUMLAH TARIK</th>
                <th>SALDO</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $key => $transaksi)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $transaksi->nama_nasabah }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->jumlah_setor, 2, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->jumlah_tarik, 2, ',', '.') }}</td>
                    <td class="text-right fw-bold">Rp {{ number_format($transaksi->saldo, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data saldo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination (hanya tampil kalau ada data) --}}
    @if($transaksis->count())
        <div class="d-flex justify-content-center">
            {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

{{-- Konfirmasi hapus (jika ada form delete) --}}
<script>
    document.querySelectorAll(".form-delete").forEach(form => {
        form.addEventListener("submit", function(e) {
            if (!confirm("Yakin ingin menghapus data ini?")) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
