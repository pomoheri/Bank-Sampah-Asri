@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Laporan Transaksi</h3>
        <form method="GET" action="{{ route('transaksi.report') }}" class="row mb-3">
            <div class="col-md-3"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-md-3"><input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('transaksi.report') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Setoran ID</th>
                    <th>Tarik ID</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->setoran_id ?? '-' }}</td>
                        <td>{{ $item->tarik_id ?? '-' }}</td>
                        <td>Rp {{ number_format($item->saldo) }}</td>
                    </tr>
                    @php $total += $item->saldo; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp {{ number_format($total) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
