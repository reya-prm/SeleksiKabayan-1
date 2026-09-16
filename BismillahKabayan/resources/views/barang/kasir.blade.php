<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')

    <title>Kasir</title>
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
                                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                        Data Barang
                                    </a>
                                @endif

                                <a href="{{ route('barang.kasir') }}"
                                    class="rounded-md bg-gray-950/50 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                                    Kasir
                                </a>

                                <a href="{{ route('barang.riwayat') }}"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                    Riwayat
                                </a>

                            </div>
                        </div>

                    </div>

                    {{-- logout --}}
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
                    Dashboard
                </h1>

            </div>

        </header>

        <main>

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                {{-- isi konten --}}
                <main>
                    <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">

                        @if (session('success'))
                            <div class="bg-green-50 text-green-700 border border-green-200 rounded-base p-3 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-50 text-red-700 border border-red-200 rounded-base p-3 text-sm">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        {{-- form tambah barang --}}
                        <form action="{{ route('barang.kasir.tambah') }}" method="POST" class="flex items-end gap-3">
                            @csrf

                            <div class="flex-1">
                                <label class="block text-sm font-medium mb-1">Barang</label>
                                <select name="barang_id" class="w-full border rounded-lg px-3 py-2" required>
                                    <option value="">- Pilih Barang -</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_barang }} —
                                            Rp{{ number_format($item->harga_jual, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-28">
                                <label class="block text-sm font-medium mb-1">Qty</label>
                                <input type="number" name="qty" min="1" value="1"
                                    class="w-full border rounded-lg px-3 py-2" required>
                            </div>

                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                                Tambah
                            </button>
                        </form>

                        {{-- keranjang --}}
                        <div
                            class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                            <table class="w-full text-sm text-left rtl:text-right text-body">
                                <thead
                                    class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Nama Barang</th>
                                        <th class="px-6 py-3 font-medium">Qty</th>
                                        <th class="px-6 py-3 font-medium">Subtotal</th>
                                        <th class="px-6 py-3 font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @forelse ($cart as $barangId => $qty)
                                        @php
                                            $barangItem = $barang->firstWhere('id', (int) $barangId);
                                            $subtotal = $barangItem ? $barangItem->harga_jual * $qty : 0;
                                            $total += $subtotal;
                                        @endphp
                                        <tr
                                            class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                            <td class="px-6 py-4">{{ $barangItem->nama_barang ?? '-' }}</td>
                                            <td class="px-6 py-4">{{ $qty }}</td>
                                            <td class="px-6 py-4">Rp{{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('barang.kasir.hapus', $barangId) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                                Keranjang masih kosong.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if (!empty($cart))
                            <div class="flex items-center justify-between">
                                <p class="font-semibold">
                                    Total: Rp{{ number_format($total, 0, ',', '.') }}
                                </p>

                                <form action="{{ route('barang.kasir.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                        Proses Transaksi
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                </main>

            </div>

        </main>

    </div>
</body>

</html>
