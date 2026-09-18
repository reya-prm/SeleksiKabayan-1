@extends('layouts.app')

@section('header_title', 'Riwayat Transaksi')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded bg-green-500 text-white p-3 text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">{{ session('error') }}</div>
    @endif

    <div class="space-y-4">
        @forelse ($data as $penjualan)
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-500">
                            #{{ $penjualan->id }} — {{ $penjualan->created_at->format('d/m/Y H:i') }}
                            — Gudang: {{ $penjualan->gudang->nama_gudang ?? '-' }}
                            — Kasir: {{ $penjualan->user->name ?? '-' }}
                            — Pelanggan: {{ $penjualan->pelanggan->nama ?? '-' }}
                        </p>
                        <p class="font-semibold text-gray-900">
                            Total: Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($penjualan->status === 'dibatalkan')
                            <span
                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Dibatalkan</span>
                        @else
                            <span
                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Selesai</span>
                            <form action="{{ route('barang.riwayat.batalkan', $penjualan->id) }}" method="POST"
                                onsubmit="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('patch')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <table class="w-full text-sm text-left text-gray-700 border-t border-gray-100 pt-2">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="py-1">Nama Barang</th>
                            <th class="py-1">Qty</th>
                            <th class="py-1">Harga Jual</th>
                            <th class="py-1">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->detail as $item)
                            <tr>
                                <td class="py-1">{{ $item->barang->nama_barang ?? 'Barang #' . $item->barang_id }}</td>
                                <td class="py-1">{{ $item->qty }}</td>
                                <td class="py-1">Rp {{ number_format($item->harga_jual_saat_transaksi, 0, ',', '.') }}
                                </td>
                                <td class="py-1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 text-center text-gray-400">
                Belum ada data riwayat transaksi.
            </div>
        @endforelse
    </div>
