<?php
// create_detail_transfer_gudangs_table (buat SETELAH migration di atas)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transfer_gudangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_gudang_id')->constrained('transfer_gudangs')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->unsignedInteger('qty');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transfer_gudangs');
    }
};