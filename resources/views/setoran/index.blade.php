@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Setoran Sampah</h3>

        <!-- Form Pencarian -->
        <form action="{{ route('setoran.index') }}" method="GET" class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama nasabah atau jenis sampah..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('setoran.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tabel Data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Setor</th>
                    <th>Nama Nasabah</th>
                    <th>Jenis Sampah</th>
                    <th>Berat (Kg)</th>
                    <th>Jumlah Uang (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $setoran)
                    <tr>
                        <td>{{ $setoran->tanggal_setoran }}</td>
                        <td>{{ $setoran->nasabah->nama_nasabah ?? '-' }}</td>
                        <td>{{ $setoran->sampah->nama_sampah ?? '-' }}</td>
                        <td>{{ $setoran->berat_setor }}</td>
                        <td>{{ number_format($setoran->jumlah_uang, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('setoran.edit', $setoran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('setoran.destroy', $setoran->id) }}" method="POST"
                                class="d-inline form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data setoran ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $data->withQueryString()->links() }}
    </div>

    <!-- Konfirmasi Hapus -->
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
