<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarik;
use App\Models\Nasabah;

class TarikController extends Controller
{
    public function index()
    {
        $tariks = Tarik::with(['nasabah'])
            ->orderBy('tanggal_tarik', 'desc')
            ->paginate(10) // bisa diganti sesuai jumlah per halaman
            ->withQueryString(); // pastikan ini dipanggil saat masih QueryBuilder

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

        return view('tarik.edit', compact('tarik', 'nasabah'));
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
    //
}
