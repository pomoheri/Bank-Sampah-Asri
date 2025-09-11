@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Nasabah</h3>
        <a href="{{ route('nasabah.create') }}" class="btn btn-success mb-3">Tambah nasabah</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>nama_nasabah</th>
                    <th>no_hp</th>
                    <th>user_id</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nasabahs as $nasabah)
                    <tr>
                        <td>{{ $nasabah->nama_nasabah }}</td>
                        <td>{{ $nasabah->no_hp }}</td>
                        <td>{{ $nasabah->user_id }}</td>
                        <td>
                            <a href="{{ route('nasabah.edit', $nasabah->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST"
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
