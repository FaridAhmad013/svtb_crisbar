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
        Schema::create('opname_pre_productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->timestamp('tanggal')->default(now());
            $table->string('nama_produk', 255);
            $table->string('nama_bahan', 255);
            $table->double('qty')->default(0);
            $table->string('satuan', 5)->nullable();
            $table->double('nilai_rupiah')->default(0);
            $table->double('nilai_persatuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opname_pre_productions');
    }
};
