@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Laporan Setoran</h3>
        <form method="GET" action="{{ route('setoran.report') }}" class="row mb-3">
            <div class="col-md-3"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-md-3"><input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('setoran.report') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nasabah</th>
                    <th>Sampah</th>
                    <th>Berat (kg)</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->tanggal_setoran }}</td>
                        <td>{{ $item->nasabah->nama_nasabah ?? '-' }}</td>
                        <td>{{ $item->sampah->nama_sampah ?? '-' }}</td>
                        <td>{{ $item->berat_setor }}</td>
                        <td>Rp {{ number_format($item->jumlah_uang) }}</td>
                    </tr>
                    @php $total += $item->jumlah_uang; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <th>Rp {{ number_format($total) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
