@extends('layout.app')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">📊 Data Transaksi</h3>

            <!-- Form Pencarian -->
            <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="🔎 Cari nasabah, setoran atau tarik ID..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Notifikasi -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Nasabah</th>
                            <th>Jenis Transaksi</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah Uang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $key => $transaksi)
                            <tr>
                                <td class="text-center">{{ $key + $transaksis->firstItem() }}</td>
                                <td>{{ $transaksi->nama_nasabah }}</td>
                                <td>
                                    @if($transaksi->jenis == 'SETOR')
                                        <span class="badge bg-success">{{ $transaksi->jenis }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $transaksi->jenis }}</span>
                                    @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                                <td class="text-right">Rp {{ number_format($transaksi->jumlah_uang, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">⚠️ Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transaksis->count())
            <div class="d-flex justify-content-center">
                {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Konfirmasi hapus -->
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
