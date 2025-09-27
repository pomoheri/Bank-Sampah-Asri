@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Sampah</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sampah.update', $sampah->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Sampah</label>
                    <input type="text" 
                           name="nama_sampah" 
                           class="form-control @error('nama_sampah') is-invalid @enderror"
                           value="{{ old('nama_sampah', $sampah->nama_sampah) }}" 
                           placeholder="Masukkan Nama Sampah">
                    @error('nama_sampah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <input type="text" 
                           name="jenis_sampah" 
                           class="form-control @error('jenis_sampah') is-invalid @enderror"
                           value="{{ old('jenis_sampah', $sampah->jenis_sampah) }}" 
                           placeholder="Masukkan Jenis Sampah">
                    @error('jenis_sampah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Harga Per Kg (Rp)</label>
                    <input type="text" 
                           name="harga_per_kg" 
                           class="form-control @error('harga_per_kg') is-invalid @enderror"
                           value="{{ old('harga_per_kg', $sampah->harga_per_kg) }}" 
                           placeholder="Masukkan Harga Per Kg">
                    @error('harga_per_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('sampah.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
