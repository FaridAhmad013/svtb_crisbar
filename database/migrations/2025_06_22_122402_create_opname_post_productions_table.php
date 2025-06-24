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
        Schema::create('opname_post_productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->timestamp('tanggal')->default(now());
            $table->string('nama_produk', 30);
            $table->string('nama_bahan', 30);
            $table->decimal('qty')->default(0);
            $table->string('satuan', 5)->nullable();
            $table->decimal('nilai_rupiah')->default(0);
            $table->decimal('nilai_persatuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opname_post_productions');
    }
};
