<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpnamePreProduction extends Model
{
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'nama_produk',
        'nama_bahan',
        'qty',
        'satuan',
        'nilai_rupiah',
        'nilai_persatuan'
    ];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class);
    }
}
