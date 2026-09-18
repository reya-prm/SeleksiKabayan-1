<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\StokBarang;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function dashboard()
    {
        $totalBarang = Barang::count();
        $totalGudang = Gudang::count();
        $totalPelanggan = Pelanggan::count();
        $totalPenjualanHariIni = Penjualan::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Stok terendah
        $stokTerendah = StokBarang::with('barang', 'gudang')
            ->orderBy('qty')
            ->take(5)
            ->get();

        return view('barang.dashboard', compact(
            'totalBarang',
            'totalGudang',
            'totalPelanggan',
            'totalPenjualanHariIni',
            'stokTerendah'
        ));
    }

    public function databarang()
    {
        $barang = Barang::all();

        return view('barang.databarang', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'sku'         => 'required|string|max:50|unique:barangs,sku',
            'nama_barang' => 'required|string|min:3',
            'kategori'    => 'required|string',
            'satuan'      => 'required|string',
            'harga_pokok' => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
        ]);

        $validate['status_aktif'] = $request->boolean('status_aktif');

        Barang::create($validate);

        return redirect()->route('barang.databarang')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::all();
        $editBarang = Barang::findOrFail($id);

        return view('barang.databarang', compact('barang', 'editBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'sku'         => 'required|string|max:50|unique:barangs,sku,' . $id,
            'nama_barang' => 'required|string|min:3',
            'kategori'    => 'required|string',
            'satuan'      => 'required|string',
            'harga_pokok' => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
        ]);

        $validate['status_aktif'] = $request->boolean('status_aktif');

        Barang::where('id', $id)->update($validate);

        return redirect()->route('barang.databarang')->with('success', 'Barang berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangDetail = Barang::findOrFail($id);
        $barangDetail->delete();

        return redirect()->route('barang.databarang')->with('success', 'Barang berhasil dihapus.');
    }
}
