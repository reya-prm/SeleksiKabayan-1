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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="text-left shrink-0">
                            <h1 class="text-base font-bold text-white tracking-tight leading-none">PT Sinar Nusantara</h1>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('barang.dashboard') }}"
                                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('barang.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Dashboard
                                </a>

                                @if (auth()->user()->role == 'administrator')
                                    <a href="{{ route('barang.databarang') }}"
                                       class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('barang.databarang*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                        Data Barang
                                    </a>
                                @endif

                                <a href="{{ route('barang.kasir') }}"
                                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('barang.kasir*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Kasir
                                </a>

                                <a href="{{ route('barang.riwayat') }}"
                                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('barang.riwayat*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                    Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-sm text-white">
                            Halo, {{ auth()->user()->name }}
                            <span class="text-gray-400">({{ auth()->user()->role }})</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-md px-3 py-2 text-sm font-medium text-red-400 hover:bg-white/5 hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">
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