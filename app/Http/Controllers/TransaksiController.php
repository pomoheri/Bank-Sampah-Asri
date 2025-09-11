<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Tarik;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['setoran', 'tarik']); // Tetap gunakan eager loading relasi

        // Tambahkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('setoran_id', 'like', "%$search%")
                    ->orWhere('tarik_id', 'like', "%$search%")
                    ->orWhere('saldo', 'like', "%$search%");
            });
        }

        // Lanjutkan dengan pagination
        $transaksis = $query->orderByDesc('created_at')->paginate(10);

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
