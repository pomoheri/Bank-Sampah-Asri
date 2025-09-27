@extends('layout.master')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Bank Sampah</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info Boxes -->
      <div class="row">

        <!-- Total Setoran -->
        <div class="col-12 col-md-6 col-lg-4 mb-3">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>Rp {{ number_format($setoran, 2, ',', '.') }}</h3>
              <p>Total Setoran</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-down"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Total Penarikan -->
        <div class="col-12 col-md-6 col-lg-4 mb-3">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>Rp {{ number_format($tarik, 2, ',', '.') }}</h3>
              <p>Total Penarikan</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-up"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Saldo -->
        <div class="col-12 col-md-6 col-lg-4 mb-3">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>Rp {{ number_format($saldo, 2, ',', '.') }}</h3>
              <p>Saldo Bank Sampah</p>
            </div>
            <div class="icon"><i class="fas fa-wallet"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
@endsection
