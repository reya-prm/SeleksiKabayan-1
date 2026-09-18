<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'PT Sinar Nusantara' }}</title>
</head>

<body class="bg-gray-100">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-full px-4 lg:px-6">
                <div class="flex h-14 items-center justify-between gap-2">
                    
                    {{-- Judul & Menu Utama --}}
                    <div class="flex items-center gap-3 xl:gap-4">
                        <div class="text-left shrink-0 whitespace-nowrap pr-2">
                            <h1 class="text-sm font-bold text-white tracking-tight">
                                PT Sinar Nusantara
                            </h1>
                        </div>
                        
                        <div class="hidden md:block">
                            <div class="flex items-center gap-1">
                                {{-- Dashboard --}}
                                <a href="{{ route('barang.dashboard') }}"
                                    class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('barang.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Dashboard
                                </a>

                                {{-- Khusus Administrator --}}
                                @if (auth()->user()->role == 'administrator')
                                    <a href="{{ route('barang.databarang') }}"
                                        class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('barang.databarang*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                        Data Barang
                                    </a>

                                    <a href="{{ route('pelanggan.index') }}" 
                                        class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('pelanggan*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                        Master Pelanggan
                                    </a>

                                    <a href="{{ route('gudang.index') }}"
                                        class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('gudang*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                        Master Gudang
                                    </a>
                                @endif

                                {{-- Akses Bersama --}}
                                <a href="{{ route('barang-masuk.index') }}"
                                    class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('barang-masuk*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Barang Masuk
                                </a>

                                <a href="{{ route('transfer-gudang.index') }}"
                                    class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('transfer-gudang*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Transfer Gudang
                                </a>

                                <a href="{{ route('barang.kasir') }}"
                                    class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('barang.kasir*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Kasir
                                </a>

                                <a href="{{ route('barang.riwayat') }}"
                                    class="rounded-md px-2 py-1 text-xs font-medium whitespace-nowrap {{ request()->routeIs('barang.riwayat*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi User & Logout --}}
                    <div class="flex items-center gap-2 shrink-0 whitespace-nowrap">
                        <div class="text-xs text-white">
                            Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>
                            <span class="text-gray-400 capitalize">({{ auth()->user()->role }})</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="rounded-md px-2 py-1 text-xs font-medium text-red-400 hover:bg-white/10 hover:text-red-300 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>

        <header class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold tracking-tight text-white">
                    @yield('header_title', 'PT Sinar Nusantara')
                </h1>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>