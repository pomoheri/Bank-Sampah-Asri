@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Form Setoran</h3>
        <form method="POST" action="{{ route('setoran.store') }}">
            @csrf
            <div class="mb-3">
                <label>Nasabah</label>
                <select name="nasabah_id" class="form-control" required>
                    @foreach ($nasabah as $n)
                        <option value="{{ $n->id }}">{{ $n->nama_nasabah }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Setoran</label>
                <input type="date" name="tanggal_setoran" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jenis Sampah</label>
                <select name="sampah_id" class="form-control" required>
                    @foreach ($sampah as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_sampah }} ({{ $item->harga_per_kg }} / kg)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Berat (kg)</label>
                <input type="number" name="berat_setor" step="0.01" class="form-control" required>
            </div>


            {{-- <div class="mb-3">
                <label>Berat Setor (kg)</label>
                <input type="number" step="0.01" name="berat_setor"
                    class="form-control @error('berat_setor') is-invalid @enderror" value="{{ old('berat_setor') }}">
                @error('berat_setor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <div class="mb-3">
                <label>Jumlah Uang (Rp)</label>
                <input type="text" name="jumlah_uang" class="form-control" id="jumlah_uang" readonly>
            </div>


            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaPerKgMap = @json($sampah->pluck('harga_per_kg', 'id')); // dari controller
            const beratInput = document.querySelector('input[name="berat_setor"]');
            const sampahSelect = document.querySelector('select[name="sampah_id"]');
            const jumlahUangInput = document.getElementById('jumlah_uang');

            function updateJumlahUang() {
                const berat = parseFloat(beratInput.value) || 0;
                const harga = hargaPerKgMap[sampahSelect.value] || 0;
                jumlahUangInput.value = (berat * harga).toFixed(2);
            }

            beratInput.addEventListener('input', updateJumlahUang);
            sampahSelect.addEventListener('change', updateJumlahUang);
        });
    </script>
@endsection
