@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Sampah</h3>
        <a href="{{ route('sampah.create') }}" class="btn btn-success mb-3">Tambah sampah</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>nama_sampah</th>
                    <th>jenis_sampah</th>
                    <th>harga_per_kg</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sampahs as $sampah)
                    <tr>
                        <td>{{ $sampah->nama_sampah }}</td>
                        <td>{{ $sampah->jenis_sampah }}</td>
                        <td>{{ $sampah->harga_per_kg }}</td>
                        <td>
                            <a href="{{ route('sampah.edit', $sampah->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('sampah.destroy', $sampah->id) }}" method="POST"
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
