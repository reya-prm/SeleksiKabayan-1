@extends('layouts.app')

@section('header_title', 'Kasir / Transaksi')

@section('content')
    {{-- Notifikasi Flash --}}
    @if (session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg p-4 text-sm font-medium mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-4 text-sm font-medium mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Item ke Keranjang -->
        <div class="lg:col-span-1 bg-white p-6 rounded-lg border border-gray-200 shadow-sm h-fit">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Pilih Barang</h2>
            <form action="{{ route('barang.kasir.tambah') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                    <select name="barang_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_barang }} — Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Qty)</label>
                    <input type="number" name="qty" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    + Tambah ke Keranjang
                </button>
            </form>
        </div>

        <!-- Tabel Keranjang Belanja -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-200 shadow-sm space-y-6">
            <h2 class="text-lg font-semibold text-gray-800">Keranjang Belanja</h2>

            @php
                // Index koleksi barang berdasarkan ID untuk kemudahan pencarian di view
                $barangKeyed = $barang->keyBy('id');
                $grandTotal = 0;
            @endphp

            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 font-medium">Barang</th>
                            <th class="px-4 py-3 font-medium">Harga</th>
                            <th class="px-4 py-3 font-medium">Qty</th>
                            <th class="px-4 py-3 font-medium">Subtotal</th>
                            <th class="px-4 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart as $barangId => $qty)
                            @php
                                $item = $barangKeyed->get($barangId);
                            @endphp

                            @if ($item)
                                @php
                                    $subtotal = $item->harga_jual * $qty;
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama_barang }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $qty }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('barang.kasir.hapus', $barangId) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                    Keranjang masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total dan Selesaikan Transaksi -->
            @if (!empty($cart))
                <div class="border-t border-gray-200 pt-4 space-y-4">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span class="text-gray-800">Total Transaksi</span>
                        <span class="text-green-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('barang.kasir.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white font-medium py-2.5 rounded-lg hover:bg-green-700 transition">
                            Proses & Simpan Transaksi
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection