@extends('layouts.app')

@section('header_title', 'Pelanggan')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Master Pelanggan</h1>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-500 text-white p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded shadow p-4 mb-6 max-w-md">
            <h2 class="font-semibold mb-3">{{ isset($pelangganDetail) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</h2>

            <form
                action="{{ isset($pelangganDetail) ? route('pelanggan.update', $pelangganDetail->id) : route('pelanggan.store') }}"
                method="POST">
                @csrf
                @if (isset($pelangganDetail))
                    @method('put')
                @endif
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $pelangganDetail->nama ?? '') }}" required
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nomor HP (opsional)</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pelangganDetail->nomor_hp ?? '') }}"
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Alamat</label>
                    <textarea name="alamat" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">{{ old('alamat', $pelangganDetail->alamat ?? '') }}</textarea>
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                    {{ isset($pelangganDetail) ? 'Update' : 'Simpan' }}
                </button>
                @if (isset($pelangganDetail))
                    <a href="{{ route('pelanggan.index') }}" class="ml-2 text-sm text-gray-600">Batal</a>
                @endif
            </form>
        </div>

        <table class="w-full border-collapse border border-gray-300 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nomor HP</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggans as $p)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $p->nama }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $p->nomor_hp ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $p->alamat ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('pelanggan.edit', $p->id) }}" class="text-xs text-indigo-600">Edit</a>
                            <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf
                                @method('delete')
                                <button class="ml-2 text-xs text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-4 text-center text-gray-500">Belum ada
                            pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
