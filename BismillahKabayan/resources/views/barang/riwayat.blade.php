@extends('layouts.app')

@section('header_title', 'Riwayat Transaksi')

@section('content')
    <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200 text-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">Nama Barang</th>
                    <th scope="col" class="px-6 py-3 font-medium">Qty</th>
                    <th scope="col" class="px-6 py-3 font-medium">Harga Jual</th>
                    <th scope="col" class="px-6 py-3 font-medium">SubTotal</th>
                    <th scope="col" class="px-6 py-3 font-medium">Tanggal Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        {{-- Mengambil nama barang dari relasi --}}
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $item->barang->nama_barang ?? 'Barang #' . $item->barang_id }}
                        </td>
                        <td class="px-6 py-4">{{ $item->qty }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->harga_jual_saat_transaksi, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada data riwayat transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection