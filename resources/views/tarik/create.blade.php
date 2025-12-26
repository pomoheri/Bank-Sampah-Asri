@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fa fa-dollar-sign"></i> Tambah Tarik Dana</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('tarik.store') }}">
                @csrf

                <div class="form-group">
                   <label for="tanggal_tarik">Tanggal Tarik</label>
                    <input type="date" name="tanggal_tarik" id="tanggal_tarik"
                        class="form-control @error('tanggal_tarik') is-invalid @enderror" value="{{ old('tanggal_tarik') }}">
                    @error('tanggal_tarik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                     <label>Nasabah</label>
                    <select name="nasabah_id" id="nasabah_id" class="form-control" required>
                        <option value="">-- Pilih Nasabah --</option>
                        @foreach ($nasabah as $n)
                            <option value="{{ $n->id }}">{{ $n->nama_nasabah }}</option>
                        @endforeach
                    </select>
                    @error('nasabah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jumlah uang yang bisa ditarik</label>
                    <input disabled type="text" id="saldo"
                    class="form-control"
                    placeholder="Rp 0">
                    <input type="hidden" id="saldo_asli" value="0">
                </div>

                <div class="form-group">
                    <label>Jumlah uang tarik</label>
                    <input type="number" name="jumlah_uang_tarik" id="jumlah_uang_tarik"
                        class="form-control @error('jumlah_uang_tarik') is-invalid @enderror">
                    
                    <small class="text-danger d-none" id="error-saldo">
                        Jumlah tarik melebihi saldo yang tersedia
                    </small>

                    @error('jumlah_uang_tarik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('tarik.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#nasabah_id').on('change', function () {
        let nasabahId = $(this).val();

        if (!nasabahId) {
            $('#saldo').val('');
            return;
        }

        $.ajax({
            url: `/nasabah/${nasabahId}/saldo`,
            type: 'GET',
            success: function (res) {
                $('#saldo_asli').val(res.saldo);

                let rupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(res.saldo);

                $('#saldo').val(rupiah);
            }
        });
    });

    $('#jumlah_uang_tarik').on('input', function () {
        let tarik = parseInt($(this).val()) || 0;
        let saldo = parseInt($('#saldo_asli').val()) || 0;

        if (tarik > saldo) {
            $('#error-saldo').removeClass('d-none');
            $('#jumlah_uang_tarik').addClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true);
        } else {
            $('#error-saldo').addClass('d-none');
            $('#jumlah_uang_tarik').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', false);
        }
    });
</script>
@endpush