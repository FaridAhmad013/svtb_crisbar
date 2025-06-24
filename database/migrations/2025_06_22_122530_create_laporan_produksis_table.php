<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_produksis', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->double('qty')->default(0);
            $table->double('nilai_bahan')->default(0);
            $table->double('nilai_laporan_per_produksi')->default(0);
            $table->string('nama_produk', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_produksis');
    }
};
