<?php
// create_transfer_gudangs_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_gudangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_asal_id')->constrained('gudangs')->restrictOnDelete();
            $table->foreignId('gudang_tujuan_id')->constrained('gudangs')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_gudangs');
    }
};