@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fa fa-dollar-sign"></i> Edit Tarik Dana</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tarik.update', $tarik->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                   <label for="tanggal_tarik">Tanggal Tarik</label>
                    <input type="date" name="tanggal_tarik" id="tanggal_tarik"
                        class="form-control @error('tanggal_tarik') is-invalid @enderror" 
                        value="{{ old('tanggal_tarik', $tarik->tanggal_tarik) }}">
                    @error('tanggal_tarik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                     <label>Nasabah</label>
                    <select name="nasabah_id" class="form-control" required>
                        @foreach ($nasabah as $n)
                            <option value="{{ $n->id }}" 
                                {{ old('nasabah_id', $tarik->nasabah_id) == $n->id ? 'selected' : '' }}>
                                {{ $n->nama_nasabah }}
                            </option>
                        @endforeach
                    </select>
                    @error('nasabah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Jumlah uang tarik</label>
                    <input type="text" name="jumlah_uang_tarik"
                        class="form-control @error('jumlah_uang_tarik') is-invalid @enderror"
                        value="{{ old('jumlah_uang_tarik', $tarik->jumlah_uang_tarik) }}">
                    @error('jumlah_uang_tarik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('tarik.index') }}" class="btn btn-secondary">
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
@push('scripts')
<script>
</script>
@endpush
