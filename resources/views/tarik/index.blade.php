@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Tarik</h3>
        <a href="{{ route('tarik.create') }}" class="btn btn-success mb-3">Tambah tarik</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>tanggal_tarik</th>
                    <th>jumlah_uang_tarik</th>
                    <th>nasabah_id</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tariks as $tarik)
                    <tr>
                        <td>{{ $tarik->tanggal_tarik }}</td>
                        <td>{{ $tarik->jumlah_uang_tarik }}</td>
                        <td>{{ $tarik->nasabah_id }}</td>
                        <td>
                            <a href="{{ route('tarik.edit', $tarik->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tarik.destroy', $tarik->id) }}" method="POST"
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
