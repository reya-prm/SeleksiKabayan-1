@extends('layouts.app')

@section('header_title', 'Data Barang')

@section('content')
    @if (session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg p-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (auth()->user()->role == 'administrator')
        {{-- Tabel Barang --}}
        <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200 text-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">SKU</th>
                        <th scope="col" class="px-6 py-3 font-medium">Nama Barang</th>
                        <th scope="col" class="px-6 py-3 font-medium">Kategori</th>
                        <th scope="col" class="px-6 py-3 font-medium">Satuan</th>
                        <th scope="col" class="px-6 py-3 font-medium">Harga Pokok</th>
                        <th scope="col" class="px-6 py-3 font-medium">Harga Jual</th>
                        <th scope="col" class="px-6 py-3 font-medium">Status</th>
                        <th scope="col" class="px-6 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barang as $item)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $item->sku }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $item->kategori }}</td>
                            <td class="px-6 py-4">{{ $item->satuan }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->harga_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $item->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('barang.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus {{ $item->nama_barang }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-400">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Form Tambah / Edit Barang --}}
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 max-w-xl">
            <h2 class="text-lg font-semibold mb-4">
                {{ isset($editBarang) ? 'Edit Barang' : 'Tambah Barang' }}
            </h2>

            <form action="{{ isset($editBarang) ? route('barang.update', $editBarang->id) : route('barang.store') }}" method="POST" class="space-y-4">
                @csrf
                @if (isset($editBarang))
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $editBarang->sku ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $editBarang->nama_barang ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    @error('nama_barang')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $editBarang->kategori ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Satuan</label>
                    <input type="text" name="satuan" value="{{ old('satuan', $editBarang->satuan ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Harga Pokok</label>
                    <input type="number" name="harga_pokok" value="{{ old('harga_pokok', $editBarang->harga_pokok ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Harga Jual</label>
                    <input type="number" name="harga_jual" value="{{ old('harga_jual', $editBarang->harga_jual ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="status_aktif" id="status_aktif" value="1" {{ old('status_aktif', $editBarang->status_aktif ?? true) ? 'checked' : '' }}>
                    <label for="status_aktif" class="text-sm">Aktif</label>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        {{ isset($editBarang) ? 'Update' : 'Simpan' }}
                    </button>
                    @if (isset($editBarang))
                        <a href="{{ route('barang.databarang') }}" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50 transition">Batal</a>
                    @endif
                </div>
            </form>
        </div>
    @else
        <p class="text-gray-700">Area Operator</p>
    @endif
@endsection