<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualans', 'gudang_id')) {
                $table->foreignId('gudang_id')->after('id')->constrained('gudangs')->restrictOnDelete();
            }

            if (!Schema::hasColumn('penjualans', 'status')) {
                $table->enum('status', ['selesai', 'dibatalkan'])->default('selesai')->after('total_harga');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            if (Schema::hasColumn('penjualans', 'gudang_id')) {
                $table->dropConstrainedForeignId('gudang_id');
            }
            if (Schema::hasColumn('penjualans', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};