@extends('layout.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-file"></i> Lap Transaksi</h4>
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

            <div class="table-responsive">
                <table id="nasabahTable" 
                       class="table table-striped table-bordered table-hover nowrap w-100">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Transaksi</th>
                            <th>Nominal (Rp)</th>
                            <th>Saldo Setelah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $trans)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($trans->tanggal)->format('d F Y') }}</td>
                                 <td>
                                    @if($trans->jenis === 'setor')
                                        <span class="badge bg-success"><i class="fas fa-arrow-down"></i> {{ $trans->jenis }}</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-arrow-up"></i> {{ $trans->jenis }}</span>
                                    @endif
                                </td>
                                <td class="text-right">{{ number_format($trans->nominal,'2',',','.') }}</td>
                                <td class="text-right">{{ number_format($trans->saldo_setelah,'2',',','.') }}</td>
                            </tr>
                        @empty
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
