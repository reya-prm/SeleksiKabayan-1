<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Gudang;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BarangMasukController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();
        $barans = Barang::where('status_aktif', true)->get();
        $cart = session('barang_masuk_cart', []);

        return view('barang-masuk.index', compact('gudangs', 'barangs', 'cart'));
    }

    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'qty' => 'required|integer|min:1',
            'harga_beli' => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);
        $cart = session('barang_masuk_cart', []);

        $cart[$validated['barang_id']] = [
            'nama' => $barang->nama_barang,
            'qty' => $validated['qty'],
            'harga_beli' => $validated['harga_beli'],
        ];

        session(['barang_masuk_cart' => $cart]);

        return back()->with('success', $barang->nama_barang . 'ditambahkan ke daftar.');
    }

    public function hapusItem($barangId)
    {
        $cart = session('barang_masuk_cart', []);
        unset($cart[$barangId]);
        session(['barang_masuk_cart' => $cart]);

        return back();
    }

    public function store(Request $request)
    {
        $cart = session('barang_masuk_cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Belum ada barang yang ditambahkan.');
        }

        $validated = $request->validate([
            'gudang_id' => 'required|exists:gudangs, id',
            'keterangan' => 'nullable|string|max:225',
        ]);

        DB::transaction(function () use ($cart, $validated){
            $barangMasuk = BarangMasuk::create([
                'gudang_id' => $validated['gudang_id'],
            'user_id' => auth()->id(),
            'keterangan' => $validated['keterangan'] ?? null,
            ]);

        foreach ($cart as $barangId => $item) {

        $barangMasuk->detail()->create([
            'barang_id' => $barangId,
            'qty' => $item['qty'],
            'harga_beli' => $item['harga_beli'],
        ]);

        $stok = StokBarang::firstOrCreate(
            ['gudang_id' => $validated['gudang_id'], 'barang_id' => $barangId],
            ['qty' => 0]
        );

        $stok->increment('qty', $item['qty']);
        }

        });

        session()->forget('barang_masuk_cart');

        return redirect()->route('barang-masuk.index')->with('succes', 'Transaksi barang masuk berhasil disimpan.');
    }
}


