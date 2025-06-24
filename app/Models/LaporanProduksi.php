<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanProduksi extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_produk',
        'qty',
        'nilai_bahan',
        'nilai_laporan_per_produksi',
    ];
}
