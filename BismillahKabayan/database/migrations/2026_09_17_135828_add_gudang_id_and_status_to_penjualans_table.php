<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            //dijual dari gudang mana, biar tau stok mana yang harus dikurangin
            $table->foreignId('gudang_id')->after('id')->constrained('gudangs')->restrictOnDelete();
            //buat fitur Pembatalan nanti: 'selesai' = transaksi normal, 'dibatalkan' = dibatalkan tapi datanya tetap ada
            $table->enum('status', ['selesai', 'dibatalkan'])->default('selesai')->after('total_harga');
        });
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('gudang_id');
            $table->dropColumn('status');
        });
    }
};