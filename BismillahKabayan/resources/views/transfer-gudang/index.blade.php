@extends('layouts.app')

@section('header_title', 'Transfer Antar Gudang')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Transfer Barang Antar Gudang</h1>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-500 text-white p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form tambah barang ke daftar sementara --}}
        <div class="bg-white rounded shadow p-4 mb-6">
            <h2 class="font-semibold mb-3">Tambah Barang</h2>
            <form action="{{ route('transfer-gudang.tambah') }}" method="POST" class="flex gap-2 items-end flex-wrap">
                @csrf
                <div>
                    <label class="block text-xs font-medium">Barang</label>
                    <select name="barang_id" required class="rounded border border-gray-300 px-2 py-1 text-sm">
                        @foreach ($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->sku }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium">Qty</label>
                    <input type="number" name="qty" min="1" required class="w-20 rounded border border-gray-300 px-2 py-1 text-sm">
                </div>
                <button type="submit" class="rounded bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white">+ Tambah</button>
            </form>
        </div>

        {{-- Daftar barang yang mau ditransfer --}}
        <table class="w-full border-collapse border border-gray-300 bg-white mb-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Barang</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Qty</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cart as $barangId => $item)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['nama'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['qty'] }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <form action="{{ route('transfer-gudang.hapus', $barangId) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="text-xs text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-4 py-4 text-center text-gray-500">Belum ada barang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Form final: pilih gudang asal & tujuan --}}
        @if (count($cart) > 0)
            <form action="{{ route('transfer-gudang.store') }}" method="POST" class="bg-white rounded shadow p-4">
                @csrf
                <div class="mb-3 grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium">Gudang Asal</label>
                        <select name="gudang_asal_id" required class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                            <option value="">-- Pilih --</option>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Gudang Tujuan</label>
                        <select name="gudang_tujuan_id" required class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                            <option value="">-- Pilih --</option>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-sm font-semibold text-white">
                    Simpan Transfer
                </button>
            </form>
        @endif
    </div>
@endsection