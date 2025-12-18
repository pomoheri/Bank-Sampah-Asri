@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-trash"></i> Tambah Setoran</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('setoran.store') }}">
        @csrf

        <!-- Nasabah -->
        <div class="form-group mb-3">
          <label>Nasabah</label>
          <select name="nasabah_id" class="form-control" required>
            @foreach ($nasabah as $n)
              <option value="{{ $n->id }}">{{ $n->nama_nasabah }}</option>
            @endforeach
          </select>
        </div>

        <!-- Tanggal -->
        <div class="form-group mb-4">
          <label>Tanggal Setoran</label>
          <input type="date" name="tanggal_setoran" class="form-control" required>
        </div>

        <!-- Tabel Sampah -->
        <div class="table-responsive mb-3">
          <table class="table table-bordered align-middle" id="tabelSampah">
            <thead class="table-light">
              <tr>
                <th style="width: 35%">Jenis Sampah</th>
                <th style="width: 20%">Harga/kg</th>
                <th style="width: 20%">Berat (kg)</th>
                <th style="width: 20%">Jumlah (Rp)</th>
                <th style="width: 5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                {{-- <td>
                  <select name="sampah_id[]" class="form-control sampah-select" required>
                    <option value="">-- Pilih Sampah --</option>
                    @foreach ($sampah as $item)
                      <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_kg }}">
                        {{ $item->nama_sampah }} ({{ number_format($item->harga_per_kg, 0, ',', '.') }}/kg)
                      </option>
                    @endforeach
                  </select>
                </td> --}}

                <td>
                    <select name="sampah_id[]" class="form-control sampah-select" required>
                      <option value="">-- Pilih Sampah --</option>

                      @foreach ($sampah as $item)
                        <option 
                          value="{{ $item->id }}" 
                          data-harga="{{ $item->harga_per_kg }}"
                        >
                          {{ $item->nama_sampah }} ({{ number_format($item->harga_per_kg, 0, ',', '.') }}/kg)
                        </option>
                      @endforeach

                      <option value="manual">+ Tambah Sampah Manual</option>
                    </select>

                    <!-- input manual (hidden dulu) -->
                    <input 
                      type="text" 
                      name="sampah_manual[]" 
                      class="form-control mt-2 sampah-manual-input"
                      placeholder="Nama sampah manual"
                      style="display:none;"
                    >

                    
                  </td>


                <td>
                  <input type="text" class="form-control harga_per_kg" readonly>
                  {{-- Muncul ketika input sampah manual --}}
                  <input 
                    type="number" 
                    name="harga_manual[]" 
                    class="form-control harga-manual-input"
                    placeholder="Harga per kg"
                    style="display:none;"
                  >
                </td>
                <td><input type="number" name="berat_setor[]" step="0.01" class="form-control berat" required></td>
                <td><input type="text" name="jumlah_uang[]" class="form-control jumlah_uang" readonly></td>
                <td class="text-center">
                  <button type="button" class="btn btn-danger btn-sm hapus-baris">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="mb-4">
          <button type="button" class="btn btn-success btn-sm" id="tambahBaris">
            <i class="fas fa-plus"></i> Tambah Baris
          </button>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between">
          <a href="{{ route('setoran.index') }}" class="btn btn-secondary">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

document.addEventListener('change', function (e) {
  if (!e.target.classList.contains('sampah-select')) return

  const tr = e.target.closest('tr')

  const manualInput  = tr.querySelector('.sampah-manual-input')
  const hargaManual  = tr.querySelector('.harga-manual-input')
  const hargaAuto    = tr.querySelector('.harga_per_kg')

  if (e.target.value === 'manual') {
    // mode manual
    manualInput.style.display = 'block'
    hargaManual.style.display = 'block'
    hargaAuto.style.display   = 'none'

    manualInput.required = true
    hargaManual.required = true

    hargaAuto.value = ''
  } else {
    // mode dari master
    manualInput.style.display = 'none'
    hargaManual.style.display = 'none'
    hargaAuto.style.display   = 'block'

    manualInput.required = false
    hargaManual.required = false
    manualInput.value = ''
    hargaManual.value = ''

    const harga = e.target.selectedOptions[0]?.dataset?.harga || ''
    hargaAuto.value = harga
  }
})

document.addEventListener('DOMContentLoaded', function() {
  const tabel = document.querySelector('#tabelSampah tbody');
  const tambahBarisBtn = document.getElementById('tambahBaris');

  function hitungJumlah(row) {
    const harga = parseFloat(row.querySelector('.harga_per_kg').value) || parseFloat(row.querySelector('.harga-manual-input').value);
    const berat = parseFloat(row.querySelector('.berat').value) || 0;
    const jumlah = harga * berat;
    row.querySelector('.jumlah_uang').value = jumlah.toFixed(2);
  }

  function eventRow(row) {
    const select = row.querySelector('.sampah-select');
    const berat = row.querySelector('.berat');

    select.addEventListener('change', () => {
      const harga = select.options[select.selectedIndex].dataset.harga || 0;
      row.querySelector('.harga_per_kg').value = harga;
      hitungJumlah(row);
    });

    berat.addEventListener('input', () => hitungJumlah(row));

    row.querySelector('.hapus-baris').addEventListener('click', () => {
      if (document.querySelectorAll('#tabelSampah tbody tr').length > 1) {
        row.remove();
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Tidak Bisa Dihapus!',
          text: 'Minimal satu jenis sampah harus ada.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  // Tambah baris baru
  tambahBarisBtn.addEventListener('click', () => {
    const clone = tabel.querySelector('tr').cloneNode(true);
    clone.querySelectorAll('input').forEach(i => i.value = '');
    clone.querySelector('.sampah-select').selectedIndex = 0;
    tabel.appendChild(clone);
    eventRow(clone);
  });

  // Apply event pertama kali
  eventRow(tabel.querySelector('tr'));
});
</script>
@endpush
