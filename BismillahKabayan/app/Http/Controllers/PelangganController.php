<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();

        return view('pelanggan.index', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:225',
            'nomor_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pelanggans = Pelanggan::all();
        $pelangganDetail = Pelanggan::findOrFail($id);

        return view('pelanggan.index', compact('pelanggans', 'pelangganDetail'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:225',
            'nomor_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Pelanggan::where('id', $id)->update($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Dicegah hapus pelanggan yang masih punya riwayat penjualan, biar transaksi lama gak "menggantung"
        if ($pelanggan->penjualans()->exists()) {
            return back()->with('error', 'Pelanggan ini masih punya riwayat transaksi, tidak bisa dihapus.');
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
