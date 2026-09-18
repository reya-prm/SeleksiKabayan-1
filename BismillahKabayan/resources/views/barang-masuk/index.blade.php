@extends('layouts.app')

@section('header_title', 'Barang Masuk')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Transaksi Barang Masuk</h1>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-500 text-white p-3 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded bg-red-500 text-white p-3 text-sm">{{ session('error') }}</div>
        @endif

        {{-- Form tambah barang ke daftar sementara --}}
        <div class="bg-white rounded shadow p-4 mb-6">
            <h2 class="font-semibold mb-3">Tambah Barang</h2>
            <form action="{{ route('barang-masuk.tambah') }}" method="POST" class="flex gap-2 items-end flex-wrap">
                @csrf
                <div>
                    <label for="barang_id" class="block text-xs font-medium">Barang</label>
                    <select name="barang_id" id="barang_id" required class="rounded border border-gray-300 px-2 py-1 text-sm">
                        <option value="" disabled selected>-- Pilih Barang --</option>
                        @foreach ($barangs as $b)
                            {{-- data-harga dipakai JS di bawah buat auto-fill --}}
                            <option value="{{ $b->id }}" data-harga="{{ $b->harga_pokok }}">
                                {{ $b->nama_barang }} ({{ $b->sku }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium">Qty</label>
                    <input type="number" name="qty" min="1" value="1" required
                        class="w-20 rounded border border-gray-300 px-2 py-1 text-sm">
                </div>
                <div>
                    <label for="harga_beli" class="block text-xs font-medium">Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga_beli" min="0" required
                        class="w-28 rounded border border-gray-300 px-2 py-1 text-sm">
                </div>
                <button type="submit" class="rounded bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white">
                    + Tambah
                </button>
            </form>
        </div>

        {{-- Daftar barang yang sudah ditambahkan (belum final) --}}
        <table class="w-full border-collapse border border-gray-300 bg-white mb-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Barang</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Qty</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Harga Beli</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cart as $barangId => $item)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['nama'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['qty'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            Rp {{ number_format($item['harga_beli'], 0, ',', '.') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <form action="{{ route('barang-masuk.hapus', $barangId) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="text-xs text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-4 text-center text-gray-500">
                            Belum ada barang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Form final: pilih gudang tujuan, baru disimpan permanen --}}
        @if (count($cart) > 0)
            <form action="{{ route('barang-masuk.store') }}" method="POST" class="bg-white rounded shadow p-4">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Gudang Tujuan</label>
                    <select name="gudang_id" required class="mt-1 rounded border border-gray-300 px-3 py-2 text-sm">
                        @foreach ($gudangs as $g)
                            <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Keterangan (opsional)</label>
                    <input type="text" name="keterangan"
                        class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-sm font-semibold text-white">
                    Simpan Transaksi Barang Masuk
                </button>
            </form>
        @endif
    </div>

    <script>
    document.getElementById('barang_id').addEventListener('change', function () {
        const hargaTerakhir = this.options[this.selectedIndex].dataset.harga;
        document.querySelector('input[name="harga_beli"]').value = hargaTerakhir;
    });
</script>
@endsection