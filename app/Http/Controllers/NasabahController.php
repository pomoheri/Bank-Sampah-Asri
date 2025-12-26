<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\User;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::orderBy('created_at', 'desc')->get();
        return view('nasabah.index', compact('nasabahs'));
    }

    public function create()
    {
        $users = User::all(); // ambil semua user
        return view('nasabah.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_nasabah' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id',
        ]);

        Nasabah::create([
            'nama_nasabah' => $request->nama_nasabah,
            'no_hp' => $request->no_hp,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah)
    {
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah)
    {
        $users = User::all(); // ambil semua user
        return view('nasabah.edit', compact('nasabah','users'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $request->validate([
            'nama_nasabah'       => 'required|string|max:255',
            'no_hp'      => 'required|string|max:15',
        ]);

        $nasabah->update($request->all());

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil dihapus.');
    }
}
