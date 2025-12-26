<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Setoran {{ $tanggal }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
        }

        .summary {
            margin-bottom: 15px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-data th, 
        .table-data td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .table-data th {
            background: #f2f2f2;
            text-align: center;
        }

        .table-data td {
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN REKAP SETORAN SAMPAH</h2>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td width="50%">
                    <strong>Total Berat Setoran</strong><br>
                    {{ number_format($total_berat, 2, ',', '.') }} Kg
                </td>
                <td width="50%">
                    <strong>Total Nominal Setoran</strong><br>
                    Rp {{ number_format($total_nominal, 2, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Sampah</th>
                <th width="15%">Berat (Kg/Pcs)</th>
                <th width="25%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $trans)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $trans->sampah ? $trans->sampah->nama_sampah : '-' }}</td>
                    <td class="right">{{ number_format($trans->total_berat,'2',',','.') }}</td>
                    <td class="right">{{ number_format($trans->total_nominal,'2',',','.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center">
                        Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Bank Sampah Digital
    </div>

</body>
</html>
