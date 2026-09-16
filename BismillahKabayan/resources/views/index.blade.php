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

    <div class="bg-neutral-primary-soft block max-w-sm p-6 border border-default rounded-base shadow-xs">
        <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">PT Sinar Nusantara</h5>
        <p class="text-body mb-6">Sistem manajemen persediaan barang multi-gudang, pencatatan transaksi masuk dan penjualan, serta pelaporan rekapitulasi stok secara real-time dan akurat.</p>
        <a href="{{ route('login') }}" class="inline-flex items-center text-black bg-brand box-border border focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
            Masuk Ke Sistem
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
        </a>
    </div>

</body>

</html>