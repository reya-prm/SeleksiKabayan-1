@extends('layouts.app')

@section('header_title', 'Gudang ')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Master Gudang</h1>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-500 text-white p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Form Tambah/Edit, dibedain pakai isset($gudangDetail), sama kayak pola Data Barang --}}
        <div class="bg-white rounded shadow p-4 mb-6 max-w-md">
            <h2 class="font-semibold mb-3">{{ isset($gudangDetail) ? 'Edit Gudang' : 'Tambah Gudang' }}</h2>

            <form action="{{ isset($gudangDetail) ? route('gudang.update', $gudangDetail->id) : route('gudang.store') }}"
                method="POST">
                @csrf
                @if (isset($gudangDetail))
                    @method('put')
                @endif

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama Gudang</label>
                    <input type="text" name="nama_gudang"
                        value="{{ old('nama_gudang', $gudangDetail->nama_gudang ?? '') }}" required
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $gudangDetail->alamat ?? '') }}"
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                    {{ isset($gudangDetail) ? 'Update' : 'Simpan' }}
                </button>
                @if (isset($gudangDetail))
                    <a href="{{ route('gudang.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
                @endif
            </form>
        </div>

        <table class="w-full border-collapse border border-gray-300 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama Gudang</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gudangs as $g)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $g->nama_gudang }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $g->alamat ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('gudang.edit', $g->id) }}" class="text-xs text-indigo-600">Edit</a>
                            <form action="{{ route('gudang.destroy', $g->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus gudang ini?')">
                                @csrf
                                @method('delete')
                                <button class="ml-2 text-xs text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-4 py-4 text-center text-gray-500">Belum ada
                            gudang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
