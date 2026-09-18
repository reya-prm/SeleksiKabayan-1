<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();

        return view('gudang.index', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:225',
            'alamat' => 'nullable|string|max:255',
        ]);

        Gudang::create($validated);
        return redirect()->route('gudang.index')->with('success', 'Gudang Berhasil Ditambahkan.');
    }

    public function edit(string $id)
    {
        $gudangs = Gudang::all();
        $gudangDetail = Gudang::findOrFail($id);

        return view('gudang.index', compact('gudangs', 'gudangDetail'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:225',
            'alamat' => 'nullable|string|max:225',
        ]);

        Gudang::where('id', $id)->update($validated);

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $gudang = Gudang::findOrFail($id);

        if ($gudang->stokBarangs()->where('qty', '>', 0)->exists()) {
            return back()->with('error', 'Gudang ini masih punya stok barang, tidak bisa dihapus.');
        }

        $gudang->delete();

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil dihapus.');
    }
}
