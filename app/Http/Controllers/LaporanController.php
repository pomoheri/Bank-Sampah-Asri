<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nasabah;
use App\Models\Setoran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function saldo(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $subSetor = DB::table('setorans')
                        ->selectRaw('SUM(jumlah_uang) as jumlah_setor, nasabah_id')
                        ->groupBy('nasabah_id');

        $subTarik = DB::table('tariks')
                        ->selectRaw('SUM(jumlah_uang_tarik) as jumlah_tarik, nasabah_id')
                        ->groupBy('nasabah_id');

        $query = DB::table('nasabahs as a')
                    ->select(
                        'a.user_id',
                        'a.nama_nasabah',
                        'b.jumlah_setor',
                        'c.jumlah_tarik',
                        DB::raw('COALESCE(b.jumlah_setor,0) - COALESCE(c.jumlah_tarik,0) as saldo')
                    )
                    ->leftJoinSub($subSetor, 'b', function ($join) {
                        $join->on('a.id', '=', 'b.nasabah_id');
                    })
                    ->leftJoinSub($subTarik, 'c', function ($join) {
                        $join->on('a.id', '=', 'c.nasabah_id');
                    });
        
        if($role == 'nasabah') {
            $query->where('user_id', $user->id);
        }

        // Tambahkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_nasabah', 'like', '%'.$request->search.'%');
        }
        

        // Lanjutkan dengan pagination
        $transaksis = $query->orderByDesc('nama_nasabah')->paginate(10);

        return view('laporan.saldo.index', compact('transaksis'));
    }

    public function lapTransaksi(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Query setor
        $setor = DB::table('setorans')
            ->select(
                'id',
                'nasabah_id',
                DB::raw("tanggal_setoran as tanggal"),
                DB::raw("'setor' as jenis"),
                'jumlah_uang as nominal'
            );

        // Query tarik
        $tarik = DB::table('tariks')
            ->select(
                'id',
                'nasabah_id',
                DB::raw("tanggal_tarik as tanggal"),
                DB::raw("'tarik' as jenis"),
                'jumlah_uang_tarik as nominal'
            );

        // Filter untuk nasabah
        if ($role == 'nasabah') {
            $nasabah = Nasabah::where('user_id', $user->id)->first();
            $setor->where('nasabah_id', $nasabah->id);
            $tarik->where('nasabah_id', $nasabah->id);
        }

        // Union query
        $query = $setor->unionAll($tarik);

        // Ambil data dan urutkan
        $transaksis = DB::query()
            ->fromSub($query, 'transaksis')
            ->orderBy('tanggal', 'asc') // pakai alias tanggal
            ->get();

        // Hitung saldo berjalan
        $saldo = 0;
        foreach ($transaksis as $trx) {
            if ($trx->jenis == 'setor') {
                $saldo += $trx->nominal;
            } else {
                $saldo -= $trx->nominal;
            }
            $trx->saldo_setelah = $saldo;
        }

        // Balik lagi ke pagination manual
        $page = request('page', 1);
        $perPage = 10;
        $transaksis = new \Illuminate\Pagination\LengthAwarePaginator(
            $transaksis->forPage($page, $perPage),
            $transaksis->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        return view('laporan.transaksi.index', compact('transaksis'));
    }

    public function rekapSetoran(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $date = $request->date ?? date('Y-m-d');

        $setor = Setoran::selectRaw('
                        sampah_id,
                        SUM(berat_setor) as total_berat,
                        SUM(jumlah_uang) as total_nominal
                    ')
                    ->with('sampah')
                    ->where('tanggal_setoran', $date)
                    ->groupBy('sampah_id')
                    ->get();

        $totalBerat = $setor->sum('total_berat');
        $totalNominal = $setor->sum('total_nominal');

        return view('laporan.rekap-setoran.index', compact('date','setor','totalBerat','totalNominal'));
    }

    public function downloadRekapSetoran(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');

        $setor = Setoran::selectRaw('
                        sampah_id,
                        SUM(berat_setor) as total_berat,
                        SUM(jumlah_uang) as total_nominal
                    ')
                    ->with('sampah')
                    ->where('tanggal_setoran', $tanggal)
                    ->groupBy('sampah_id')
                    ->get();

        $totalBerat = $setor->sum('total_berat');
        $totalNominal = $setor->sum('total_nominal');


        $pdf = Pdf::loadView('pdf.rekap-setoran', [
            'tanggal'       => Carbon::parse($tanggal)->format('d/m/Y'),
            'data'          => $setor,
            'total_berat'   => $totalBerat,
            'total_nominal'   => $totalNominal,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('rekap-setoran-'.$tanggal.'.pdf');
    }
}
