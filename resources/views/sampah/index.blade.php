@extends('layout.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-trash"></i> Data Sampah</h4>
            <a href="{{ route('sampah.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Sampah
            </a>
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
                            <th>Nama Sampah</th>
                            <th>Jenis Sampah</th>
                            <th>Harga Per Kg (Rp)</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sampahs as $sampah)
                            <tr>
                                <td>{{ $sampah->nama_sampah }}</td>
                                <td>{{ $sampah->jenis_sampah }}</td>
                                <td class="text-right">{{ number_format($sampah->harga_per_kg,'2',',','.') }}</td>
                                <td>
                                    <a href="{{ route('sampah.edit', $sampah->id) }}" 
                                       class="btn btn-warning btn-sm mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('sampah.destroy', $sampah->id) }}" 
                                          method="POST" class="d-inline form-hapus">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
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
                sEmptyTable:   "Tidak ada data Sampah",
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


        // SweetAlert hapus
        $(document).on('click', '.btn-hapus', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data Sampah akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
