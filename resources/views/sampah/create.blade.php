@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Form Sampah</h3>
        <form method="POST" action="{{ route('sampah.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nama sampah</label>
                <input type="text" name="nama_sampah" class="form-control @error('nama_sampah') is-invalid @enderror"
                    value="{{ old('nama_sampah') }}">
                @error('nama_sampah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Jenis sampah</label>
                <input type="text" name="jenis_sampah" class="form-control @error('jenis_sampah') is-invalid @enderror"
                    value="{{ old('jenis_sampah') }}">
                @error('jenis_sampah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Harga per kg</label>
                <input type="text" name="harga_per_kg" class="form-control @error('harga_per_kg') is-invalid @enderror"
                    value="{{ old('harga_per_kg') }}">
                @error('harga_per_kg')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
