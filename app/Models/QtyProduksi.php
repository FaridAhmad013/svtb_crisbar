<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QtyProduksi extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_produk',
        'qty',
        'karyawan_id'
    ];
}
