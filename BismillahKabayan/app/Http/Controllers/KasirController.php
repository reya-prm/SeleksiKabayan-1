<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Gudang;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        // 1. Mengambil barang aktif sekaligus menghitung total stok dari relasi stokBarang
        $barang = Barang::where('status_aktif', true)
            ->withSum('stokBarang as total_stok', 'qty')
            ->get();

        $gudangs = Gudang::all();
        $pelanggans = Pelanggan::all();
        $cart = session('kasir_cart', []);

        return view('barang.kasir', compact('barang', 'gudangs', 'pelanggans', 'cart'));
    }

    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'qty'       => 'required|integer|min:1',
        ]);

        $cart = session('kasir_cart', []);
        $barangId = $validated['barang_id'];

        // Mengisi session cart dengan format [barang_id => jumlah_qty]
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
            return back()->with('error', 'Belum ada barang di dalam keranjang.');
        }
        
        $validated = $request->validate([
            'gudang_id'    => 'required|exists:gudangs,id',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
        ]);

        try {
            DB::transaction(function () use ($cart, $validated) {
                $total = 0;

                $penjualan = Penjualan::create([
                    'gudang_id'    => $validated['gudang_id'],
                    'pelanggan_id' => $validated['pelanggan_id'] ?? null,
                    'user_id'      => auth()->id(),
                    'total_harga'  => 0,
                ]);

                // Loop session cart [barang_id => qty]
                foreach ($cart as $barangId => $qty) {
                    $barang = Barang::findOrFail($barangId);

                    // Cek Stok Barang di Gudang yang Dipilih
                    // lockForUpdate() mencegah race condition (stok negatif saat ada transaksi bersamaan)
                    $stok = StokBarang::where('gudang_id', $validated['gudang_id'])
                        ->where('barang_id', $barang->id)
                        ->lockForUpdate()
                        ->first();

                    $tersedia = $stok?->qty ?? 0;

                    // Jika stok kosong atau kurang dari yang diminta
                    if (!$stok || $stok->qty < $qty) {
                        throw new \Exception("Stok {$barang->nama_barang} di gudang ini tidak mencukupi (tersedia: {$tersedia}, diminta: {$qty}).");
                    }

                    // Kurangi Stok
                    $stok->decrement('qty', $qty);

                    $subtotal = $barang->harga_jual * $qty;
                    $total += $subtotal;

                    // Simpan Detail Penjualan (snapshot harga saat transaksi)
                    $penjualan->detail()->create([
                        'barang_id'                 => $barang->id,
                        'qty'                       => $qty,
                        'harga_jual_saat_transaksi' => $barang->harga_jual,
                        'subtotal'                  => $subtotal,
                    ]);
                }

                // Update Total Harga Transaksi
                $penjualan->update(['total_harga' => $total]);
            });

            // Hapus Keranjang Setelah Transaksi Berhasil
            session()->forget('kasir_cart');

            return redirect()->route('barang.kasir')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function riwayat()
    {
        $data = Penjualan::with(['detail.barang', 'gudang', 'user'])->latest()->get();

        return view('barang.riwayat', compact('data'));
    }

    public function batalkan(string $id)
    {
        $penjualan = Penjualan::with('detail')->findOrFail($id);

        // Cek jika gudang_id tidak valid/kosong
        if (!$penjualan->gudang_id) {
            return back()->with('error', 'Gagal membatalkan: Transaksi ini tidak terikat dengan gudang manapun.');
        }

        if ($penjualan->status === 'dibatalkan') {
            return back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->detail as $item) {
                $stok = StokBarang::where('gudang_id', $penjualan->gudang_id)
                    ->where('barang_id', $item->barang_id)
                    ->first();

                if ($stok) {
                    $stok->increment('qty', $item->qty);
                } else {
                    StokBarang::create([
                        'gudang_id' => $penjualan->gudang_id,
                        'barang_id' => $item->barang_id,
                        'qty'       => $item->qty,
                    ]);
                }
            }

            $penjualan->update(['status' => 'dibatalkan']);
        });

        return back()->with('success', 'Transaksi berhasil dibatalkan, stok sudah dikembalikan.');
    }
}
