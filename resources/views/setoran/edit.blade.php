@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Setoran</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('setoran.update', $setoran->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                   <label>Nasabah</label>
                    <select name="nasabah_id" class="form-control" required>
                        @foreach ($nasabah as $n)
                            <option value="{{ $n->id }}" 
                                {{ $setoran->nasabah_id == $n->id ? 'selected' : '' }}>
                                {{ $n->nama_nasabah }}
                            </option>
                        @endforeach
                    </select>
                    @error('nasabah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                   <label>Tanggal Setoran</label>
                    <input type="date" name="tanggal_setoran" class="form-control" 
                           value="{{ old('tanggal_setoran', $setoran->tanggal_setoran) }}" required>
                    @error('tanggal_setoran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select name="sampah_id" class="form-control" required>
                        @foreach ($sampah as $item)
                            <option value="{{ $item->id }}" 
                                {{ $setoran->sampah_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_sampah }} ({{ $item->harga_per_kg }} / kg)
                            </option>
                        @endforeach
                    </select>
                    @error('sampah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Berat (kg)</label>
                    <input type="number" name="berat_setor" step="0.01" 
                           class="form-control @error('berat_setor') is-invalid @enderror"
                           value="{{ old('berat_setor', $setoran->berat_setor) }}" required>
                    @error('berat_setor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jumlah Uang (Rp)</label>
                    <input type="text" name="jumlah_uang" class="form-control" id="jumlah_uang" 
                           value="{{ old('jumlah_uang', $setoran->jumlah_uang) }}" readonly>
                    @error('jumlah_uang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('setoran.index') }}" class="btn btn-secondary">
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
    document.addEventListener('DOMContentLoaded', function() {
        const hargaPerKgMap = @json($sampah->pluck('harga_per_kg', 'id'));
        const beratInput = document.querySelector('input[name="berat_setor"]');
        const sampahSelect = document.querySelector('select[name="sampah_id"]');
        const jumlahUangInput = document.getElementById('jumlah_uang');

        function updateJumlahUang() {
            const berat = parseFloat(beratInput.value) || 0;
            const harga = hargaPerKgMap[sampahSelect.value] || 0;
            jumlahUangInput.value = (berat * harga).toFixed(2);
        }

        // jalankan sekali waktu form edit dibuka
        updateJumlahUang();

        // event listener
        beratInput.addEventListener('input', updateJumlahUang);
        sampahSelect.addEventListener('change', updateJumlahUang);
    });
</script>
@endpush
