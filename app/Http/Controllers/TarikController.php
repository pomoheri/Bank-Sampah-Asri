<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarik;
use App\Models\Nasabah;
use App\Models\Setoran;

class TarikController extends Controller
{
    public function index()
    {
        $tariks = Tarik::with(['nasabah'])
            ->orderBy('tanggal_tarik', 'desc')
            ->get();

        return view('tarik.index', compact('tariks'));
    }

    public function create()
    {
        $nasabah = Nasabah::all();
        return view('tarik.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_tarik' => 'required|date',
            'jumlah_uang_tarik' => 'required|numeric|min:0',
            'nasabah_id' => 'required',
        ]);

        $totalSetor = Setoran::where('nasabah_id', $request->nasabah_id)->sum('jumlah_uang');
        $totalTarik = Tarik::where('nasabah_id', $request->nasabah_id)->sum('jumlah_uang_tarik');

        $saldo = $totalSetor - $totalTarik;

        if ($request->jumlah_uang_tarik > $saldo) {
            return back()->withErrors([
                'jumlah_uang_tarik' => 'Jumlah tarik melebihi saldo tersedia'
            ]);
        }

        Tarik::create([
            'tanggal_tarik' => $request->tanggal_tarik,
            'jumlah_uang_tarik' => $request->jumlah_uang_tarik,
            'nasabah_id' => $request->nasabah_id,
        ]);

        return redirect()->route('tarik.index')->with('success', 'Penarikan berhasil disimpan.');
    }

   public function edit($id)
    {
        $tarik = Tarik::findOrFail($id);
        $nasabah = Nasabah::all();

        $totalSetor = Setoran::where('nasabah_id', $tarik->nasabah_id)
            ->sum('jumlah_uang');

        $totalTarik = Tarik::where('nasabah_id', $tarik->nasabah_id)
            ->sum('jumlah_uang_tarik');

        $saldo = ($totalSetor - $totalTarik) + $tarik->jumlah_uang_tarik;

        return view('tarik.edit', compact('tarik', 'nasabah', 'saldo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_tarik' => 'required|date',
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah_uang_tarik' => 'required|numeric|min:0',
        ]);

        $tarik = Tarik::findOrFail($id);
        $tarik->update([
            'tanggal_tarik' => $request->tanggal_tarik,
            'nasabah_id' => $request->nasabah_id,
            'jumlah_uang_tarik' => $request->jumlah_uang_tarik,
        ]);

        return redirect()->route('tarik.index')->with('success', 'Data tarik berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tarik = Tarik::findOrFail($id);
        $tarik->delete();

        return redirect()->route('tarik.index')->with('success', 'Data tarik berhasil dihapus');
    }

    public function report(Request $request)
    {
        $query = Tarik::with('nasabah');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_tarik', [$request->from, $request->to]);
        }

        $data = $query->orderBy('tanggal_tarik')->get();

        return view('tarik.report', compact('data'));
    }
    
    public function saldo($id)
    {
        $totalSetor = Setoran::where('nasabah_id', $id)->sum('jumlah_uang');
        $totalTarik = Tarik::where('nasabah_id', $id)->sum('jumlah_uang_tarik');

        $saldo = $totalSetor - $totalTarik;

        return response()->json([
            'saldo' => $saldo
        ]);
    }
}
