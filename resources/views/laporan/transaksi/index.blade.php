@extends('layout.app')
@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Transaksi</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Nominal (Rp)</th>
                <th>Saldo Setelah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $key => $transaksi)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if($transaksi->jenis == 'setor')
                            <span class="badge bg-success">Setor</span>
                        @else
                            <span class="badge bg-danger">Tarik</span>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($transaksi->saldo_setelah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($transaksis->count())
        <div class="d-flex justify-content-center">
            {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
        
    @endif
</div>
@endsection
