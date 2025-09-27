<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Sampah;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function index()
    {
        $data = Setoran::with(['nasabah', 'sampah'])
            ->orderBy('tanggal_setoran', 'desc')
            ->paginate(10); // bisa diganti sesuai jumlah per halaman

        return view('setoran.index', compact('data'));
    }
    public function create()
    {
        $sampah = Sampah::all();
        $nasabah = Nasabah::all();
        return view('setoran.create', compact('sampah', 'nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_setoran' => 'required|date',
            'sampah_id' => 'required',
            'berat_setor' => 'required|numeric|min:0.1',
            'nasabah_id' => 'required',
        ]);

        $sampah = Sampah::findOrFail($request->sampah_id);
        $jumlah_uang = $request->berat_setor * $sampah->harga_per_kg;

        Setoran::create([
            'tanggal_setoran' => $request->tanggal_setoran,
            'sampah_id' => $request->sampah_id,
            'berat_setor' => $request->berat_setor,
            'jumlah_uang' => $jumlah_uang,
            'nasabah_id' => $request->nasabah_id,
        ]);

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil disimpan');
    }

    public function edit(Setoran $setoran)
    {
        $nasabah = Nasabah::all();             // untuk select nasabah
        $sampah  = Sampah::all();              // untuk select sampah

        return view('setoran.edit', compact('setoran', 'nasabah', 'sampah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nasabah_id'      => 'required|exists:nasabahs,id',
            'tanggal_setoran' => 'required|date',
            'sampah_id'       => 'required|exists:sampahs,id',
            'berat_setor'     => 'required|numeric|min:0.01',
        ]);

        $sampah = Sampah::findOrFail($request->sampah_id);
        $jumlah_uang = $request->berat_setor * $sampah->harga_per_kg;

        $setoran = Setoran::findOrFail($id);
        $setoran->update([
            'nasabah_id'      => $request->nasabah_id,
            'tanggal_setoran' => $request->tanggal_setoran,
            'sampah_id'       => $request->sampah_id,
            'berat_setor'     => $request->berat_setor,
            'jumlah_uang'     => $jumlah_uang,
        ]);

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil diperbarui.');
    }

    public function destroy(Setoran $setoran)
    {
        $setoran->delete();

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dihapus.');
    }



    public function report(Request $request)
    {
        $query = Setoran::with(['nasabah', 'sampah']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_setoran', [$request->from, $request->to]);
        }

        $data = $query->orderBy('tanggal_setoran')->get();
        return view('setoran.report', compact('data'));
    }
}
