<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'sku' => 'BRG-001',
                'nama_barang' => 'Minyak Goreng 1 Liter',
                'kategori' => 'Sembako',
                'satuan' => 'Pcs',
                'harga_pokok' => 15000,
                'harga_jual' => 18000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'BRG-002',
                'nama_barang' => 'Beras Premium 5kg',
                'kategori' => 'Sembako',
                'satuan' => 'Karung',
                'harga_pokok' => 60000,
                'harga_jual' => 68000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'BRG-003',
                'nama_barang' => 'Gula Pasir 1kg',
                'kategori' => 'Sembako',
                'satuan' => 'Pcs',
                'harga_pokok' => 13000,
                'harga_jual' => 15500,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'BRG-004',
                'nama_barang' => 'Telur Ayam 1kg',
                'kategori' => 'Sembako',
                'satuan' => 'Kg',
                'harga_pokok' => 24000,
                'harga_jual' => 28000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'BRG-005',
                'nama_barang' => 'Mie Instan Goreng',
                'kategori' => 'Makanan',
                'satuan' => 'Dus',
                'harga_pokok' => 105000,
                'harga_jual' => 120000,
                'status_aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}