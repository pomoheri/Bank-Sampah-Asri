<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
