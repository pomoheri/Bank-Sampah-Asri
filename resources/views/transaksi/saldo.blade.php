@extends('layout.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-wallet"></i> Informasi Saldo</h4>
                </div>
                <div class="card-body p-4">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-arrow-down text-success"></i> Total Setoran</span>
                            <span class="badge badge-success badge-pill">
                                Rp {{ number_format($total_setoran, 0, ',', '.') }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-arrow-up text-danger"></i> Total Tarik</span>
                            <span class="badge badge-danger badge-pill">
                                Rp {{ number_format($total_tarik, 0, ',', '.') }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-balance-scale text-primary"></i> Saldo</span>
                            <span class="badge badge-primary badge-pill">
                                <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong>
                            </span>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
