@extends('layouts.app')

@section('header_title', 'Dashboard Ringkasan')

@section('content')
    <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200 text-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">SKU</th>
                    <th scope="col" class="px-6 py-3 font-medium">Nama Barang</th>
                    <th scope="col" class="px-6 py-3 font-medium">Kategori</th>
                    <th scope="col" class="px-6 py-3 font-medium">Satuan</th>
                    <th scope="col" class="px-6 py-3 font-medium">Harga Jual</th>
                    <th scope="col" class="px-6 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $item)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-gray-900">{{ $item->sku }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-4">{{ $item->kategori }}</td>
                        <td class="px-6 py-4">{{ $item->satuan }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $item->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">Belum ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection