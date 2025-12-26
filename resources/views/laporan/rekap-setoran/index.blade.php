@extends('layout.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">

                <!-- KIRI: Judul -->
                <h4 class="mb-0">
                    <i class="fas fa-exchange-alt"></i>
                    Rekap Setoran {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                </h4>

                <!-- KANAN: Filter + Button -->
                <div class="d-flex align-items-center gap-2">

                    <form 
                        action="{{ route('laporan.rekap-setoran') }}" 
                        method="GET"
                        class="d-flex align-items-center gap-2"
                    >
                        <label class="mb-0 fw-semibold text-white-50">
                            Tanggal
                        </label>

                        <input 
                            type="date" 
                            name="date"
                            class="form-control form-control-sm ml-2"
                            style="width: 150px"
                            value="{{ request('date', $date) }}"
                            required
                        >

                        <button type="submit" class="btn btn-sm btn-info ml-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                    </form>

                    <a 
                        class="btn btn-sm btn-success ml-2"
                        href="{{ route('laporan.rekap-setoran.download', ['tanggal' => request('date', $date)]) }}"
                    >
                        <i class="fas fa-download"></i>
                        Download PDF
                    </a>

                </div>
            </div>

        </div>


        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row mb-3">
                <!-- Total Berat -->
                <div class="col-md-6 mb-2">
                    <div class="card border-left-success shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                        <div class="text-muted small text-uppercase">
                            Total Berat Setor
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-success">
                            {{ number_format($totalBerat, 2, ',', '.') }} Kg
                        </div>
                        </div>
                        <div class="text-success opacity-75">
                        <i class="fas fa-weight fa-2x"></i>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Total Nominal -->
                <div class="col-md-6 mb-2">
                    <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                        <div class="text-muted small text-uppercase">
                            Total Nominal Setoran
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-primary">
                            Rp {{ number_format($totalNominal, 2, ',', '.') }}
                        </div>
                        </div>
                        <div class="text-primary opacity-75">
                        <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table id="nasabahTable" 
                       class="table table-striped table-bordered table-hover nowrap w-100">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Sampah</th>
                            <th width="20%">Total Berat (Kg/Pcs)</th>
                            <th width="25%">Total Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($setor as $i => $row)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $row->sampah->nama_sampah ?? '-' }}</td>
                                <td class="text-right">
                                    {{ number_format($row->total_berat, 2, ',', '.') }}
                                </td>
                                <td class="text-right">
                                    Rp {{ number_format($row->total_nominal, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css"/>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function () {
        $('#nasabahTable').DataTable({
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: -1 } // kolom aksi tidak ikut sorting
            ],
            language: {
                sEmptyTable:   "Tidak ada data Transaksi",
                sInfo:         "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                sInfoEmpty:    "Menampilkan 0 - 0 dari 0 data",
                sInfoFiltered: "(difilter dari _MAX_ total data)",
                sLengthMenu:   "Tampilkan _MENU_ data",
                sLoadingRecords: "Loading...",
                sProcessing:   "Memproses...",
                sSearch:       "Cari:",
                sZeroRecords:  "Tidak ada data yang cocok",
                oPaginate: {
                    sFirst:    "Pertama",
                    sLast:     "Terakhir",
                    sNext:     "Selanjutnya",
                    sPrevious: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
