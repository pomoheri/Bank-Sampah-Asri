@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Nasabah</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('nasabah.update', $nasabah->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Nasabah</label>
                    <input type="text" 
                           name="nama_nasabah" 
                           class="form-control @error('nama_nasabah') is-invalid @enderror"
                           value="{{ old('nama_nasabah', $nasabah->nama_nasabah) }}" 
                           placeholder="Masukkan nama nasabah">
                    @error('nama_nasabah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" 
                           name="no_hp" 
                           class="form-control @error('no_hp') is-invalid @enderror"
                           value="{{ old('no_hp', $nasabah->no_hp) }}" 
                           placeholder="Masukkan nomor HP">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">Pilih User</label>
                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id', $nasabah->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">
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
