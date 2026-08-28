# BismillahKabayan — Aplikasi Kasir & Manajemen Barang

Aplikasi Point of Sale (POS) sederhana berbasis **Laravel**, dibuat untuk mengelola data barang dan transaksi penjualan dengan dua peran pengguna: **Administrator** dan **Operator (Kasir)**.

##  Fitur

- **Login dengan Role** — 1 sistem login, akses dibedakan berdasarkan role user (`administrator` / `operator`) memakai route middleware kustom (`role:...`).
- **Manajemen Data Barang** *(khusus Administrator)* — CRUD barang lengkap: SKU, nama, kategori, satuan, harga pokok, harga jual, dan status aktif/nonaktif.
- **Kasir / Transaksi Penjualan** *(khusus Operator)* — pilih barang ke keranjang (disimpan di session), atur qty, lalu checkout. Barang otomatis tersimpan sebagai `Penjualan` beserta rinciannya di `DetailPenjualan` (snapshot harga jual saat transaksi, biar riwayat tidak berubah walau harga barang di-update kemudian).
- **Dashboard** — ringkasan data barang setelah login.

###  Struktur data sudah disiapkan, tapi UI/logic-nya masih kosong (belum diimplementasikan):
- **Gudang** (`GudangController`, tabel `gudangs`) — baru ada migrasi & model kosong.
- **Pelanggan** (`PelangganController`, tabel `pelanggans`) — baru ada migrasi & model kosong, walau relasi ke `Penjualan` (`pelanggan_id`, nullable) sudah dipasang.

##  Tech Stack

- **Backend:** Laravel, Eloquent ORM, session-based cart
- **Frontend:** Blade Templating, Tailwind CSS 4, Vite
- **Database:** MySQL

##  Struktur Database Singkat

| Tabel | Keterangan |
|---|---|
| `users` | Ditambah kolom `role` (enum: `administrator`, `operator`) |
| `barangs` | Data master barang (sku, nama, kategori, satuan, harga pokok/jual, status aktif) |
| `penjualans` | Header transaksi (relasi ke `pelanggans` & `users`, total harga) |
| `detail_penjualans` | Rincian barang per transaksi (qty, harga saat transaksi, subtotal) |
| `pelanggans` | Data pelanggan *(belum ada UI)* |
| `gudangs` | Data gudang *(belum ada UI)* |

## Instalasi & Menjalankan Project

```bash
# 1. Install dependency PHP & JS
composer install
npm install

# 2. Copy environment file & generate app key
cp .env.example .env
php artisan key:generate

# 3. Sesuaikan koneksi database di .env
# DB_DATABASE=bismillahkabayan
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Jalankan migrasi + seeder (buat akun default & contoh data barang)
php artisan migrate --seed

# 5. Build asset frontend
npm run dev
# atau untuk production:
npm run build

# 6. Jalankan server lokal
php artisan serve
```

Aplikasi bisa diakses di `http://127.0.0.1:8000`.

## Akun Default (dari Seeder)

| Role | Email | Password |
|---|---|---|
| Administrator | `admin@sinarnusantara.test` | `password` |
| Operator | `operator@sinarnusantara.test` | `password` |

> Ganti password ini kalau aplikasi dipakai di luar lingkungan development/lokal.

## Alur Hak Akses

- **Administrator** → login → redirect ke `/dashboard` → bisa akses `/data-barang` untuk CRUD barang.
- **Operator** → login → redirect ke `/dashboard` → bisa akses `/kasir` untuk transaksi penjualan.
- Kedua role dibatasi lewat middleware `role:` (`app/Http/Middleware/CheckRole.php`), yang akan menolak akses (403) kalau role user tidak sesuai dengan yang didaftarkan di route.

## Lisensi

Project ini dibuat untuk keperluan pembelajaran, menggunakan framework [Laravel](https://laravel.com) yang open-source dengan lisensi MIT.
