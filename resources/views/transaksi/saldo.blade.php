@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Informasi Saldo</h3>
        <ul class="list-group">
            <li class="list-group-item">Total Setoran: Rp {{ number_format($total_setoran) }}</li>
            <li class="list-group-item">Total Tarik: Rp {{ number_format($total_tarik) }}</li>
            <li class="list-group-item">Saldo: <strong>Rp {{ number_format($saldo) }}</strong></li>
        </ul>
    </div>
@endsection
