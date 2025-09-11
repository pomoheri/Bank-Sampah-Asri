@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Transaksi</h3>
        <!-- Form Pencarian -->
        <form action="{{ route('transaksi.index') }}" method="GET" class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari berdasarkan setoran atau tarik ID..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Setoran</th>
                    <th>ID Tarik</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $transaksi)
                    <tr>
                        <td>{{ $transaksi->id }}</td>
                        <td>{{ $transaksi->setoran_id ?? '-' }}</td>
                        <td>{{ $transaksi->tarik_id ?? '-' }}</td>
                        <td>Rp {{ number_format($transaksi->saldo) }}</td>
                        <td>
                            <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                                style="display:inline-block;" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data transaksi.</td>
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

<a href="{{ route('transaksi.create') }}" class="btn btn-success mb-3">Tambah transaksi</a>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>setoran_id</th>
            <th>tarik_id</th>
            <th>saldo</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->setoran_id }}</td>
                <td>{{ $transaksi->tarik_id }}</td>
                <td>{{ $transaksi->saldo }}</td>
                <td>
                    <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
