@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Form Tarik</h3>
        <form method="POST" action="{{ route('tarik.store') }}">
            @csrf

            <div class="mb-3">
                <label for="tanggal_tarik">Tanggal Tarik</label>
                <input type="date" name="tanggal_tarik" id="tanggal_tarik"
                    class="form-control @error('tanggal_tarik') is-invalid @enderror" value="{{ old('tanggal_tarik') }}">
                @error('tanggal_tarik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Jumlah uang tarik</label>
                <input type="text" name="jumlah_uang_tarik"
                    class="form-control @error('jumlah_uang_tarik') is-invalid @enderror"
                    value="{{ old('jumlah_uang_tarik') }}">
                @error('jumlah_uang_tarik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Nasabah</label>
                <select name="nasabah_id" class="form-control" required>
                    @foreach ($nasabah as $n)
                        <option value="{{ $n->id }}">{{ $n->nama_nasabah }}</option>
                    @endforeach
                </select>
                @error('nasabah_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
