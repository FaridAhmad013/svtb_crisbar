<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = [
        'nomor_karyawan',
        'nama_karyawan',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
