<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        $cart = session('cart', []);
        return view('barang.kasir', compact('barang', 'cart'));
    }

    public function addToCart($id)
    {
        $barang = Barang::findOrFail($id);
        $cart = session('cart', []);

        if ($barang->stok < 1) {
            return back()->with('error', 'Stok sudah habis');
        }

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] + 1 > $barang->stok) {
                return back()->with('error', 'Stok sudah habis');
            }
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'nama' => $barang->nama,
                'harga' => $barang->harga,
                'qty' => 1,
            ];
        }
        session(['cart' => $cart]);
        return back();
    }

    public function removeFromCart($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back();
    }

    public function checkOut(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        foreach ($cart as $id => $item) {
            $barang = Barang::findOrFail($id);
            if (!$barang || $barang->stok < $item['qty']) {
                return back()->with('error', 'Stok tidak mencukupi untuk ' . $item['nama']);
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        if ($request->bayar < $total) {
            return back()->with('error', 'Uang Tidak Cukup!');
        }

        // simpan riwayat pembelian
        Transaksi::create([
            'items' => $cart,
            'total' => $total,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
        ]);

        foreach ($cart as $id => $item) {
            Barang::find($id)->decrement('stok', $item['qty']);
        }

        session()->forget('cart');
        return back()->with('success', 'Transaksi berhasil disimpan.');
    }

    public function riwayat()
    {
        $transaksis = Transaksi::latest()->get();
        return view('barang.riwayat', compact('transaksis'));
    }
}