@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Laporan Tarik Saldo</h3>
        <form method="GET" action="{{ route('tarik.report') }}" class="row mb-3">
            <div class="col-md-3"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-md-3"><input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('tarik.report') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nasabah</th>
                    <th>Jumlah Tarik</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->tanggal_tarik }}</td>
                        <td>{{ $item->nasabah->nama_nasabah ?? '-' }}</td>
                        <td>Rp {{ number_format($item->jumlah_uang_tarik) }}</td>
                    </tr>
                    @php $total += $item->jumlah_uang_tarik; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>Rp {{ number_format($total) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
