<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->constrained('barang_masuks')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->unsignedInteger('qty');
            $table->unsignedInteger('harga_beli'); // harga beli saat itu, bisa beda2 tiap kali restock
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_barang_masuks');
    }
};