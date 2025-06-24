<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::where('email', 'admin@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,
            User::create([
                'username' => 'admin',
                'password' => bcrypt('rahasia'),
                'email' => 'admin@gmail.com',
                'nama_depan' => 'Admin',
                'nama_belakang' => '',
                'status' => '1',
                'role_id' => '1'
            ]);
        }

        if(!User::where('email', 'karyawan@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,

            $user = User::create([
                'username' => 'karyawan',
                'password' => bcrypt('rahasia'),
                'email' => 'karyawan@gmail.com',
                'nama_depan' => 'Karyawan',
                'nama_belakang' => '1',
                'status' => '1',
                'role_id' => '2'
            ]);

            Karyawan::create([
                'nomor_karyawan' => '00001',
                'nama_karyawan' => $user->nama_depan . ' ' . $user->nama_belakang,
                'user_id' => $user->id
            ]);
        }
    }
}
