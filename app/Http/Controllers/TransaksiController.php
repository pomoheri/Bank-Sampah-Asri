<?php

namespace App\Http\Controllers;

use App\Models\Tarik;
use App\Models\Setoran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // $query = Transaksi::with(['setoran', 'tarik']); // Tetap gunakan eager loading relasi

        $setor = DB::table('nasabahs as a')
                    ->selectRaw("'SETOR' as jenis, a.nama_nasabah, b.tanggal_setoran as tanggal, b.berat_setor, b.jumlah_uang")
                    ->leftJoin('setorans as b', 'a.id', '=', 'b.nasabah_id');

        $tarik = DB::table('nasabahs as a')
            ->selectRaw("'TARIK' as jenis, a.nama_nasabah, b.tanggal_tarik as tanggal, 0 as berat_setor, b.jumlah_uang_tarik as jumlah_uang")
            ->leftJoin('tariks as b', 'a.id', '=', 'b.nasabah_id');

        // Tambahkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $setor->where('nama_nasabah', 'like', '%'.$request->search.'%');
            $tarik->where('nama_nasabah', 'like', '%'.$request->search.'%');
        }
        
        $query = $setor->unionAll($tarik);


        // Lanjutkan dengan pagination
        $transaksis = $query->orderByDesc('tanggal')->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }


    public function saldo()
    {
        $total_setoran = Setoran::sum('jumlah_uang');
        $total_tarik = Tarik::sum('jumlah_uang_tarik');
        $saldo = $total_setoran - $total_tarik;

        return view('transaksi.saldo', compact('total_setoran', 'total_tarik', 'saldo'));
    }
    //


    public function report(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $data = $query->orderBy('created_at')->get();

        return view('transaksi.report', compact('data'));
    }
}
