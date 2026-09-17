<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>PT Sinar Nusantara</title>
</head>

<body class="min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg ring-1 ring-black/5 rounded-xl p-8 w-full max-w-sm">
        <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">PT Sinar Nusantara</h5>
        <p class="text-body mb-6">Sistem manajemen persediaan barang multi-gudang, pencatatan transaksi masuk dan
            penjualan, serta pelaporan rekapitulasi stok secara real-time dan akurat.</p>
        <a href="{{ route('login') }}"
            class="w-full inline-flex items-center justify-center bg-blue-600 text-white rounded-lg py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors">
            <span>Masuk Ke Sistem</span>
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
        </a>
    </div>

</body>

</html>
