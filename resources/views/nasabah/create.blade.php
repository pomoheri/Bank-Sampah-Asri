@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Form Nasabah</h3>
        <form method="POST" action="{{ route('nasabah.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nama nasabah</label>
                <input type="text" name="nama_nasabah" class="form-control @error('nama_nasabah') is-invalid @enderror"
                    value="{{ old('nama_nasabah') }}">
                @error('nama_nasabah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>No hp</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp') }}">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="user_id">Pilih User</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
