<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')

    <title>Dashboard</title>
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
                                        class="rounded-md  px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                        Data Barang
                                    </a>
                                @endif

                                <a href="{{ route('barang.kasir') }}"
                                    class="rounded-md  px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                                    Kasir
                                </a>

                                <a href="{{ route('barang.riwayat') }}"
                                    class="rounded-md px-3 bg-gray-950/50 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
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
                    Riwayat
                </h1>

            </div>

        </header>

        <main>

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                {{-- isi konten --}}
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Id Barang</th>
                            <th scope="col" class="px-6 py-3 font-medium">Qty</th>
                            <th scope="col" class="px-6 py-3 font-medium">Harga</th>
                            <th scope="col" class="px-6 py-3 font-medium">SubTotal</th>
                            <th scope="col" class="px-6 py-3 font-medium">Tanggal Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr
                                class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="px-6 py-4">{{ $item->barang_id }}</td>
                                <td class="px-6 py-4">{{ $item->qty }}</td>
                                <td class="px-6 py-4">{{ $item->harga_jual_saat_transaksi }}</td>
                                <td class="px-6 py-4">{{ $item->subtotal }}</td>
                                <td class="px-6 py-4">{{ $item->created_at }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </main>

    </div>
</body>

</html>
