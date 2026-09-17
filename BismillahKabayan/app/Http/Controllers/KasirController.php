<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $barang = Barang::where('status_aktif', true)->get();
        $cart = session('kasir_cart', []);

        return view('barang.kasir', compact('barang', 'cart'));
    }

    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'qty'       => 'required|integer|min:1',
        ]);

        $cart = session('kasir_cart', []);
        $barangId = $validated['barang_id'];

        // kalau barang yang sama ditambahin lagi, qty-nya numpuk
        $cart[$barangId] = ($cart[$barangId] ?? 0) + $validated['qty'];

        session(['kasir_cart' => $cart]);

        return back()->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function hapusItem(string $barangId)
    {
        $cart = session('kasir_cart', []);
        unset($cart[$barangId]);
        session(['kasir_cart' => $cart]);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function store(Request $request)
    {
        $cart = session('kasir_cart', []);

        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        DB::transaction(function () use ($cart) {
            $total = 0;
            $detailData = [];

            foreach ($cart as $barangId => $qty) {
                $barang = Barang::findOrFail($barangId);
                $subtotal = $barang->harga_jual * $qty;
                $total += $subtotal;

                $detailData[] = [
                    'barang_id'                 => $barang->id,
                    'qty'                       => $qty,
                    'harga_jual_saat_transaksi' => $barang->harga_jual,
                    'subtotal'                  => $subtotal,
                ];
            }

            $penjualan = Penjualan::create([
                'pelanggan_id' => null,
                'user_id'      => auth()->id(),
                'total_harga'  => $total,
            ]);

            $penjualan->detail()->createMany($detailData);
        });

        session()->forget('kasir_cart');

        return redirect()->route('barang.kasir')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function riwayat()
    {   
        $data = DetailPenjualan::with('barang')->latest()->get();
        return view('barang.riwayat', compact('data'));
    }

}