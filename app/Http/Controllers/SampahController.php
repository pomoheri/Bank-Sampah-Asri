<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index()
    {
        $sampahs = Sampah::orderBy('created_at', 'desc')->get();
        return view('sampah.index', compact('sampahs'));
    }

    public function create()
    {
        return view('sampah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sampah'   => 'required|string|max:255',
            'jenis_sampah'  => 'required|string|max:255',
            'harga_per_kg'  => 'required|numeric|min:0',
        ]);

        Sampah::create($request->all());

        return redirect()->route('sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function show(Sampah $sampah)
    {
        return view('sampah.show', compact('sampah'));
    }

    public function edit(Sampah $sampah)
    {
        return view('sampah.edit', compact('sampah'));
    }

    public function update(Request $request, Sampah $sampah)
    {
        $request->validate([
            'nama_sampah'   => 'required|string|max:255',
            'jenis_sampah'  => 'required|string|max:255',
            'harga_per_kg'  => 'required|numeric|min:0',
        ]);

        $sampah->update($request->all());

        return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil diperbarui.');
    }

    public function destroy(Sampah $sampah)
    {
        $sampah->delete();

        return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil dihapus.');
    }
}
