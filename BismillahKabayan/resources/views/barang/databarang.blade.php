<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')

    <title>Data Barang</title>
</head>

<body>
    <div class="min-h-full">

        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div class="flex h-16 items-center justify-between">

                    <div class="flex items-center">

                        <div class="shrink-0">
                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Your Company" class="size-8" />
                        </div>

                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">

                                <a href="{{ route('barang.dashboard') }}" aria-current="page"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-white">
                                    Dashboard
                                </a>

                                @if (auth()->user()->role == 'administrator')
                                    <a href="{{ route('barang.databarang') }}"
                                        class="rounded-md bg-gray-950/50 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                        Data Barang
                                    </a>
                                @endif

                            </div>
                        </div>

                    </div>

                    {{-- logout  --}}
                    <div class="flex items-center gap-4">

                        <div class="text-sm text-white">
                            Halo, {{ auth()->user()->name }}

                            <span class="text-gray-400">
                                ({{ auth()->user()->role }})
                            </span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="rounded-md px-3 py-2 text-sm font-medium text-red-400 hover:bg-white/5 hover:text-red-300">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        </nav>

        <header
            class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Data Barang
                </h1>

            </div>

        </header>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">

                @if (session('success'))
                    <div class="bg-green-50 text-green-700 border border-green-200 rounded-base p-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (auth()->user()->role == 'administrator')

                    {{-- tabel --}}
                    <div
                        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                        <table class="w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
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
                                    <tr
                                        class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                        <td class="px-6 py-4">{{ $item->sku }}</td>
                                        <td class="px-6 py-4">{{ $item->nama_barang }}</td>
                                        <td class="px-6 py-4">{{ $item->kategori }}</td>
                                        <td class="px-6 py-4">{{ $item->satuan }}</td>
                                        <td class="px-6 py-4">{{ $item->harga_pokok }}</td>
                                        <td class="px-6 py-4">{{ $item->harga_jual }}</td>
                                        <td class="px-6 py-4">
                                            {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="{{ route('barang.edit', $item->id) }}"
                                                class="text-blue-600 hover:underline">Edit</a>

                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin hapus {{ $item->nama_barang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-400">
                                            Belum ada data barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- form  --}}
                    <div class="bg-neutral-primary-soft shadow-xs rounded-base border border-default p-6 max-w-xl">
                        <h2 class="text-lg font-semibold mb-4">
                            {{ isset($editBarang) ? 'Edit Barang' : 'Tambah Barang' }}
                        </h2>

                        <form
                            action="{{ isset($editBarang) ? route('barang.update', $editBarang->id) : route('barang.store') }}"
                            method="POST" class="space-y-4">
                            @csrf
                            @if (isset($editBarang))
                                @method('PUT')
                            @endif

                            <div>
                                <label class="block text-sm font-medium mb-1">SKU</label>
                                <input type="text" name="sku" value="{{ old('sku', $editBarang->sku ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>

                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Nama Barang</label>
                                <input type="text" name="nama_barang"
                                    value="{{ old('nama_barang', $editBarang->nama_barang ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>
                                @error('nama_barang')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Kategori</label>
                                <input type="text" name="kategori"
                                    value="{{ old('kategori', $editBarang->kategori ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Satuan</label>
                                <input type="text" name="satuan"
                                    value="{{ old('satuan', $editBarang->satuan ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Harga Pokok</label>
                                <input type="number" name="harga_pokok"
                                    value="{{ old('harga_pokok', $editBarang->harga_pokok ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Harga Jual</label>
                                <input type="number" name="harga_jual"
                                    value="{{ old('harga_jual', $editBarang->harga_jual ?? '') }}"
                                    class="w-full border rounded-lg px-3 py-2" required>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="status_aktif" id="status_aktif" value="1"
                                    {{ old('status_aktif', $editBarang->status_aktif ?? true) ? 'checked' : '' }}>
                                <label for="status_aktif" class="text-sm">Aktif</label>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                    {{ isset($editBarang) ? 'Update' : 'Simpan' }}
                                </button>
                                @if (isset($editBarang))
                                    <a href="{{ route('barang.databarang') }}"
                                        class="px-4 py-2 rounded-lg border">Batal</a>
                                @endif
                            </div>
                        </form>
                    </div>
                @else
                    <p class="text-gray-700">
                        {{-- area operator  --}}
                    </p>
                @endif

            </div>
        </main>

    </div>
</body>

</html>
