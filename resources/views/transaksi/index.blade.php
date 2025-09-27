@extends('layout.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-exchange-alt"></i> Data Transaksi</h4>
            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-info">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
        <div class="card-body">

            {{-- Form Pencarian --}}
            <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                           placeholder="🔎 Cari nasabah, setoran, atau tarik ID..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Nasabah</th>
                            <th>Jenis Transaksi</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah Uang (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $key => $transaksi)
                            <tr>
                                <td class="text-center">{{ $key + $transaksis->firstItem() }}</td>
                                <td>{{ $transaksi->nama_nasabah }}</td>
                                <td>
                                    @if($transaksi->jenis === 'SETOR')
                                        <span class="badge bg-success"><i class="fas fa-arrow-down"></i> {{ $transaksi->jenis }}</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-arrow-up"></i> {{ $transaksi->jenis }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                                <td class="text-right fw-bold">{{ number_format($transaksi->jumlah_uang, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i> Tidak ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transaksis->count())
            <div class="d-flex justify-content-center mt-3">
                {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
            @endif

        </div>
    </div>
</div>

{{-- Konfirmasi Hapus (jika ada tombol delete di tabel) --}}
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
