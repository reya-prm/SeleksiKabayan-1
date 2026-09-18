@extends('layouts.app')

@section('header_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Total Barang</p>
            <p class="text-2xl font-bold">{{ $totalBarang }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Total Gudang</p>
            <p class="text-2xl font-bold">{{ $totalGudang }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Total Pelanggan</p>
            <p class="text-2xl font-bold">{{ $totalPelanggan }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">Barang dengan Stok Terendah</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Barang</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Gudang</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokTerendah as $s)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $s->barang->nama_barang ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $s->gudang->nama_gudang ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 {{ $s->qty == 0 ? 'text-red-600 font-semibold' : '' }}">{{ $s->qty }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-4 py-4 text-center text-gray-500">Belum ada data stok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection