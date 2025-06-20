<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::where('role', 'Pemilik')->first()){
            Role::create([
                'role' => 'Pemilik',
                'deskripsi' => 'Jabatan Pemilik Kitchen Crisbar Melong'
            ]);
        }

        if(!Role::where('role', 'Karyawan')->first()){
            Role::create([
                'role' => 'Karyawan',
                'deskripsi' => 'Role Karyawan Kitchen Crisbar Melong'
            ]);
        }
    }
}
