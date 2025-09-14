@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Laporan Saldo</h3>
        <!-- Form Pencarian -->
        <form action="{{ route('laporan.saldo') }}" method="GET" class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari berdasarkan nama nasabah..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('laporan.saldo') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">NASABAH</th>
                    <th class="text-center">JUMLAH SETOR</th>
                    <th class="text-center">JUMLAH TARIK</th>
                    <th class="text-center">SALDO</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $key => $transaksi)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $transaksi->nama_nasabah }}</td>
                        <td class="text-right">Rp {{ number_format($transaksi->jumlah_setor, 2, '.', ',') }}</td>
                        <td class="text-right">Rp {{ number_format($transaksi->jumlah_tarik, 2, '.', ',') }}</td>
                        <td class="text-right">Rp {{ number_format($transaksi->saldo, 2, '.', ',') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data saldo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $transaksis->withQueryString()->links() }}

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