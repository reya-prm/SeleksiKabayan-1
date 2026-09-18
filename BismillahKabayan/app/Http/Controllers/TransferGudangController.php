<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\StokBarang;
use App\Models\TransferGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferGudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();
        $barangs = Barang::where('status_aktif', true)->get();
        $cart = session('transfer_cart', []);

        return view('transfer-gudang.index', compact('gudangs', 'barangs', 'cart'));
    }

    /**
     * Tambah 1 barang ke daftar sementara (session). Belum dieksekusi.
     */
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);
        $cart = session('transfer_cart', []);

        $cart[$validated['barang_id']] = [
            'nama' => $barang->nama_barang,
            'qty' => $validated['qty'],
        ];

        session(['transfer_cart' => $cart]);

        return back()->with('success', $barang->nama_barang . ' ditambahkan ke daftar transfer.');
    }

    public function hapusItem($barangId)
    {
        $cart = session('transfer_cart', []);
        unset($cart[$barangId]);
        session(['transfer_cart' => $cart]);

        return back();
    }

    /**
     * Eksekusi transfer: validasi gudang beda, cek stok cukup di gudang asal
     * (dengan lock, biar gak race condition), lalu pindahkan stoknya.
     */
    public function store(Request $request)
    {
        $cart = session('transfer_cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Belum ada barang yang ditambahkan.');
        }

        $validated = $request->validate([
            'gudang_asal_id' => 'required|exists:gudangs,id',
            'gudang_tujuan_id' => 'required|exists:gudangs,id|different:gudang_asal_id',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'gudang_tujuan_id.different' => 'Gudang tujuan tidak boleh sama dengan gudang asal.',
        ]);

        try {
            DB::transaction(function () use ($cart, $validated) {
                $transfer = TransferGudang::create([
                    'gudang_asal_id' => $validated['gudang_asal_id'],
                    'gudang_tujuan_id' => $validated['gudang_tujuan_id'],
                    'user_id' => auth()->id(),
                    'keterangan' => $validated['keterangan'] ?? null,
                ]);

                foreach ($cart as $barangId => $item) {
                    $stokAsal = StokBarang::where('gudang_id', $validated['gudang_asal_id'])
                        ->where('barang_id', $barangId)
                        ->lockForUpdate()
                        ->first();

                    if (!$stokAsal || $stokAsal->qty < $item['qty']) {
                        $tersedia = $stokAsal->qty ?? 0;
                        throw new \Exception("Stok {$item['nama']} di gudang asal tidak mencukupi (tersedia: {$tersedia}, diminta: {$item['qty']}).");
                    }

                    $transfer->detail()->create([
                        'barang_id' => $barangId,
                        'qty' => $item['qty'],
                    ]);

                    $stokAsal->decrement('qty', $item['qty']);

                    $stokTujuan = StokBarang::firstOrCreate(
                        ['gudang_id' => $validated['gudang_tujuan_id'], 'barang_id' => $barangId],
                        ['qty' => 0]
                    );
                    $stokTujuan->increment('qty', $item['qty']);
                }
            });
        } catch (\Exception $e) {
            // Exception di dalam DB::transaction otomatis nge-rollback semua perubahan,
            // di sini cuma nangkep pesannya biar ditampilin rapi, bukan jadi 500 error
            return back()->with('error', $e->getMessage());
        }

        session()->forget('transfer_cart');

        return redirect()->route('transfer-gudang.index')->with('success', 'Transfer barang berhasil disimpan.');
    }
}
